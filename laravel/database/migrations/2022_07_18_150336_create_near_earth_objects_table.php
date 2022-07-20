<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNearEarthObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('near_earth_objects', function (Blueprint $table) {
            $table->id('referenced');//2465633
            $table->string('name');//"465633 (2009 JR5)"
            $table->decimal('speed', 16, 10);//65260.6371983344
            $table->boolean('is_hazardous');
            $table->date('Date');
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
        Schema::dropIfExists('near_earth_objects');
    }
}
