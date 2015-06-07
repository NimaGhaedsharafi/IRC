@layout('master')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <h2> {{ $title }} </h2>

    {{ Form::open_for_files(URL::to_route('add_discussion'), 'post')}}
    {{ Form::token() }}
    <div class="span9">
	    <div class="span3">
			<div>
				{{ Form::label('created_by', 'توسط')}}
				{{ Form::input('text', 'created_by', Input::old('created_by', Auth::User()->name), array('class' => 'span3', 'id' => 'created_by', 'disabled' => 'disabled') ) }}				

			<?php if($element == '' ) { ?>
				<?php if($errors->has('element_id') ) echo "<p class='error'>نام المان الزامی است و باید از لیست انتخاب شود.</p>"; ?>
				{{ Form::label('element_name', 'نام المان')}}
				{{ Form::input('text', 'element_name', Input::old('element_name', ''), array('class' => 'span3', 'placeholder' => 'نام المان', 'id' => 'element_name','data-provide' =>"typeahead", "autocomplete" =>"off") ) }}
				{{ Form::hidden('element_id', Input::old('element_id', ''), array('id' => 'element_id'))}}

			<?php  } else { ?>
				{{ Form::label('element_name', 'نام المان')}}
				{{ Form::input('text', 'element_name', Input::old('element_name', $element->name), array('class' => 'span3', 'id' => 'element_name', 'disabled' => 'disabled') ) }}
				{{ Form::hidden('element_id', Input::old('element_id', $element->id) , array('id' => 'element_id') ) }}
			<?php } ?>
			</div>
			<div>
			    {{ Form::label('title', 'عنوان بحث')}}
			    <?php if($errors->has('title') ) echo "<p class='error'>عنوان بحث الزامی است.</p>"; ?>
			    {{ Form::input('text', 'title', Input::old('title', ''), array('class' => 'span3', 'placeholder' => 'عنوان بحث') ) }}
			</div>
			<div id='attachments'>
				<label>پیوست <a id="attachments" href="div#attachments" onclick="javascript: addupload(); return false;" ><i 	class="icon-plus"></i> اضافه</a> </label>
				{{ Form::hidden('item', 1, ['id' => 'numUpload']); }}
				<div>{{ Form::file('attachment[]' ); }}</div>
			</div>
			<div>
				{{ Form::submit('ارسال', array('class' => 'btn btn-primary') ) }}
			</div>
    </div>
    <div class='span5' >
    	{{ Form::label('body', 'متن بحث')}}
    	<?php if($errors->has('body') ) echo "<p class='error'>متن بحث الزامی است.</p>"; ?>
    	{{ Form::textarea('body', Input::old('body',''), array( 'class' => 'span6') )}}
    </div>

    {{ Form::close() }}
    </div>
@endsection

@section('js')
{{ HTML::script('richtext/tiny_mce.js');}}
{{ HTML::script('js/ticket.js');}}

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
function addupload () {
	var item = $('#numUpload');
	console.log( item );
	if( item.val() < 5 )
	{
		var upload = '<div><input type="file" name="attachment[]"></div>';
		$('div#attachments').append(upload);
		console.warn(item.val());
		var num = item.val();
		item.val(++num);
		console.log(upload);
	}
	if( item.val() >= 5)
	{
		$('a#attachments').hide();
	}
}
</script>
@endsection