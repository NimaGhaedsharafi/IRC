<?php

class Create_Settings_Table {    

	public function up()
    {
		Schema::create('settings', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->text('value');
	});

    }    

	public function down()
    {
		Schema::drop('settings');

    }

}