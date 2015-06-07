<?php

class Changelog_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index($order_by = 'id', $direction = 'desc')
	{
		$orderbyArray = array('version', 'title' ,'group_id', 'created_by');
		$dirArray = array('asc', 'desc');
		$direction = strtolower($direction);
		$order_by = strtolower($order_by);
		if(!in_array($order_by, $orderbyArray))
		{
			$orderby = 'id';
		}
		if(!in_array($direction, $dirArray))
		{
			$direction = 'desc';
		}

		$data['headers'] = array(
			'version' => new header('نسخه', '30px'),
			'title' => new header('عنوان', '120px'),
			'element_id' => new header('المان', '40px'),
			'group_id' => new header('گروه', '50px'),
			'created_by' => new header('توسط', '50px'),
			'operation' => new header('عملیات', '50px', false),
		);
		$data['data'] = Changelog::index_list($order_by, $direction);
		
		$data['route'] = 'list_changelog';
		$data['dir'] = $direction;
		$data['orderby'] = $order_by;

		$data['title'] = 'تاریخچه تغییرات';
		$data['onEmpty'] = 'هنوز تغییر رخ نداده است!';
		return View::make('changelog.index', $data) ;
	}
	public function get_add()
	{
		$data['title'] = 'تغییر جدید';
		if(Request::ajax())
			return View::make('changelog.add_ajax', $data);
		else
			return View::make('changelog.add', $data);
	}  

	public function post_add()
	{

		$input = Input::all();
		$validation = Validator::make($input, Changelog::$new_changelog_rule, Changelog::$new_changelog_messages);

		if($validation->fails())
		{
			Log::write('validation failed', 'user ('. Auth::User()->id .') try to add a changelog.');
			Input::flash();
			return Redirect::to_route('add_changelog')->with('errors', $validation->errors);
		}

		$data = array(
			'title' => $input['title'],
			'element_id' => $input['element_id'],
			'version' => $input['version'],
			'description' => $input['dscrb'],
			'group_id' => Auth::User()->groups_id,
		);

		$cl = Auth::User()->changelog()->insert($data);
		Log::write('add', 'User ('. Auth::User()->id .') add a Changelog ('. $cl->id  . ')' );
		return Redirect::to_route('list_changelog')->with('msg' ,'تغییر با موفقیت ثبت شده.');
	} 

	public function get_show($id)
	{
		$changelog = Changelog::find($id);
		if($changelog != null)
		{
			$data['info'] = $changelog;
			$data['title'] = 'نمایش تغییرات';
			return View::make('changelog.show',$data);
		}
		else
		{
			Log::write('invalid', 'User ('. Auth::User()->id .') try to see an invalid changelog ('. $id .').');
			return Redirect::to_route('invalid');
		}

	}

}