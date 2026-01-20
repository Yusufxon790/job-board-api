<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::latest()->paginate(10);
        return CategoryResource::collection($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('create',Category::class);
        $validated = $request->validated();

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Kategoriya Muvafaqqiyatli kiritildi!',
            'data' => new CategoryResource($category),
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
    public function update(StoreCategoryRequest $request, Category $category)
    {
        Gate::authorize('update',Category::class);
        $validated = $request->validated();

        $category->update($validated);

        return response()->json([
            'message' => "Kategoriya muvaffaqiyatli o'zgartirildi!",
            'data' => new CategoryResource($category)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

    }
}
