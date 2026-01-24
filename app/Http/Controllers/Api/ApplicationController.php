<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;



class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny',Application::class);
        $user = auth()->user();

        $query = Application::with(['job.company','user']);

        if($user->role === 'candidate'){
            $query->where('user_id',$user->id);
        }
        elseif ($user->role === 'employer') {
            $query->whereHas('job.company',function ($q) use ($user){
                $q->where('user_id',$user->id);
            });
        }

        $applications = $query->latest()->paginate(15);

        return ApplicationResource::collection($applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        Gate::authorize('create',Application::class);
        $validated = $request->validated();

        if($request->hasFile('resume_path')){
            $path = $request->file('resume_path')->store('cvs','public');
            $validated['resume_path'] = $path;
        }

        $validated['user_id'] = auth()->id();
        $application = Application::create($validated);

        $application->load(['user','job']);
        return response()->json([
            'message' => "Ariza muvaffaqiaytli kiritildi!",
            'data' => new ApplicationResource($application),
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
    public function update(Request $request, Application $application)
    {
        Gate::authorize('update',$application);
        if(auth()->user()->role === 'employer'){
            $application->update($request->only('status'));
        }
        elseif ($request->hasFile('resume_path')) {
            Storage::disk('public')->delete($application->resume_path);
            $path = $request->file('resume_path')->store('cvs', 'public');
            $application->update(['resume_path' => $path]);
        }

        $application->load(['job','user']);

        return response()->json([
            'message' => "Ariza o'zgartirildi!",
            'data' => new ApplicationResource($application),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        Gate::authorize('delete',$application);

        if($application->resume_path){
            Storage::disk('public')->delete($application->resume_path);
        }

        $application->delete();

        return response()->json([
            'message' => "Ariza o'chirildi!"
        ],200);
    }
}
