<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_items', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id')->default(0);
            $table->integer('service_category_id')->default(0);
            $table->integer('client_id');
            $table->string('name', 32);
            $table->double('price', 8, 2);
            $table->integer('count')->default(1);
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
        Schema::dropIfExists('client_items');
    }
}
