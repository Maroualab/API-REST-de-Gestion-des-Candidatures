<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // User registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:15',
            'role' => 'required|string|max:50',
            'skills' => 'sometimes|array',
            'skills.*' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'phone' => $request->get('phone'),
            'role' => $request->get('role'),
        ]);

        if ($request->has('skills')) {
            $skills = collect($request->get('skills'))->map(function ($skill) {
                return Skill::firstOrCreate(['name' => $skill])->id;
            });
            $user->skills()->sync($skills);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    // User login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = auth()->user();

            // Attach the user's role to the token as a custom claim.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
    
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|required|string|max:15',
            'current_password' => 'sometimes|required_with:new_password|string',
            'new_password' => 'sometimes|required_with:current_password|string|min:6|confirmed',
            'skills' => 'sometimes|array',
            'skills.*' => 'string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->get('current_password'), $user->password)) {
                return response()->json(['error' => 'Current password is incorrect'], 400);
            }
    
            $user->password = Hash::make($request->get('new_password'));
        }
    
        $user->update($request->only(['name', 'email', 'phone']));

        if ($request->has('skills')) {
            $skills = collect($request->get('skills'))->map(function ($skill) {
                return Skill::firstOrCreate(['name' => $skill])->id;
            });
            $user->skills()->sync($skills);
        }
    
        return response()->json(['user' => $user], 200);
    }
    // Get authenticated user
    public function getUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not invalidate token'], 500);
        }
    }
}