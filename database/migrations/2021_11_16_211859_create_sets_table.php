<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetsTable extends Migration
{
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('prevable');
            $table->foreignId('program_id')->constrained();
            $table->string('name');
            $table->integer('day')->unsigned()->nullable();
            $table->integer('set')->unsigned()->nullable();
            $table->integer('rest_time')->unsigned()->nullable();
            $table->boolean('warm_up_set')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sets');
    }
}
