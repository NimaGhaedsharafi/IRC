@layout('master')

@section('style')
	{{ HTML::style('facebox/facebox.css')}}
@endsection

@section('title')
	{{ $title }}
@endsection

@section('content')
<h2>{{ $title }}  <button class="btn btn-primary" onclick="$('#myModal').modal();"> کاربر جدید </button></h2>
<?php if(Session::get('msg') != '' ) { ?>
<br />
<div class="alert alert-info">
	{{ Session::get('msg') }}
	<a class="close" href="#" data-dismiss="alert" type="button">×</a>
</div>
<?php } ?>
	<table class="table table-hover">
	<thead>
@if($users->results != NULL)
		@foreach($headers as $header => $label)
			<td>
			<?php
				$dissallow = array('time' , 'operation');
				if(in_array($header,$dissallow))
					echo $label;
				else
				{
			?>
			<a href='
			{{ URL::to_route('show_users') }}/<?php echo $header; ?>/
			<?php
				if($orderby == $header && $dir == 'desc')
					echo "asc";
				else
					echo "desc";
			?>
		'
			target="_self" <?

			 if($header == $orderby) 
			 	if($dir == "asc") 
			 		echo "class='dir-up'";
			 	else 
			 		echo "class='dir-down'";
			?> ><?php echo $label ?></a>
		</td>
			<?php } ?>
		@endforeach
	@endif
	</thead>
	@forelse($users->results as $user)
		<tr>
			<td>{{ $user->name  }} </td>
			<td>{{ $user->title  }} </td>
			<td>{{ User::acl($user->acl) }} </td>
			<td>{{ Group::name($user->groups_id) }} </td>
			<td>
				<div class="btn-group">
				<button class="btn btn-small">عملیات</button>
					<button class="btn dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::to_route('view_profile', $user->id )}}"><i class="icon-eye-open"></i> نمایش پروفایل</a></li>
						<li><a rel="facebox" href="{{ URL::to_route('change_password', $user->id); }}"><i class="icon-lock"></i> تغییر رمز</a></li>
						<li><a rel="facebox" href="{{ URL::to_route('edit_user', $user->id); }}"><i class="icon-edit"></i> ویرایش کاربر</a></li>
						<li><a onclick="return confirm('آیا از حذف کاربر اطمینان دارید؟')" href="{{ URL::to_route('remove_user', $user->id ); }}"><i class="icon-trash"></i> حذف </a></li>
					</ul>
			    </div>
			</td>
		</tr>
@empty
	<p><h3 class="error">کاربری وجود ندارد!</h3></p>
@endforelse

</table>
	<div class="pagination pagination-centered">
		{{ $users->links() }}
	</div>


<div id="myModal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>کاربر جدید</h3>
	</div>

	{{ Form::open(URL::to_route('add_user'), 'post')}}
	{{ Form::token() }}
	<div class="modal-body">

		{{ Form::label('fullname' , 'نام');}}
		{{ Form::input('text', 'fullname', Input::old('fullname'), array('class' => 'span4', 'placeholder' => 'نام کاربر'))}}
		
		{{ Form::label('title' , 'عنوان');}}
		{{ Form::input('text', 'title', Input::old('title'), array('class' => 'span4', 'placeholder' => 'عنوان کاربر'))}}

		{{ Form::label('email' , 'ایمیل');}}
		{{ Form::input('text', 'email', Input::old('email'), array('class' => 'span4', 'placeholder' => 'ایمیل معتبری وارد کنید.'))}}
		
		{{ Form::label('group_id' , 'گروه');}}
		{{ Form::select('group_id', Group::dropdown(), Input::old('group_id' , '2') , array('class' => 'span4'))}}

		{{ Form::label('access' , 'سطح دسترسی');}}
		{{ Form::select('access', User::acl_dropdown(), 1 , array('class' => 'span4'))}}

	</div>
	<div class="modal-footer">
		<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">لغو</button>
		<input type="submit" class="btn btn-primary" value="ذخیره" />
	</div>
	{{ Form::close() }}
</div>
@endsection

@section('js')
{{ HTML::script('facebox/facebox.js');}}
<script type="text/javascript">
	
	$('a[rel=facebox]').facebox();
	$(".alert").alert()
	$('ul.dropdown-menu').click(function() { });
	$('.dropdown-toggle').dropdown();
</script>
@endsection