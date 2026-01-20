<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Category extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];
    public function jobs(){
        return $this->hasMany(Job::class);
    }

    protected static function booted(){
        static::creating(function ($category){
            $category->slug = Str::slug($category->name). '-' .time();
        });
    }
}
