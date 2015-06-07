<?php

class Group_Controller extends Base_Controller {

	public $restful = true;    

	public function get_index($order_by = 'id', $direction = 'desc')
    {
        $orderbyArray = array('id', 'name');
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
            'name' => new header('نام', null, false),
            'operation' => new header('عملیات', '100px', false),
        );
        $data['data'] = Group::order_by('id', 'desc')->paginate();
        
        $data['route'] = 'group_index';
        $data['dir'] = $direction;
        $data['orderby'] = $order_by;

        $data['title'] = 'مدیریت گروه ها';
        $data['onEmpty'] = 'هنوز گروهی ساخته نشده است!';

        return View::make('Group.index',$data);
    }

    public function post_create()
    {
        $data = array('name' => Input::get('name'));
        
        $data = Group::create($data);
        Log::write('create', 'User('. Auth::User()->id . ') create new group('. $data->id .') ');

        return Redirect::to_route('group_index')->with('msg', 'گروه با موفقیت ایجاد شد.');
    }

    public function get_destory($id)
    {
        $group = Group::find($id);

        if($group != null)
        {
            Log::write('delete', 'User ('. Auth::User()->id .') delete group('. $id .')');
            $group->delete();
            return Redirect::to_route('group_index')->with('msg', 'گروه با موفقیت حذف شد.');
        }
        else
        {
            Log::write('invalid', 'User ('. Auth::User()->id .') try to delete group with invalid id = '. $id .'');
            return Redirect::to_route('invalid');
        }

    }
}