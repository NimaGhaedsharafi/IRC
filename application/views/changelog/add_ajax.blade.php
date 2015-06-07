@layout('ajax_master')

@section('content')
    <h2> {{ $title }} </h2>

<div id="myModal" class="">
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