<?php

class Add_Colunm_To_Discussion_Table {    

	public function up()
    {
		Schema::table('discussions', function($table) 
		{
			$table->text('upload');
		});
    }
    
	public function down()
    {
		Schema::table('discussion', function($table)
		{
			$table->drop_column('upload');
		});
    }
}