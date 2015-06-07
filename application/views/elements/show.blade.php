@layout('master')

@section('title')
	{{ $title }}
@endsection

@section('style')
	{{ HTML::style('facebox/facebox.css') }}
@endsection

@section('content')
<h2>{{ $title }}</h2>
<?php if(Session::get('msg') != '' ) { ?>
<div class="alert alert-info">
	{{ Session::get('msg') }}
	<a class="close" href="#" data-dismiss="alert" type="button">×</a>
</div>
<?php } ?>
<?php if(empty($elements->results) == false ) { ?>
	<table class="table table-hover">
	<thead>
		@foreach($headers as $header => $label)
			<td <? if($header == 'operation') echo 'class="pull-right"' ?> >
				{{ $label }}
			</td>
		@endforeach
	</thead>
	@foreach($elements->results as $element)
		<tr>
			<td  width="200px">
				{{ $element->name }}
			</td>
			<td  width="70px">
				{{ Element::count_disc($element->id) }}
			</td>
			<td width="100px" >
				{{ User::name($element->created_by) }}
			</td>
			<td>
				<div class="btn-group pull-right">
					<button class="btn">عملیات</button>
					<button class="btn dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::to_route('add_discussion',$element->id) }}"><i class="icon-user"></i> بحث جدید</a></li>
						<?php if(Auth::User()->acl == 0) { ?>
						<li><a rel="facebox" href="{{ URL::to_route('edit_element', $element->id) }}"><i class="icon-pencil"></i> ویرایش</a></li>
						<li><a onclick="return confirm('آیا از حذف این گروه اطمینان دارید؟')" href="{{ URL::to_route("remove_element",$element->id) }}"><i class="icon-trash"></i> حذف</a></li>
						<?php } ?>
					</ul>
				</div>
			</td>
		</tr>
	@endforeach
</table>
<div class="pagination pagination-centered">
	<?php echo $elements->links(); ?>
</div>

<?php  }else { ?>
	<p><h3 class="error">هنوز المانی ساخته نشده است!!</h3></p>
<?php } ?>

<div class="span6">
	<h2>المان جدید</h2>
    {{ Form::open(URL::to_route('add_element'),'post')}}
    {{ Form::token() }}

    <?php if($errors->has('name')) echo '<div class="error">نام المان الزامی می باشد.</div>'; ?>
    {{ Form::input('text','name', '', array('placeholder' => 'نام المان جدید', 'class' => 'span5') ) }}

    {{ Form::submit('ثبت', array('class' => 'btn btn-info')) }}


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