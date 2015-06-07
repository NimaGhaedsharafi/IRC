@layout('master')

@section('title')
	{{ $title }}
@endsection

@section('content')

<div class="wrap">
	{{ Form::open( URL::to_route('change_password'),'post')}}
	{{ Form::token() }}
		<input type="hidden" name="id" value="{{ $id }}" >
		<label>نام کاربر<input class="span4" type="text" disabled="disabled" value="{{ $name }}"> </label>
		<label>ایمیل کاربر<input class="span4" type="text" disabled="disabled" value="{{ $email }}"> </label>
		<label>رمز عبور جدید </label>
		<?php if($errors->has('password') )
			echo '<div class="error">پسورد الزامی است و حداقل باید بین 5 تا 15 کارکتر باشد.</div>';
		?>
		<input name="password" class="span4" type="password" value='' palceholder="رمز عبور جدید">
		<label>تکرار رمز عبور </label>
		<?php if($errors->has('password_confirmation') )
			echo '<div class="error">تکرار رمز عبور الزامی است و باید با رمز جدید یکسان باشد.</div>';
		?>
		<input name="password_confirmation" class="span4" type="password" value='' palceholder="تکرار رمز عبور جدید">

		<div>
			<input type="submit" value="ذحیره" class="btn btn-primary" />  
			<button onclick="window.location.href = '{{ URL::to_route('show_users')}}'" class="btn ">لغو</button>
		</div>
	{{ Form::close() }}
</div>	
    
@endsection