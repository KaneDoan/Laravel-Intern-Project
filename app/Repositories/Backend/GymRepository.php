<?php

namespace App\Repositories\Backend;

use App\Models\Gym;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class GymRepository.
 */
class GymRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new Gym;
    }

    /**
     * @return string
     */
    public function model()
    {
        return Gym::class;
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc'): LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param array $data
     *
     * @return Gym
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data): Gym
    {
        return DB::transaction(function () use ($data) {
            $gym = $this->model::create([
                'name'              => $data['name'] ?? null,
                'slug'              => $data['slug'] ?? null,
                'pin'               => $data['pin'] ?? null,
                'description'       => $data['description'] ?? null,
                'no_of_displays'    => $data['no_of_displays'] ?? null,
            ]);

            return $gym;
        });
    }

    /**
     * @param Gym    $gym
     * @param array     $data
     *
     * @return Gym
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Gym $gym, array $data): Gym
    {
        return DB::transaction(function () use ($gym, $data) {

            if ($gym->update($data)) {
                return $gym;
            }
        });
    }

    /**
     * Restore the specified soft deleted resource.
     *
     * @param Gym $gym
     *
     * @return Gym
     * @throws GeneralException
     */
    public function restore(Gym $gym): Gym
    {
        if ($gym->restore()) {
            return $gym;
        }
    }
}
