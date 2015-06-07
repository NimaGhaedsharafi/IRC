<?php

class Elements_Controller extends Base_Controller {

	public $restful = true;    

	public function get_add()
    {
        $data['title'] = 'المان جدید';
        return View::make('elements.add',$data);
    }   
    public function post_add()
     {
        $validation = Validator::make(Input::all(), array('name' => 'required'));
        if($validation->fails() == true)
        {
            return Redirect::to_route('add_element')->with('errors', $validation->errors);
        }
        $new_elemnet = new Element;
        $new_elemnet->name = Input::get('name');
        $new_elemnet->created_by = Auth::user()->id;
        $new_elemnet->save();
        Log::write('create', 'New element ('. $new_elemnet->id  .') created by user (' . Auth::user()->id . ')' );
        return Redirect::to_route('show_elements')->with('msg', 'با موفقیت المان اضافه شد.');

     } 

	public function get_remove($id)
    {
        $element = Element::find($id);
        if($element != null)
        {
            $element->delete();
            Log::write('delete', 'Element ('. $id .') deleted by user ('. Auth::user()->id .')');
            return Redirect::to_route('show_elements')->with('msg', 'با موفقیت المان حذف شد.');
        }
        else
        {
            return Redirect::to_route('invalid');
        }
    }

	public function get_edit($id)
    {
        $element = Element::find($id);
        if($element == null) 
        {
            Log::write('invalid' , 'user ('. Auth::user()->id .') try to edit invalid user (' . $id . ')');
            return Redirect::to_route('invalid');
        }
        $data['title'] = 'ویرایش المان';
        $data['element'] = $element;
        if(Request::ajax())
            return View::make('elements.edit_ajax',$data);
        else
            return View::make('elements.edit',$data);

    }    
    public function post_edit()
    {
        $input = Input::all();
        $validation = Validator::make(Input::all(), array('name' => 'required'));
        if($validation->fails() == true)
        {
            return Redirect::to_route('edit_element', $input['element_id'])->with('errors', $validation->errors);
        }
        $element = Element::find($input['element_id']);
        $element->name = $input['name'];
        $element->save();

        Log::wirte('Edit', 'Element('. $element->id . ') has been edited by user ('. Auth::User()->id . ')');
        return Redirect::to_route('show_elements')->with('msg', 'المان با موفقیت ویرایش شد.');
    }

	public function get_show()
    {
        $data['headers'] = array(
            'name' => 'نام', 
            'count' => 'تعداد مباحث',
            'created_by' => 'سازنده',
            'operation' => 'عملیات',
        );
        $data['elements'] = Element::show_elements();
        $data['title'] = 'المان ها';
        return View::make('elements.show', $data);
    }

    public function post_element_name()
    {
        $name = Input::get('name');
        $data = Element::where('name', 'like' , '%' . $name . '%')->get();
        $list = array();

        foreach($data as $row)
        {
            $item = array('id' => $row->id , 'name' => $row->name);
            $list[] = $item;
        }

        return Response::json( $list);
    }
}