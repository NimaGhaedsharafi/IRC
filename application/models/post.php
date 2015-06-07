<?php

class Post extends Eloquent 
{
	public static $table = 'posts';
	public static $per_page = 8;

	public static $new_post_rules = array(
		'body' => 'required',
	);

	public function author()
	{
		return Post::belongs_to('user', 'created_by');
	}

	public function discussion()
	{
		return Post::belongs_to('discussion', 'disc_id');
	}
}