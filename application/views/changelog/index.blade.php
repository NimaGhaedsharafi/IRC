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
		<td>{{$row->version}}</td>
		<td>{{$row->title}}</td>
		<td>{{$row->element->name}}</td>
		<td>{{$row->group->name}}</td>
		<td>{{$row->author->name}}</td>
		<td>
			<div class="btn-group pull-right">
				<button class="btn">عملیات</button>
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a rel="facebox" href="{{ URL::to_route('show_changelog', $row->id) }}"><i class="icon-pencil"></i> مشاهده</a></li>
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
		<h3>کاربر جدید</h3>
	</div>

	{{ Form::open(URL::to_route('add_changelog'), 'post')}}
	{{ Form::token() }}
	<div class="modal-body">
		
		{{ Form::label('version' , 'نام');}}
		{{ Form::input('text', 'version', Input::old('version'), array('class' => 'span4', 'placeholder' => 'تغییر شماره'))}}
		
		{{ Form::label('title' , 'عنوان');}}
		{{ Form::input('text', 'title', Input::old('title'), array('class' => 'span4', 'placeholder' => 'عنوان تغییر'))}}

		{{ Form::label('element_name', 'نام المان')}}
		{{ Form::input('text', 'element_name', Input::old('element_name', ''), array('class' => 'span4', 'placeholder' => 'نام المان', 'id' => 'element_name','data-provide' =>"typeahead", "autocomplete" =>"off") ) }}
		{{ Form::hidden('element_id', Input::old('element_id', ''), array('id' => 'element_id'))}}

		{{ Form::label('dscrb' , 'توضیحات');}}
		{{ Form::textarea('dscrb', Input::old('dscrb', ''), array('class' => 'span4', 'placeholder' => 'توضیحات') )}}

	</div>
	<div class="modal-footer">
		<button type="button" class="btn" data-dismiss="modal" aria-hidden="true">لغو</button>
		<input type="submit" class="btn btn-primary" value="ذخیره" />
	</div>
	{{ Form::close() }}
</div>
@endsection


@section('js')

<script type="text/javascript">
var autosep = '#';

$('#element_name').typeahead({
	source: function (query, process) {
		return $.ajax({ 
			type: 'post',
			data: "name=" + query,
			url: "{{ URL::to_route('element_name') }}", 
			dataType: 'json',
			success: function (data) {
				var newdata = new Array(); 
                for (var i in data) {
                    newdata.push(
                        data[i]['id']
                      + autosep
                      + data[i]['name']
                    );
                }
                finished = true;
				process(newdata);
				}
			});
	},
	items: 5,
	minLength: 3,
	highlighter: function(item) {
	      var parts = item.split(autosep);
	      parts.shift();
	      return parts.join(autosep);
	},
	updater: function(item) {
        var parts = item.split(autosep);
        $('#element_id').val(parts.shift());
        return parts.join(autosep);
    }
});
</script>
@endsection
