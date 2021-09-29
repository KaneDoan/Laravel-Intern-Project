<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Routine;
use Illuminate\Http\Request;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

use App\Http\Requests\Routine\ManageRoutineRequest;
use App\Http\Requests\Routine\StoreRoutineRequest;
use App\Http\Requests\Routine\UpdateRoutineRequest;
use App\Http\Resources\RoutineResource;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageRoutineRequest $request)
    {
        return QueryBuilder::for(Routine::class)

        ->allowedIncludes(['exercises'])
        ->allowedFilters([
            AllowedFilter::scope('search'),
            AllowedFilter::scope('search_by_name')
        ])
        ->allowedAppends(['video_path_url','thumbnail_path_url'])
        ->allowedSorts([
            'id',
            'name',
            'default_set',
            'timer',
            'rest_timer',
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
    public function store(StoreRoutineRequest $request)
    {
        $data = $request->all();

        $routine = Routine::create($data);

        if ($routine) {
            if ($request->hasFile('video_path_url')) {
                $routine->addMediaFromRequest('video_path_url')->toMediaCollection('routine');
            }
            if ($request->hasFile('thumbnail_path_url')){
                $routine->addMediaFromRequest('thumbnail_path_url')->toMediaCollection('routine');
            }
        }

        //return response([ 'routine' => new RoutineResource($routine), 'message' => 'Routine created successfully'], 201);

        return $routine;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Routine  $routine
     * @return \Illuminate\Http\Response
     */
    public function show(ManageRoutineRequest $request, Routine $routine)
    {
        $routine =  QueryBuilder::for(Routine::whereId($routine->id))

    	->allowedIncludes([
	        'exercises',
	    ])
    	->first();

        //return response([ 'routine' => new RoutineResource($routine), 'message' => 'Routine retrieved successfully'], 200);
        return $routine;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Routine  $routine
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoutineRequest $request, Routine $routine)
    {
        $routine->update($request->all());

        if ($routine) {
            if ($request->hasFile('thumbnail_path_url')) {
                $routine->addMediaFromRequest('thumbnail_path_url')->toMediaCollection('routine');
            }
            if ($request->hasFile('video_path_url')) {
                $routine->addMediaFromRequest('video_path_url')->toMediaCollection('routine');
            }
        }

    	return $routine->fresh();

        //return response([ 'routine' => new RoutineResource($routine), 'message' => 'Routine updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Routine  $routine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageRoutineRequest $request, Routine $routine)
    {
        $routine->delete();

        return response([ 'message' => 'Routine has been deleted' ]);
    }
}
