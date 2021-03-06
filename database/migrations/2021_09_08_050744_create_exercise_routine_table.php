<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciseRoutineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_routines', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('exercise_id');
            $table->foreign('exercise_id')->references('id')->on('exercises')->onDelete('cascade');

            $table->unsignedBigInteger('routine_id');
            $table->foreign('routine_id')->references('id')->on('routines')->onDelete('cascade');

            $table->integer('sort_id')->default('0');
            $table->integer('display_id')->default('0');
            $table->integer('default_reps')->default('0');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_routines');
    }
}
