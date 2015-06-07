<?php

class Update_Elements_Table {    

	public function up()
    {
		Schema::table('elements', function($table) 
		{
			$table->integer('created_by');
		});

    }    

	public function down()
    {
		Schema::table('elements', function($table) 
		{
			$table->drop_column('created_by');
		});
    }

}