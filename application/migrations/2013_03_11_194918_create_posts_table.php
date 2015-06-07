<?php

class Create_Posts_Table {    

	public function up()
    {
		Schema::create('posts', function($table) {
			$table->increments('id');
			$table->integer('disc_id');
			$table->text('body');
			$table->integer('created_by');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('posts');

    }

}