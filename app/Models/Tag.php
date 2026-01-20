<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];
    public function companies(){
        return $this->morphedByMany(Company::class,'taggable');
    }
    public function jobs(){
        return $this->morphedByMany(Job::class,'taggable');
    }

    protected static function booted(){
        static::creating(function ($tag){
            $tag->slug = Str::slug($tag->name) . '-' .time();
        });
    }
}
