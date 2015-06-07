<?php

class Group extends Eloquent 
{
	public static $table = 'groups';
	public static $timestamps = false;
	
	public static $new_group_rules = array(
		'name' => 'required',
		'admin_id' => 'required',
	 );
	public static $edit_group_rules = array(
		'name' => 'required',
	);
	
	public function users()
	{
		return $this->has_many('user', 'groups_id');
	}
	public static function name($id)
	{
		$group = Group::find($id);
		if($group)
			return $group->name;
		else
			return null;
	}	

	public static function dropdown()
	{
		return Group::lists('name', 'id') ;
	}
}