<?php

class Create_Changelog_Table {    

	public function up()
    {
		Schema::create('changelog', function($table) {
			$table->increments('id');
			$table->integer('element_id');
			$table->integer('group_id');
			$table->string('version');
			$table->string('title');
			$table->text('description');
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
		});
    }    

	public function down()
    {
		Schema::drop('changelog');

    }

}