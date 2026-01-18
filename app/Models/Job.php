<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Job extends Model
{
    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'slug',
        'description',
        'salary_min',
        'salary_max',
        'type'
    ];
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

    protected static function booted(){
        static::creating(function ($job){
            $job->slug = Str::slug($job->title) . '-' . time();
        });

        static::updating(function ($job) {
            if($job->isDirty('title')){
                $job->slug = Str::slug($job->title) . '-' . time();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
