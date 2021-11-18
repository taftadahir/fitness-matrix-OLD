<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkoutsTable extends Migration
{
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('prevable');
            $table->foreignId('exercise_id')->constrained();
            $table->foreignId('program_id')->constrained();
            $table->foreignId('set_id')->nullable()->constrained();
            $table->integer('day')->unsigned()->nullable();
            $table->boolean('reps_based')->nullable();
            $table->integer('reps')->unsigned()->nullable();
            $table->boolean('time_based')->nullable();
            $table->integer('time')->unsigned()->nullable();
            $table->integer('set')->unsigned()->nullable();
            $table->integer('rest_time')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workouts');
    }
}
