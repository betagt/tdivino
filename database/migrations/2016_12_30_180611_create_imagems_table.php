<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagemsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imagems', function(Blueprint $table) {
            $table->increments('id');
            $table->string('img');
            $table->integer('imagemtable_id')->nullable();
            $table->string('imagemtable_type')->nullable();
            $table->boolean('principal')->default(false);
            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('imagems');
	}

}
