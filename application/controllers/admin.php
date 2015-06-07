<?php

class Admin_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index()
	{
		$data = array('title' => 'پنل مدیریت');
		return View::make("admin.main",$data);
	}
	public function get_aboutus()
	{
		$data['title'] = 'درباره ی ما';
		return View::make('aboutus', $data);
	}
}