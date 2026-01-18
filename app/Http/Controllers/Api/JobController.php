<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Resources\JobResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Job;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Job::with(['company','category','tags']);
        $jobs = $query->latest()->paginate(10);
        return JobResource::collection($jobs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        Gate::authorize('create',Job::class);
        $company = $request->user()->companies()->first();
        $validated = $request->validated();

        $job = $company->jobs()->create($validated);

        if($request->has('tags')){
            $job->tags()->attach($request->tags);
        }
        $job->load('tags');

        return response()->json([
            'message' => "Vakansiya muvaffaqiyatli yaratildi!",
            'data' => new JobResource($job)
        ],201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
