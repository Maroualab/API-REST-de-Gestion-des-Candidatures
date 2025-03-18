<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessApplication;
use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function apply(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:job_offers,id',
            'cv_id' => 'required|exists:cvs,id',
        ]);

        $user = auth()->user();

        $application = Application::create([
            'candidate_id' => $user->id,
            'job_id' => $request->get('job_id'),
            'cv_id' => $request->get('cv_id'),
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        return response()->json(['application' => $application], 201);
    }

    public function applyToMultipleOffers(Request $request)
    {
        $request->validate([
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:job_offers,id',
            'cv_id' => 'required|exists:cvs,id',
        ]);

        $user = auth()->user();
        $applications = [];

        foreach ($request->get('job_ids') as $jobId) {
            ProcessApplication::dispatch($user->id, $jobId, $request->get('cv_id'));

        }

        return response()->json(['applications' => $applications], 201);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
