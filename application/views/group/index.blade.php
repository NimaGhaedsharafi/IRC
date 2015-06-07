@layout('master')
@section('title')
    {{ $title }}
@endsection

@section('content')
<h2> {{ $title }} <button class="btn btn-primary" onclick="$('#myModal').modal();" >ایجاد</button> </h2>

<?php if(Session::get('msg') != '' ) { ?>
<br />
<div class="alert alert-info">
	{{ Session::get('msg') }}
	<a class="close" href="#" data-dismiss="alert" type="button">×</a>
</div>
<?php } ?>

<?php if( $data->results != null ) { ?>
<table class="table table-hover" >
	<thead>
	    @foreach($headers as $header => $key)
	        <td width="{{ $key->width }}" >
	        	@if($key->enabled)
				<?php
					if($orderby == $header && $dir == 'desc')
						$direction= "asc";
					else
						$direction = "desc";
				?>
	        		<a href="{{ URL::to_route($route, array($header, $direction)) }} "
	        		 <?php if($header == $orderby) 
			 			if($dir == "asc") 
				 			echo "class='dir-up'";
			 			else 
			 				echo "class='dir-down'";
						?> >
	        			{{ $key->title }}
	        		</a>
	        	@else
	        		{{ $key->title }}
	        	@endif
	        </td>
	    @endforeach
	</thead>
<?php } ?>
	@forelse($data->results as $row) 
	<tr>
		<td>{{ $row->name }}</td>
		<td>
			<div class="btn-group pull-right">
				<button class="btn">عملیات</button>
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<!-- <li><a rel="facebox" href="{{ URL::to_route('show_changelog', $row->id) }}"><i class="icon-pencil"></i>کاربران مشاهده</a></li> -->
					<li><a href="{{ URL::to_route('delete_group', $row->id) }}" onclick="return confirm('آیا از حذف این گروه اطمینان دارید؟ ')" ><i class="icon-trash"></i> حذف</a></li>
				</ul>
			</div>
		</td>
	</tr>
	@empty
		<div class="error"><h3>{{ $onEmpty }}</h3></div>
	@endforelse
	</table>


<div id="myModal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>گروه جدید</h3>
	</div>

	{{ Form::open(URL::to_route('add_group'), 'post')}}
	{{ Form::token() }}
	<div class="modal-body">		

		{{ Form::label('name' , 'نام');}}
		{{ Form::input('text', 'name', Input::old('name'), array('class' => 'span4', 'placeholder' => 'نام گروه'))}}

	</div>
	<div class="modal-footer">
		<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">لغو</button>
		<input type="submit" class="btn btn-primary" value="ذخیره" />
	</div>
	{{ Form::close() }}
</div>
@endsection
