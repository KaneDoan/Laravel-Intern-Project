<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Gym extends Model implements HasMedia
{
    use HasFactory, HasSlug, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'pin',
        'description',
        'no_of_displays',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function gymUsers()
    {
        return $this->hasMany(GymUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'gym_users')->whereNull('gym_users.deleted_at');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gym');
    }

    public function getThumbnailPathUrlAttribute(){

        $media = collect($this->media)->last();
        if (isset($media)) return $media->getUrl();
        return null;
    }

    public function scopeSearch($query, $search = '')
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%')
                  ->orWhere('pin', 'like', '%'.$search.'%');
        });
    }

    public function scopeSearchByName($query, $search = '')
    {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }

}
