<?php

class Discussion_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
	{
		$data['discs'] = Discussion::with(array('author', 'element') )->order_by('id', 'desc')->paginate();
		$data['title'] = 'لیست مباحث';
		return View::make('discussion.list',$data);
	}

	public function get_add($id = '')
	{
		$data['title'] = 'مبحث جدید';
		$data['element'] = '';
		if($id != '')
		{
			$data['element'] = Element::find($id);
		}
		return View::make('discussion.add', $data);
	}

	public function post_add()
	{
		$validation = Validator::make(Input::all(), Discussion::$new_disc_rules);

		if($validation->fails())
		{
			Input::flash();
			return Redirect::to_route('add_discussion')->with_errors($validation->errors);
		}
		else
		{
			$disc = Discussion::new_disc(Auth::User()->id, Input::all());
			if($disc)
			{
				return Redirect::to_route('discussions_list');
			}
			else
			{
				Input::flash();
				return Redirect::to_route('add_discussion');
			}
		}
	}

	public function get_show($id)
	{
		$disc = Discussion::find($id);
		if($disc != null)
		{
			$data['disc'] = $disc;
			$disc->increase_view();
			$data['posts'] = $disc->post()->paginate();
			$data['title'] = 'بحث';
			return View::make('discussion.show', $data);
		}
		else
		{
			Log::write('invalid' , 'user ('. Auth::user()->id .') try to see invalid discussion (' . $id . ')');
			return Redirect::to_route('invalid');
		}
	}
	public function post_reply_post()
	{
		$input = Input::all();

		$validation = Validator::make($input, Post::$new_post_rules);
		if($validation->fails())
		{
			Input::flash();
			Log::write('Validation' , 'user ('. Auth::user()->id .') try to send invalid info (reply) , discussion (' . $input['disc_id'] . ')');
			return Redirect::to(URL::to_route('view_discussion',array($input['disc_id'])) . '#reply' )->with('errors', $validation->errors);
		}
		$post = array(
			'body' => $input['body'],
			'disc_id' => $input['disc_id'],
		);
		
		$post = Auth::User()->post()->insert($post);
		Mail::inform_reply($input['disc_id'], array('post' => $post, 'url' => URL::to_route('view_discussion', $input['disc_id']) ,'title' => 'New Reply'));

		return Redirect::to_route('view_discussion', $input['disc_id']); ;
	}
}