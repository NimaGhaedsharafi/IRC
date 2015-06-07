<?php

class Login_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{
		return View::make('login');
	}

	public function post_index()
	{

		if( trim(Input::get('email')) == '' || trim(Input::get('password')) == '' )
		{
			return Redirect::to_route('login_form')->with('msg', 'لطفاً اطلاعات را کامل وارد کنید.'); 
		}
		$creds = array(
			'username' => Input::get('email'),
			'password' => Input::get('password'),
			'remember' => Input::get('rememberme')
		);

		if( Auth::attempt($creds) )
		{
			$data = $this->check();
			$msg = $data['msg'];
			$route = $data['route'];
		}
		else
		{
			$msg = "اطلاعات وارد شده صحیح نمی باشد.";
			$route = "login_form";
		}
		return Redirect::to_route( $route )->with('msg', $msg);
	}

	public function check()
	{
		$data['msg'] = "با موفقیت وارد شدید.";
		$data['route'] = $this->acl();
		return $data;
	}

	public function acl()
	{
		switch ( Auth::User()->acl )
		{
			case '0':
				$route = 'admin';
				break;
			case '1':
				$route = 'staff';
				break;
			default:
				$route = 'logout';
		}
		return $route;
	}

	public function get_logout()
	{
		Auth::logout();
		return Redirect::to_route('login_form')->with('msg' , 'با موفقیت خارج شدید.');
	}
	public function get_redirect()
	{
		$data = $this->check();
		#$data = ['route' => 'admin', 'msg' => ''];
		return Redirect::to_route($data['route'])->with('msg', $data['msg']);
	}
}