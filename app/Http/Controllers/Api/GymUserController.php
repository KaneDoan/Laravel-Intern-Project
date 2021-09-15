<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GymUser;
use Illuminate\Http\Request;

use App\Http\Requests\GymUser\ManageGymUserRequest;
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
        $gymUser = GymUser::with(['user', 'gym'])->get();

        return $gymUser;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManageGymUserRequest $request, GymUser $gymUser)
    {
        $gymUser->load(['user', 'gym']);

        return response([ 'gymUser' => new GymUserResource($gymUser), 'message' => 'Gym User retrieved successfully'], 200);
    }

}
