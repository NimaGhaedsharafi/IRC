@layout('master')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <h2> {{ $title }} </h2>

    <br />
<div class="span5">
    {{ Form::open(URL::to_route('add_element'),'post')}}
    {{ Form::token() }}

    <?php if($errors->has('name')) echo '<div class="error">نام المان الزامی می باشد.</div>'; ?>
    {{ Form::input('text','name', '', array('placeholder' => 'نام المان جدید', 'class' => 'span4') ) }}

    {{ Form::submit('ثبت', array('class' => 'btn btn-info')) }}


    {{ Form::close() }}
</div>
@endsection
