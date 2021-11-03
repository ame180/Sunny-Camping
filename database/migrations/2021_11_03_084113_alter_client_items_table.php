<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClientItemsTable extends Migration
{
    public function up()
    {
        Schema::table('client_items', function (Blueprint $table) {
            $table->integer('days')->nullable();
        });
    }

    public function down()
    {
        Schema::table('client_items', function (Blueprint $table) {
            $table->removeColumn('days');
        });
    }
}
