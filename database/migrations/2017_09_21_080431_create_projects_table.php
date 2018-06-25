<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uri');
            $table->string('login');
            $table->string('host');
            $table->string('skip_uri');
            $table->string('skip_repeat');
            $table->string('skip_repeat_form');
            $table->string('x_headers');
            $table->string('testing');
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
        Schema::drop('projects');
    }
}
