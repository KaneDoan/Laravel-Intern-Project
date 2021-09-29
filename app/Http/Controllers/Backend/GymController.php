<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Gym\StoreGymRequest;
use App\Http\Requests\Gym\UpdateGymRequest;
use App\Http\Requests\Gym\ManageGymRequest;
use App\Repositories\Backend\GymRepository;
use App\Events\Backend\Gym\GymCreated;
use App\Events\Backend\Gym\GymDeleted;
use App\Events\Backend\Gym\GymUpdated;
use App\Models\Gym;

class GymController extends Controller
{

    /**
     * @var GymRepository
     */
    protected $gymRepository;

    /**
     * ClientController constructor.
     *
     * @param GymRepository $clientRepository
     */
    public function __construct(GymRepository $gymRepository)
    {
        $this->gymRepository = $gymRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageGymRequest $request)
    {
        return view('backend.gym.index');
        //->withgyms($this->gymRepository->getActivePaginated(25, 'id', 'asc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ManageGymRequest $request)
    {
        return view('backend.gym.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGymRequest $request)
    {
        $this->gymRepository->create($request->only(
            'name',
            'pin',
            'no_of_displays',
            'description',
        ));

        event(new GymCreated($request));

        return redirect()->route('gyms.index')
            ->withFlashSuccess(__('gym.alerts.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ManageGymRequest $request, Gym $gym)
    {
        return view('backend.gym.show')->with('gym', $gym);
        //return view('backend.provider.show')->withGym($gym);
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
        $this->gymRepository->update($gym, $request->only(
            'name',
            'pin',
            'no_of_displays',
            'description',
        ));

        // Fire update event (GymUpdated)
        event(new GymUpdated($request));

        return redirect()->route('gyms.index')
            ->withFlashSuccess(__('this_test.alerts.updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UpdateGymRequest $request, Gym $gym)
    {
        $this->gymRepository->deleteById($gym->id);

        // Fire delete event (ProviderDeleted)
        event(new GymDeleted($request));

        return redirect()->route('gyms.destroy')
            ->withFlashSuccess(__('gym.alerts.deleted'));
    }
}
