<?php

class Create_Discussion_Table {    

	public function up()
    {
		Schema::create('discussions', function($table) {
			$table->increments('id');
			$table->string('title');
			$table->integer('views');
			$table->integer('replies');
			$table->integer('element_id');
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('discussions');

    }

}