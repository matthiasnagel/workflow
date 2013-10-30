<?php

use Illuminate\Database\Migrations\Migration;

class CreateVocabTable extends Migration {

    public function up() {
        Schema::create('vocabs', function($table) {
            $table->increments('id');
            $table->string('word')->unique();
            $table->enum('type', array('noun', 'verb', 'adjective'));
            $table->text('translations');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('vocabs');
    }

}
