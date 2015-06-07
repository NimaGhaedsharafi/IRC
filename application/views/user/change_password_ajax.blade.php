@layout('ajax_master')

@section('content')

	<form action="{{ URL::to_route('change_password')}}" method="post">
		{{ Form::token() }}
		<input type="hidden" name="id" value="{{ $id }}" >
		<label>نام کاربر<input class="span4" type="text" disabled="disabled" value="{{ $name }}"> </label>
		<label>ایمیل کاربر<input class="span4" type="text" disabled="disabled" value="{{ $email }}"> </label>
		<label>رمز عبور جدید<input name="password" class="span4" type="password" value='' palceholder="رمز عبور جدید"> </label>
		<label>تکرار رمز عبور<input name="password_confirmation" class="span4" type="password" value='' palceholder="تکرار رمز عبور جدید"> </label>
		<input type="submit" value="ذحیره" class="btn btn-primary">  
		<input type="reset" class="btn btn-danger" value="بازنویسی"></button>
	</form>
</div>

@endsection