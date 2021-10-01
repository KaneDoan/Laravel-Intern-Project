<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Exercise extends Model implements HasMedia
{
    use HasFactory, HasSlug, SoftDeletes,InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function exerciseRoutines()
    {
        return $this->hasMany(ExerciseRoutine::class);
    }

    public function routines()
    {
        return $this->belongsToMany(Routine::class, 'exercise_routines')->whereNull('exercise_routines.deleted_at');
    }

    public function getVideoPathUrlAttribute(){
        $media = collect($this->media)->first();
        if (isset($media)) return $media->getUrl();
        return null;
    }

    public function getThumbnailPathurlAttribute(){

        $media = collect($this->media)->last();
        if (isset($media)) return $media->getUrl();
        return null;
    }

    public function scopeSearch($query, $search = '')
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%')
                  ->orWhere('id', 'like', '%'.$search.'%');
        });
    }

    public function scopeSearchByName($query, $search = '')
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }

}
