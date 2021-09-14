<?php

namespace App\Http\Controllers\Api;

use App\Models\Gym;
use App\Http\Controllers\Controller;
use App\Http\Resources\GymResource;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\Gym\StoreGymRequest;
use App\Http\Requests\Gym\UpdateGymRequest;
use App\Http\Requests\Gym\ManageGymRequest;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageGymRequest $request)
    {
        return QueryBuilder::for(Gym::class)
            ->allowedIncludes(['name', 'pin', 'no_of_displays'])
            ->allowedSorts([
                'id',
                'name',
                'pin',
                'no_of_displays',
                'created_at',
            ])

            ->paginate(request('per_page') ?? 15);

        // $gyms =  Gym::paginate(15);
        // return $gyms;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGymRequest $request)
    {
        $data = $request->all();

        // $validator = Validator::make($data, [
        //     'name' => 'required|max:255',
        //     'slug' => 'required',
        //     'pin' => 'required',
        //     'no_of_displays' => 'required'
        // ]);

        // if($validator->fails()){
        //     return response(['error' => $validator->errors(), 'Validation Error']);
        // }

        $gym = Gym::create($data);

        return response([ 'gym' => new GymResource($gym), 'message' => 'Gym created successfully'], 201);
        //return $gym;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManageGymRequest $request, Gym $gym)
    {
        return response([ 'gym' => new GymResource($gym), 'message' => 'Gym retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGymRequest $request, Gym $gym)
    {
        $gym->update($request->all());

        return response([ 'gym' => new GymResource($gym), 'message' => 'Gym updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageGymRequest $request, Gym $gym)
    {
        $gym->delete();

        return response([ 'message' => 'Gym has been deleted' ]);
    }

    // public function search(Gym $gym)
    // {
    //     return Gym::where('name', 'like', '%'.$gym.'%')->get();
    // }
}
