<?php

namespace App\Policies;

use App\Models\User;

class CompanyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }

    public function create(User $user){
        return $user->role === "employer";
    }

    public function update(User $user,$company){
        return $user->id === $company->user_id;
    }

    public function delete(User $user,$company){
        return $user->id === $company->user_id;
    }
}
