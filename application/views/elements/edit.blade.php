@layout('master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <h2> {{ $title }} </h2>

    {{ Form::open(URL::to_route('edit_element') , 'post')}}
    {{ Form::token() }}

    {{ Form::hidden('element_id', $element->id)}}

    {{ Form::label('name', 'نام المان') }}
    <?php if($errors->has('name')) echo "<p class='error'>نام نمی تواند خالی باشد</p>";  ?>
    {{ Form::input('text', 'name', Input::old('name', $element->name), array('class' => 'span5', 'placeholder' => 'نام المان')  )}}
    <div>{{ Form::submit('ثبت', array('class' => 'btn btn-primary')) }}</div>

    {{ Form::close() }}

@endsection
