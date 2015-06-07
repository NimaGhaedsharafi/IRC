<?php

class Create_Groups_Table {    

	public function up()
	{
		Schema::create('groups', function($table) {
			$table->increments('id');
			$table->string('name');
	});

	}

	public function down()
	{
		Schema::drop('groups');
	}

}