<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Resources\JobResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Job;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Job::with(['company','category','tags']);

        $query->when($request->type,function ($q,$type){
            return $q->byType($type);
        });
        $query->when($request->search,function ($q,$search){
            return $q->search($search);
        });

        $query->when($request->salary_min, function ($q,$salary_min){
            return $q->minSalary($salary_min);
        });

        $query->when($request->category_id,function ($q,$category_id){
            return $q->byCategory($category_id);
        });

        $query->when($request->tag_id,function ($q,$tag_id){
            return $q->byTag($tag_id);
        });
        $query->when($request->salary_min && $request->salary_max, function ($q) use ($request){
            return $q->salaryRange($request->salary_min,$request->salary_max);
        });
        $query->when($request->sort, function ($q,$sort){
            return $q->sortBy($sort);
        }, function ($q){
            return $q->latest();
        });
        $jobs = $query->paginate(10);

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
    public function show(Job $job)
    {
        $job->load(['company','category','tags']);
        return new JobResource($job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreJobRequest $request, Job $job)
    {
        Gate::authorize('update',$job);
        $validated = $request->validated();

        $job->update($validated);

        if($request->has('tags')){
            $job->tags()->sync($request->tags);
        }
        $job->load('tags');

        return response()->json([
            'message' => "Vakansiya muvaffaqiyatli o'zgartirildi!",
            'data' => new JobResource($job),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        Gate::authorize('delete',$job);

        $job->delete();

        return response()->json([
            'message' => "Vakansiya o'chirildi!",
        ],204);
    }
}
