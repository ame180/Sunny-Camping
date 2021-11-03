<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomLetterCodesToClients extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->boolean('unregistered')->default(false);
            $table->boolean('cash_register')->default(false);
            $table->boolean('terminal')->default(false);
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['unregistered', 'cash_register', 'terminal']);
        });
    }
}
