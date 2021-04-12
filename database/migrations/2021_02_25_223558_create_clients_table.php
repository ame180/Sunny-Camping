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
            $table->id();
            $table->string('name', 32);
            $table->date('arrival_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('comment')->nullable();
            $table->tinyInteger('discount')->default(0);
            $table->double('paid', 8, 2)->default(0);
            $table->string('status', 16)->default('unsettled');
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
