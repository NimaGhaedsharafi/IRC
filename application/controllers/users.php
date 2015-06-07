<?php

class Users_Controller extends Base_Controller {

	public $restful = true;    

	public function get_add()
    {
        $data['title'] = 'کاربر جدید';
        return View::make('user.new_user', $data);
    }    

	public function post_add()
    {
        $input = Input::all();
        $data['email'] = $input['email'];
        
        $validation = Validator::make($input, User::$new_user_rules);

        if($validation->fails() == true)
        {
            Input::flash();
            return Redirect::to_route('add_user')->with('errors' , $validation->errors);
        }

        $data['name'] = $input['fullname'];
        $data['email'] = $input['email'];
        $password = substr(sha1(md5('codenevis') . date(time()) . $data['email'] ) , 0 , 8);
        $data['password'] = Hash::make($password);
        $data['title'] = $input['title'];
        $data['acl'] = $input['access'];
        $data['groups_id'] = $input['group_id'];

        $mail_data = array('name' => $input['fullname'], 'password' => $password, 'title' => 'اطلاعات ورود IRC','email' => $input['email']);
        $mail = new Mail($data['email'], 'mail.new_user', $mail_data);
        
        $user = User::Create($data);
        Log::write('Create' , 'New user (' . $user->id . ') created by user (' . Auth::user()->id . ')');

        return Redirect::to_route('show_users')->with('msg', 'کاربر با موفقیت اضافه شده است.');
    }

    public function get_show($order_by = 'id', $direction = 'desc')
    {
        $orderbyArray = array('name', 'title' ,'acl', 'suspend', 'groups_id');
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
            'name' => 'نام',
            'title' => 'عنوان',
            'acl' => 'دسترسی',
            'groups_id' => 'گروه',
            'operation' => 'عملیات',
        );
        $data['dir'] = $direction;
        $data['orderby'] = $order_by;
        $data['title'] = 'مدیریت کاربران';
        $data['users'] = User::show_users($order_by, $direction);

        return View::make('user.show', $data);
    }
    public function get_remove($id)
    {
        $user = User::find($id);
        if(Auth::User()->acl != 0)
        {
            Log::write('denied' , 'user ('. Auth::user()->id .') try to delete  (' . $user->id . ') but dont has desiered access');
            return Redirect::to_route('denied');
        }
        if($user != null)
        {
            $user->delete();
            Log::write('delete' , 'User (' . $user->id . ') has been deleted by user (' . Auth::user()->id . ')');
            return Redirect::to_route('show_users')->with('msg', 'کاربر با موفقیت حذف شد.');
        }
        else
        {
            Log::write('invalid' , 'user ('. Auth::user()->id .') try to delete invalid user (' . $id . ')');
            return Redirect::to_route('invalid');
        }
    }
    public function get_change_password($id = '')
    {
        $data['id'] = $id;
        if( $id == '' || Auth::user()->acl != 0)
        {
            $id = $data['id'] = Auth::User()->id; 
        }

        $user = User::find($id);
        $data['name'] = $user->name;
        $data['email'] = $user->email;

        if(Request::ajax())
        {
            return View::make('user.change_password_ajax',$data);
        }
        else
        {
            $data['title'] = 'تغییر رمز عبور';
            return View::make('user.change_password',$data);
        }
    }
    public function post_change_password()
    {
        $input = Input::all();
        $id = $input['id'];
        $user = User::find($id);

        if($user == NULL)
        {
            return Redirect::to_route('change_password');
        }       
        
        $validation = Validator::make($input, User::$change_pass_rules );
        if( $validation->fails() == true)
        {
            Input::flash();
            return Redirect::to_route('change_password', $id)->with('errors' , $validation->errors );
        }
        $user->password = Hash::make($input['password']);
        $user->save();
        Log::write('Edit' , 'User ('. $id .')\'s password has been changed by user ('. Auth::User()->id .') ');
        if(Auth::User()->acl == 0 )
            return Redirect::to_route('show_users')->with('msg' , 'رمز عبور کاربر با موفقیت تغییر پیدا کرد.' );
        else
            return Redirect::to_route('view_profile')->with('msg' , 'رمز عبور کاربر با موفقیت تغییر پیدا کرد.' );
    }

    public function get_edit($id='')
    {
        if($id != '' && Auth::User()->acl != 0)
        {
            Log::write('denied' , 'user ('. Auth::user()->id .') try to edit user (' . $user->id . ') but dont has desiered access');
            return Redirect::to_route('denied');
        }
        if($id == '')
        {
            $id = Auth::User()->id;
        }
        $user = User::find($id);
        if($user != null)
        {
            $data['user'] = $user;
            $data['title'] = 'ویرایش کاربر';
            if(Request::ajax())
                return View::make('user.edit_ajax',$data);
            else
                return View::make('user.edit',$data);
        }
        else
        {
            Log::write('invalid' , 'user ('. Auth::user()->id .') try to edit invalid user (' . $id . ')');
            return Redirect::to_route('invalid');
        }
    }
    public function post_edit()
    {
        $input = Input::all();
        $user = User::find($input['id']);
        if(Auth::User()->acl != 0 && $user->id != $input['id'])
        {
            Log::write('injection_denied' , 'user ('. Auth::user()->id .') try to inject a user id and edit user (' . $id . ')');
            return Redirect::to_route('denied');
        }
        $validation = Validator::make($input, User::get_edit_rules($input['id']));
        if($validation->fails())
        {
            Input::flash();
            return Redirect::to_route('edit_user', $input['id'])->with('errors', $validation->errors);
        }
        if($user != null)
        {
            $user->name = $input['name'];
            $user->title = $input['title'];
            $user->email = $input['email'];
            if(Auth::user()->acl == 0)
            {
                $user->groups_id = $input['group_id'];
                $user->acl = $input['access'];
            }

            $user->save();
            Log::write('Edited' , 'User ('. $user->id .') has been edited by user ('. Auth::User()->id .')') ;
            if(Auth::User()->acl == 0)
                return Redirect::to_route('show_users')->with('msg', 'کاربر با موفقیت ویرایش شد.');
            else
                return Redirect::to_route('view_profile')->with('msg', 'پروفایل شما با موفقیت ویرایش شد.');

        }
        else
        {
            Log::write('invalid' , 'user ('. Auth::user()->id .') try to edit invalid user (' . $id . ')');
            return Redirect::to_route('invalid');
        }
    }

    public function get_view_profile($id = '')
    {
        if($id == '')
            $id = Auth::User()->id;
        $user = User::find($id);

        if($user != null)
        {
            if(Request::ajax())
            {
                return View::make('user.profile_ajax', array('user' => $user));
            }
            $title = 'نمایش پروفایل';
            return View::make('user.profile', compact('title', 'user'));
        }
        else
        {
            Log::write('invalid' , 'user ('. Auth::user()->id .') try to see invalid user profile (' . $id . ')');
            return Redirect::to_route('invalid');
        }
    }
}