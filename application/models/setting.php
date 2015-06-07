<?php

class Setting extends Eloquent 
{
	public static $table = 'settings';
	public static $timestamps = false;

	public static function item($name)
	{
		$item = Setting::where('name' , 'LIKE', '%' . $name . '%')->first('value');
		return $item->value;
	}
}