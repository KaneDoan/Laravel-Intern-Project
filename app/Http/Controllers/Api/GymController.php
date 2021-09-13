<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gym =  Gym::paginate(15);
        dd($gym);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required',
            'slug'           => 'required',
            'pin'            => 'required',
            'no_of_displays' => 'required',
        ]);

        return Gym::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Gym::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gym = Gym::find($id);
        $gym->update($request->all());
        return $gym;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Gym::destroy($id);
    }

    public function search($name)
    {
        return Gym::where('name', 'like', '%'.$name.'%')->get();
    }
}
