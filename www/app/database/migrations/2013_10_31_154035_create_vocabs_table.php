<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVocabsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vocabs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('word', 255)->unique();
			$table->enum('type', array('noun', 'verb', 'adjective'));
			$table->text('translations');
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
		Schema::drop('vocabs');
	}

}
