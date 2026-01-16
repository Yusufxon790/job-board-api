<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return CompanyResource::collection($companies);
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

        $validated['user_id'] = auth()->id();
        $company = Company::create($validated);

        return response()->json([
            'message' => 'Kompaniya muvaffaqiyatli yaratildi!',
            'data' => new CompanyResource($company),
        ],201);
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCompanyRequest $request, Company $company)
    {
        Gate::authorize('update',$company);
        $validated = $request->validated();

        if($request->hasFile('logo')){
            Storage::disk('public')->delete($company->logo);
            
            $path = $request->file('logo')->store('logos','public');
            $validated['logo'] = $path;
        }
        $company->update($validated);
        return response()->json([
            'message' => "Kompaniya muvaffaqiyatli o'zgartirildi!",
            'data' => new CompanyResource($company),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        Gate::authorize('delete',$company);

        if($company->logo){
            Storage::disk('public')->delete($company->logo);
        }
        $company->delete();

        return response()->json([
            'message' => "Kompaniya o'chirildi!",
        ],204);
    }
}
