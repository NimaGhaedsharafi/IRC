@layout('ajax_master')

@section('content')
    <h2> {{ $title }} </h2>

    {{ Form::open(URL::to_route('edit_user'),'post')}}
    {{ Form::token() }}
    {{ Form::hidden('id' , $user->id )}}

    {{ Form::label('name', 'نام') }}
    <?php if($errors->has('name')) echo '<div class="error">نام نمی تواند خالی باشد.</div>'; ?>
    {{ Form::input('text', 'name', Input::old('name', $user->name), array('class' => 'span5', 'placeholder' => 'نام کاربر' ) ) }}

    {{ Form::label('title', 'عنوان') }}
    <?php if($errors->has('title')) echo '<div class="error">عنوان نمی تواند خالی باشد باشد.</div>'; ?>
    {{ Form::input('text', 'title', Input::old('title', $user->title), array('class' => 'span5', 'placeholder' => 'عنوان کاربر' ) ) }}

   	{{ Form::label('email' , 'ایمیل');}}
	<?php if($errors->has('email')) echo '<div class="error">ایمیل باید یکتا و معتبر باشد.</div>'; ?>
	{{ Form::input('text', 'email', Input::old('email', $user->email), array('class' => 'span5', 'placeholder' => 'ایمیل کاربر'))}}

	<?php if(Auth::User()->acl == 0) { ?>
	{{ Form::label('group_id' , 'گروه');}}
	{{ Form::select('group_id', Group::dropdown(), Input::old('group_id' , $user->group_id) , array('class' => 'span5'))}}

	{{ Form::label('access' , 'سطح دسترسی');}}
	{{ Form::select('access', User::acl_dropdown(), Input::old('access' , $user->acl) , array('class' => 'span5'))}}
	<?php } ?>

	{{ Form::submit('ثبت', array('class' => 'btn btn-primary')) }}
	<button type="button" class="btn" onclick="$(document).trigger('close.facebox')">لغو</button>

    {{ Form::close() }}
@endsection
