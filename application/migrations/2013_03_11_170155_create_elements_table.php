<?php

class Create_Elements_Table {    

	public function up()
    {
		Schema::create('elements', function($table) {
			$table->increments('id');
			$table->string('name');
	});

    }    

	public function down()
    {
		Schema::drop('elements');

    }

}