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

        static::deleting(function ($job){
            $job->tags()->detach();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeByType($query,$type){
        return $query->where('type',$type);
    }
    public function scopeMinSalary($query,$salary){
        return $query->where('salary_min','>=',$salary);
    }
    public function scopeSearch($query,$text){
        return $query->where(function($q) use ($text) {
            $q->whereAny(['title', 'description'], 'like', "%$text%")
              ->orWhereHas('company', function ($query) use ($text) {
                  $query->where('name', 'like', "%$text%");
              });
        });
    }
    public function scopeByCategory($query,$category_id){
        return $query->where('category_id',$category_id);
    }
    public function scopeByTag($query,$tag_d){
        return $query->whereHas('tags',function ($q) use ($tag_d){
            $q->where('tags.id',$tag_d);
        });
    }
    public function scopeSalaryRange($query,$salary_min,$salary_max){
        return $query->whereBetween('salary_min',[$salary_min,$salary_max]);
    }

    public function scopeSortBy($query,$sortType){
        switch ($sortType) {
            case 'salary_high':
                return $query->orderBy('salary_min','desc');
            case 'salary_low':
                return $query->orderBy('salary_min','asc');
            case 'latest':
            default:
                return $query->latest();                
        }
    }
}
