<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCkycdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ckycdetails', function (Blueprint $table) {
            $table->id();
            $table->double('cifnumber');
            $table->mediumText('imagePath');
            $table->mediumText('imageNames');
            $table->date('cifdate');
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
        Schema::dropIfExists('ckycdetails');
    }
}
