<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_tasks', function (Blueprint $table) {
            $table->id();
            $table->date('generated_date');
            $table->longtext('task');
            $table->string('assigned_to',50);
            $table->string('task_status',10);
            $table->longtext('task_remarks')->nullable();
            $table->longtext('creator_task_remarks')->nullable();
            $table->string('added_by',50);
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
        Schema::dropIfExists('main_tasks');
    }
}
