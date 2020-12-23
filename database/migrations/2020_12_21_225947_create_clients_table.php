<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->smallInteger('sector')->nullable();
            $table->smallInteger('adults')->default('0');
            $table->smallInteger('children')->default('0');
            $table->smallInteger('electricity')->default('0');
            $table->smallInteger('small_places')->default('0');
            $table->smallInteger('big_places')->default('0');
            $table->smallInteger('discount')->default('0');
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
        Schema::dropIfExists('clients');
    }
}
