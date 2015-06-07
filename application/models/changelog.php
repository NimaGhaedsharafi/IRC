<?php

class Changelog extends Eloquent 
{
	public static $table = 'changelog';
	public static $new_changelog_rule = array(
		'element_id' => 'required|exists:elements,id',
		'version' => 'required|numeric',
		'dscrb' => 'required',
		'title' => 'required|min:5|max:200',
		);

	public static $new_changelog_messages = array(

		'element_id' => 'نام المان الزمی است و باید معتبر باشد.',
		'version' => 'فیلد نسخه الزامی است و باید عدد باشد.',
		'dscrb' => 'توضیحات الزامی می باشد.',
		'title' => 'عنوان الزمی می باشد و باید بین 5 تا 200 حرف باشد .',

	);
	/* Relation Start */
	public function element()
	{
		return $this->belongs_to('element','element_id');
	}

	public function group()
	{
		return $this->belongs_to('group','group_id');
	}

	public function author()
	{
		return $this->belongs_to('user', 'created_by');
	}
	/* Relation End */

	public static function index_list($order_by, $direction)
	{
		return Changelog::with(array('author', 'group','element'))->order_by($order_by, $direction)->paginate();
	}
}