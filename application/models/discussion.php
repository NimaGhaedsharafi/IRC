<?php

class Discussion extends Eloquent 
{
	public static $table = 'discussions';
	public static $per_page = 12;
	public static $new_disc_rules = array(

		'element_id' => 'required|exists:elements,id',
		'title' => 'required',
		'body' => 'required',
	);
	
	/* Relation Start */
	public function author()
	{
		return Discussion::belongs_to('user', 'created_by');
	}
	public function element()
	{
		return Discussion::belongs_to('element', 'element_id');
	}
	public function post()
	{
		return Discussion::has_many('post', 'disc_id');
	}
	/*  Relation End */

	public static function new_disc($id , $data)
	{
		$new_disc = array(
			'title' => $data['title'],
			'element_id' => $data['element_id'],
			'views' => 0,
			'replies' => 0,
			'updated_by' => $id,
		);
		$user = User::find($id);
		$disc = $user->discussion()->insert($new_disc);
		Log::write('create', 'New Discussion ('. $disc->id .') has been created by user('. $disc->created_by .') ');

		$new_post = array(
			'disc_id' => $disc->id,
			'body' => $data['body'],
		);

		$post = $user->post()->insert($new_post);
		Log::write('create', 'New Post ('. $post->id .') has been created by user('. $post->created_by .') ');

		return $disc && $post;
	}

	public function increase_view()
	{
		$this->views = intval($this->views) + 1;
		$this->save();
	}
}