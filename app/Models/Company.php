<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function jobs(){
        return $this->hasMany(Job::class);
    }
    public function tags(){
        return $this->morphToMany(Tag::class,'taggable');
    }
}
