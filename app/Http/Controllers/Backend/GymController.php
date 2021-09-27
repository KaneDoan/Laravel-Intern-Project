<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Gym\StoreGymRequest;
use App\Http\Requests\Gym\UpdateGymRequest;
use App\Http\Requests\Gym\ManageGymRequest;
// use App\Repositories\Backend\GymRepository;

use App\Models\Gym;

class GymController extends Controller
{

    /**
     * @var GymRepository
     */
    // protected $gymRepository;

    /**
     * ClientController constructor.
     *
     * @param GymRepository $clientRepository
     */
    // public function __construct(GymRepository $gymRepository)
    // {
    //     $this->gymRepository = $gymRepository;
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageGymRequest $request)
    {
        return view('backend.gym.index');
        // ->withgyms($this->gymRepository->getActivePaginated(25, 'id', 'asc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageGymRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGymRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManageGymRequest $request, Gym $gym)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UpdateGymRequest $request, Gym $gym)
    {
        //
    }
}
