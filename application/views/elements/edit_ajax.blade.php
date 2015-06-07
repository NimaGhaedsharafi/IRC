@layout('ajax_master')

@section('content')
    <h2> {{ $title }} </h2>

    {{ Form::open(URL::to_route('edit_element') , 'post')}}
    {{ Form::token() }}

    {{ Form::hidden('element_id', $element->id)}}

    {{ Form::label('name', 'نام المان') }}
    {{ Form::input('text', 'name', Input::old('name', $element->name), array('class' => 'span5', 'placeholder' => 'نام المان')  )}}
    {{ Form::submit('ثبت', array('class' => 'btn btn-primary')) }}
    <button type="button" class="btn" onclick="$(document).trigger('close.facebox')">لغو</button>

    {{ Form::close() }}

@endsection
