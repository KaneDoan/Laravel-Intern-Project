<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Exercise extends Model implements HasMedia
{
    use HasFactory, HasSlug, SoftDeletes, InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this
        ->addMediaCollection('exercise_thumbnail')
        ->acceptsFile(function (File $file) {
            return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/gif', 'image/tiff']);
        });

        $this
        ->addMediaCollection('exercise_video')
        ->acceptsFile(function (File $file) {
            return in_array($file->mimeType, ['video/mp4', 'video/mpeg', 'video/ogg']);
        });
    }

    public function getVideoPathUrlAttribute(){
        $media = collect($this->media->where('collection_name','exercise_video'))->last();
        if (isset($media)) return $media->getUrl();
        return null;
    }

    public function getThumbnailPathUrlAttribute(){

        $media = collect($this->media->where('collection_name','exercise_thumbnail'))->last();
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
