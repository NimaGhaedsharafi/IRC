@layout('master')

@section('title')
    {{$title}}
@endsection

@section('content')
<h2>{{ $title . ': ' }} <small> {{ $user->name  }} </small></h2>
<br />
<?php if(Session::get('msg') != '' ) { ?>
<div class="alert alert-info">
	{{ Session::get('msg') }}
	<a class="close" href="#" data-dismiss="alert" type="button">×</a>
</div>
<?php } ?>

    <div class="well">
	    <ul class="nav nav-tabs">
		    <li class="active"><a href="#home" data-toggle="tab">پروفایل</a></li>
<?php if(Auth::User()->acl == 0 || Auth::User()->id == $user->id){ ?>
    		<li><a href="#profile" data-toggle="tab">تعویض پسورد</a></li>
 <?php } ?>
    	</ul>
    	<div id="myTabContent" class="tab-content">
	    	<div class="tab-pane active in" id="home">
	    			<label>نام</label>
	    			<input type="text" value="{{ $user->name }}" disabled="disabled" class="input-xlarge">
	    			<label>عنوان</label>
	    			<input type="text" value="{{ $user->title }}" disabled="disabled" class="input-xlarge">
	    			<label>گروه</label>
	    			<input type="text" value="{{ $user->group->name }} "  disabled="disabled" class="input-xlarge">
	    			<label>دسترسی</label>
	    			<input type="text" value="{{ User::acl($user->acl) }}" disabled="disabled" class="input-xlarge">
	    			<label>ایمیل</label>
	    			<input type="text" value="{{ $user->email }}" disabled="disabled" class="input-xlarge">
	    		</div>
	    	<div class="tab-pane fade" id="profile">
		    	<form method="post" action="{{ URL::to_route('change_password') }}" id="tab2">
		    		{{ Form::token() }}
			    	{{ Form::hidden('id', $user->id ) }}
			    	<label>رمز عبور جدید</label>
			    	<input type="password" class="input-xlarge">
			    	<div>
			    		{{ Form::submit('بروز رسانی', array('class' => 'btn btn-primary' )) }}
			    	</div>
		    	</form>
	    	</div>
    </div>
</div>
@endsection