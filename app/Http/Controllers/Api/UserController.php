<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ManageUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (!Auth::user()->is_admin) return Auth::user();

        return QueryBuilder::for(User::class)
            ->allowedIncludes(['gyms'])
            ->allowedFilters([
                AllowedFilter::scope('search'),
                AllowedFilter::scope('search_by_name')
            ])
            ->allowedSorts([
                'id',
                'full_name',
                'email',
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
    public function store(StoreUserRequest $request)
    {

        $data = $request->all();

        // $validator = Validator::make($data, [
        //     'full_name' => 'required|string|max:255',
        //     'email' => 'required|string|unique:users,email',
        //     'password' => 'required|string|confirmed'
        // ]);

        // if($validator->fails()){
        //     return response([ 'error' => $validator->errors(), 'Validation Error' ]);
        // }

        // $data = array(

        //     "full_name"=>$request->full_name,
        //     "email"=>$request->email,
        //     "password"=>bcrypt($request->password),

        // );

        $user = User::create($data);

        return response([ 'user' => new UserResource($user), 'message' => 'User Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(ManageUserRequest $request, User $user)
    {
        $user =  QueryBuilder::for(User::whereId($user->id))
    			->allowedIncludes([
	    			'gyms',
	    		])
    			->first();

        return response([ 'user' => new UserResource($user), 'message' => 'User retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        return response([ 'user' => new UserResource($user), 'message' => 'User updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageUserRequest $request, User $user)
    {
        $user->delete();

        return response(['message' => 'User has been deleted']);
    }
}
