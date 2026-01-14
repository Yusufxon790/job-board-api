<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        Gate::authorize('create',Company::class);
        $validated = $request->validated();
        
        if($request->hasFile('logo')){
            $path = $request->file('logo')->store('logos','public');
            $validated['logo'] = $path;
        }

        $validated['slug'] = Str::slug($request->name);

        $validated['user_id'] = auth()->id();
        $company = Company::create($validated);

        return response()->json([
            'message' => 'Kompaniya muvaffaqiyatli yaratildi!',
            'data' => $company
        ],210);
        
        
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
