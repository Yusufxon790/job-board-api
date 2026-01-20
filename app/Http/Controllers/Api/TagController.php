<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Tag;



class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        Gate::authorize('create',Tag::class);
        $validated = $request->validated();

        $tag = Tag::create($validated);

        return response()->json([
            'message' => "Tag muvaffaqiyatli kiritildi!",
            'data' => new TagResource($tag)
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
    public function update(StoreTagRequest $request, Tag $tag)
    {
        Gate::authorize('update',Tag::class);
        $validated = $request->validated();

        $tag->update($validated);

        return response()->json([
            'message' => "Tag muvaffaqiyatli o'zgartirildi!",
            'data' => new TagResource($tag),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
