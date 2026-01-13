<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function applications(){
        return $this->hasMany(Application::class);
    }
    public function tags(){
        return $this->morphToMany(Tag::class,'taggable');
    }
}
