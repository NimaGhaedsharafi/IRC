<?php

class Element extends Eloquent 
{
	public static $table = 'elements';
	public static $timestamps = false;
	public static $per_page = 12;

	public static function show_elements()
	{
		return Element::order_by('id', 'desc')->paginate();
	}
	public function discussion()
    {
        return $this->has_many('discussion', 'element_id');
    }
    public static function count_disc($id)
    {
        return Element::find($id)->discussion()->count();
    }
}