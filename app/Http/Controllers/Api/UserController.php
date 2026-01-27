<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function me(Request $request){
        return new UserResource($request->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view',$user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        Gate::authorize('update',$user);

        $validated = $request->validate([
            'name' => ['sometimes','string','max:255'],
            'phone' => ['sometimes','string','max:50'],
            'avatar' => ['sometimes','image','mimes:png,jpg,jpeg','max:2048']
        ]);

        if($request->hasFile('avatar')){
            if($user->avatar){
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars','public');
            $validated['avatar'] = $path;
        }
        $user->update($validated);

        return response()->json([
            'message' => 'Profil muvaffaqiyatli yangilandi!',
            'data' => new UserResource($user),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
