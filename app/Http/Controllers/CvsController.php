<?php

namespace App\Http\Controllers;

use App\Models\Cvs;
use App\Http\Requests\StoreCvsRequest;
use App\Http\Requests\UpdateCvsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CvsController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCvsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cvs $cvs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cvs $cvs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCvsRequest $request, Cvs $cvs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cvs $cvs)
    {
        //
    }

    public function upload(Request $request)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $user = auth()->user();
        $file = $request->file('cv');
        $filePath = $file->store('cvs', 'public');
        $fileType = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        $cv = Cvs::create([
            'candidate_id' => $user->id,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'summary' => $request->get('summary'),
        ]);

        return response()->json(['message' => 'CV uploaded successfully', 'cv' => $cv], 201);
    }
}
