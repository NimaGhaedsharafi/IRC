<?php

class User extends Eloquent 
{
	public static $table = 'users';
	public static $hidden = array('password');
	public static $per_page = 12;
	
	public static $new_user_rules = array(
		'fullname'  => 'required|max:50',
		'title' => 'required',
		'email' => 'required|email|unique:users',
	);

	public static $change_pass_rules = array(
		'password' => 'required|min:5|max:15',
		'password_confirmation' => 'required|same:password',
	);
	public static $edit_user_rules = array(
		'name'  => 'required|max:50',
		'title' => 'required',
	);

	public static function get_edit_rules($id)
	{
		return array_merge(array('email' => 'required|email|unique:users,email,'.$id) , User::$edit_user_rules);
	}
	public static function name($id)
	{
		$user = User::find($id);
		if($user)
			return $user->name;
		else
			return null;
	}
	public static function show_users($order_by, $direction)
	{
		return User::order_by($order_by, $direction)->paginate();
	}
	public static function acl($id)
	{
		switch ($id)
		{
			case 0:
				$label = 'admin';
				break;
			case 1:
				$label = 'staff';
				break;
		}
		return Setting::item('users.acl.' . $label);
	}
	public static function acl_dropdown()
	{
		return array(
			'0' => User::acl(0),
			'1' => User::acl(1),
		);
	}
	
	/* Relations:Start */
	public function discussion()
	{
		return $this->has_many('discussion', 'created_by');
	}
	public function post()
	{
		return $this->has_many('post', 'created_by');
	}
	public function group()
	{
		return $this->belongs_to('group', 'groups_id');
	}
	public function changelog()
	{
		return $this->has_many('changelog', 'created_by');
	}
	/* Relations:End */
}