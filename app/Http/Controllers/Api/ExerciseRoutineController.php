<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExerciseRoutine;
use Illuminate\Http\Request;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

use App\Http\Requests\ExerciseRoutine\ManageExerciseRoutineRequest;
use App\Http\Requests\ExerciseRoutine\StoreExerciseRoutineRequest;
use App\Http\Requests\ExerciseRoutine\UpdateExerciseRoutineRequest;
use App\Http\Resources\ExerciseRoutineResource;

class ExerciseRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageExerciseRoutineRequest $request)
    {
        $exerciseRoutine =  QueryBuilder::for(ExerciseRoutine::class)

        ->allowedIncludes([
            'exercise',
            'routine',
        ])

        ->allowedSorts([
            'id',
            'sort_id',
            'display_id',
            'default_reps',
            'created_at',
        ])

        ->paginate(request('per_page') ?? 15);

        return $exerciseRoutine;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExerciseRoutineRequest $request)
    {
        $data = $request->all();

        $exerciseRoutine = ExerciseRoutine::create($data);

        return response(

        [
            'exercise_routine' => new ExerciseRoutineResource($exerciseRoutine),
            'message' => 'Exercise routine created successfully'

        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExerciseRoutine  $exerciseRoutine
     * @return \Illuminate\Http\Response
     */
    public function show(ManageExerciseRoutineRequest $request, ExerciseRoutine $exerciseRoutine)
    {
        //$exerciseRoutine = ExerciseRoutine::with(['exercise', 'routine'])->get();
        $exerciseRoutine =  QueryBuilder::for(ExerciseRoutine::whereId($exerciseRoutine->id))

        ->allowedIncludes([
            'exercise',
            'routine',
        ])
        ->first();

        return response(

        [
            'exercise_routine' => new ExerciseRoutineResource($exerciseRoutine),
            'message' => 'Exercise routine retrieved successfully'

        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExerciseRoutine  $exerciseRoutine
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExerciseRoutineRequest $request, ExerciseRoutine $exerciseRoutine)
    {
        $exerciseRoutine->update($request->all());

        return response(

        [
            'exercise_routine' => new ExerciseRoutineResource($exerciseRoutine),
            'message' => 'Exercise routine updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExerciseRoutine  $exerciseRoutine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageExerciseRoutineRequest $request, ExerciseRoutine $exerciseRoutine)
    {
        $exerciseRoutine->delete();

        return response([ 'message' => 'Exercise routine has been deleted' ]);
    }
}
