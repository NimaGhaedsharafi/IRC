<?php

class Create_User_Table {    

	public function up()
    {
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('email', 100);
			$table->string('password');
			$table->string('name',100);
			$table->string('title');
			$table->string('groups_id');
			$table->integer('acl');
			$table->timestamps();
	});

    }    

	public function down()
    {
		Schema::drop('users');

    }

}