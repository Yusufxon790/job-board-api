<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Company extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'description',
        'website',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function jobs(){
        return $this->hasMany(Job::class);
    }
    public function tags(){
        return $this->morphToMany(Tag::class,'taggable');
    }

    protected static function booted(){
        static::creating(function ($company){
            $company->slug = Str::slug($company->name). '-' .time();
        });

        static::updating(function ($company){
            if($company->isDirty('name')){
                $company->slug = Str::slug($company->name). '-' .time();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
