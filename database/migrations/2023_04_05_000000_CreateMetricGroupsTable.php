<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('metric_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->integer('order');
            $table->tinyInteger('visible');

            $table->index('order');
            $table->index('visible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('metric_groups');
    }
}
