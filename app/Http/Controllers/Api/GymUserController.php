<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GymUser;
use Illuminate\Http\Request;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

use App\Http\Requests\GymUser\ManageGymUserRequest;
use App\Http\Requests\GymUser\StoreGymUserRequest;
use App\Http\Requests\GymUser\UpdateGymUserRequest;

use App\Http\Resources\GymUserResource;

class GymUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageGymUserRequest $request)
    {
        $gymUser =  QueryBuilder::for(GymUser::class)

        ->allowedIncludes([
            'gyms',
            'users',
        ])

        ->allowedSorts([
            'id',
            'created_at',
        ])

        ->paginate(request('per_page') ?? 15);

        return $gymUser;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGymUserRequest $request)
    {
        $data = $request->all();

        $gymUser = GymUser::create($data);

        return response(

        [
            'gym_user' => new GymUserResource($gymUser),
            'message' => ' Gym user routine created successfully'

        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManageGymUserRequest $request, GymUser $gymUser)
    {
        //$gymUser->load(['user', 'gym']);
        $gymUser =  QueryBuilder::for(GymUser::whereId($gymUser->id))

        ->allowedIncludes([
            'gyms',
            'users',
        ])

        ->first();

        return response([ 'gymUser' => new GymUserResource($gymUser), 'message' => 'Gym user retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExerciseRoutine  $exerciseRoutine
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateGymUserRequest $request, GymUser $gymUser)
    {
        $gymUser->update($request->all());

        return response(

        [
            'gym_user' => new GymUserResource($gymUser),
            'message' => 'Gym user routine updated successfully'

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExerciseRoutine  $exerciseRoutine
     * @return \Illuminate\Http\Response
     */

    public function destroy(ManageGymUserRequest $request, GymUser $gymUser)
    {
        $gymUser->delete();

        return response([ 'message' => 'Gym user has been deleted' ]);
    }

}
