<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index()
    {
        $jobOffers = JobOffer::all();
        return response()->json(['job_offers' => $jobOffers]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'contract_type' => 'required|string',
            'category' => 'required|string',
            'salary' => 'nullable|integer',
            'recruiter_id' => 'required|exists:users,id',
        ]);

        $jobOffer = JobOffer::create($request->all());

        return response()->json(['job_offer' => $jobOffer], 201);
    }

    public function update(Request $request, $id)
    {
        $jobOffer = JobOffer::findOrFail($id);

        $request->validate([
            'title' => 'string',
            'description' => 'string',
            'location' => 'string',
            'contract_type' => 'string',
            'category' => 'string',
            'salary' => 'int',
        ]);

        $jobOffer->update($request->only(['title', 'description', 'location', 'contract_type', 'category' , 'salary']));

        return response()->json(['job_offer' => $jobOffer]);
    }

    public function destroy($id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        $jobOffer->delete();

        return response()->json(['message' => 'Job offer deleted successfully']);
    }

}
