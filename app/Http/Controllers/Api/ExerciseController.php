<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

use App\Http\Requests\Exercise\ManageExerciseRequest;
use App\Http\Requests\Exercise\StoreExerciseRequest;
use App\Http\Requests\Exercise\UpdateExerciseRequest;
use App\Http\Resources\ExerciseResource;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageExerciseRequest $request)
    {
        return QueryBuilder::for(Exercise::class)
        ->allowedIncludes(['routines'])
        ->allowedFilters([
            AllowedFilter::scope('search_by_name')
        ])
        ->allowedAppends(['video_path_url','thumbnail_path_url'])
        ->allowedSorts([
            'id',
            'name',
            'created_at',
        ])
        ->paginate(request('per_page') ?? 15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExerciseRequest $request)
    {
        $data = $request->all();

        $exercise = Exercise::create($data);

        if ($exercise) {
            if ($request->hasFile('video_path_url')) {
                $exercise->addMediaFromRequest('video_path_url')->toMediaCollection('exercise');
            }
            if ($request->hasFile('thumbnail_path_url')){
                $exercise->addMediaFromRequest('thumbnail_path_url')->toMediaCollection('exercise');
            }

        }

        //$exercise->addMedia(storage_path('media/beach.jpg'))->toMediaCollection('exercise');



        return response([ 'exercise' => new ExerciseResource($exercise), 'message' => 'Exercise created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function show(ManageExerciseRequest $request, Exercise $exercise)
    {
        $exercise =  QueryBuilder::for(Exercise::whereId($exercise->id))

        ->allowedIncludes([
            'routines',
        ])
        ->first();

        return response([ 'exercise' => new ExerciseResource($exercise), 'message' => 'Exercise retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->all());

        if ($exercise) {
            if ($request->hasFile('thumbnail_path_url')) {
                $exercise->addMediaFromRequest('thumbnail_path_url')->toMediaCollection('exercise');
            }
        }

    	return $exercise->fresh();

        //return response([ 'exercise' => new ExerciseResource($exercise), 'message' => 'Exercise updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageExerciseRequest $request, Exercise $exercise)
    {
        $exercise->delete();

        return response([ 'message' => 'Exercise has been deleted' ]);
    }
}
