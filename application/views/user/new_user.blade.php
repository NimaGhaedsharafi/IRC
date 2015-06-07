@layout('master')

@section('title')
	{{ $title }}
@endsection

@section('content')
{{ var_dump($errors) }}
<h2>کاربر جدید</h2>
{{ Form::open(URL::to_route('add_user'), 'post')}}
{{ Form::token() }}
<div class="modal-body">

	{{ Form::label('fullname' , 'نام');}}
	<?php if($errors->has('fullname')) echo '<div class="error">نام الزامی است.</div>'; ?>
	{{ Form::input('text', 'fullname', Input::old('fullname'), array('class' => 'span4', 'placeholder' => 'نام کاربر'))}}
	
	{{ Form::label('title' , 'عنوان');}}
	<?php if($errors->has('title')) echo '<div class="error">عنوان الزامی است.</div>'; ?>
	{{ Form::input('text', 'title', Input::old('title'), array('class' => 'span4', 'placeholder' => 'عنوان کاربر'))}}

	{{ Form::label('email' , 'ایمیل');}}
	<?php if($errors->has('email')) echo '<div class="error">ایمیل باید یکتا و معتبر باشد.</div>'; ?>
	{{ Form::input('text', 'email', Input::old('email', ''), array('class' => 'span4', 'placeholder' => 'ایمیل کاربر'))}}

	{{ Form::label('group_id' , 'گروه');}}
	{{ Form::select('group_id', Group::dropdown(), Input::old('group_id' , '2') , array('class' => 'span4'))}}

	{{ Form::label('access' , 'سطح دسترسی');}}
	{{ Form::select('access', User::acl_dropdown(), Input::old('access' , '2') , array('class' => 'span4'))}}

	<div> <input type="submit" class="btn btn-primary" value="ذخیره" /></div>
	{{ Form::close() }}
</div>
@endsection