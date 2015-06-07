@layout('master')

@section('title')
	{{ $title }}
@endsection

@section('content')
    <h2> {{ $title }} </h2>

	{{ Form::open(URL::to_route('add_changelog'), 'post')}}
	{{ Form::token() }}
	<div>
		{{ Form::label('version' , 'نسخه');}}
		<?php if($errors->has('version')) echo '<p class="error">' . 'فیلد نسخه الزامی است و باید عددی باشد.'  . '</p>'; ?>
		{{ Form::input('text', 'version', Input::old('version'), array('class' => 'span4', 'placeholder' => 'تغییر نسخه'))}}
		
		{{ Form::label('title' , 'عنوان');}}
		<?php if($errors->has('title')) echo '<p class="error">' . 'عنوان الزامی می باشد و باید بین 5 تا 200 حرف باشد.'. '</p>'; ?>
		{{ Form::input('text', 'title', Input::old('title'), array('class' => 'span4', 'placeholder' => 'عنوان تغییر'))}}

		{{ Form::label('element_name', 'نام المان')}}
		<?php if($errors->has('element_id')) echo '<p class="error">' . 'نام المان الزمی است و باید معتبر باشد.' . '</p>'; ?>
		{{ Form::input('text', 'element_name', Input::old('element_name', ''), array('class' => 'span4', 'placeholder' => 'نام المان', 'id' => 'element_name','data-provide' =>"typeahead", "autocomplete" =>"off") ) }}
		{{ Form::hidden('element_id', Input::old('element_id', ''), array('id' => 'element_id'))}}

		{{ Form::label('dscrb' , 'توضیحات');}}
		<?php if($errors->has('dscrb')) echo '<p class="error">' . 'توضیحات الزامی می باشد.' . '</p>'; ?>
		{{ Form::textarea('dscrb', Input::old('dscrb', ''), array('class' => 'span4', 'placeholder' => 'توضیحات') )}}

	</div>
	<div>
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