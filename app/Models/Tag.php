<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function companies(){
        return $this->morphedByMany(Company::class,'taggable');
    }
    public function jobs(){
        return $this->morphedByMany(Job::class,'taggable');
    }
}
