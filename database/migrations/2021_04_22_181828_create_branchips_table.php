<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchips', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('bcode');
            $table->string('branchname','50');
            $table->string('region','50');
            $table->ipAddress('serverip');
            $table->ipAddress('routerip');
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
        Schema::dropIfExists('branchips');
    }
}
