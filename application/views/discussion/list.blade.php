@layout('master')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <h2> {{ $title }} <a href="{{ URL::to_route('add_discussion') }}"><button class="btn btn-primary" >ایجاد بحث</button></a> </h2>
<?php if(empty($discs->results) == false) { ?>
<table class="table table-hover">
<thead>
	<td width="400px" >عنوان</td>
	<td width="40px" >پاسخ</td>
	<td width="40px" >بازدید </td>
	<td width="150px;">المان</td>
	<td  >آخرین فعالیت</td>
</thead>
@foreach($discs->results as $disc)
<tr>
	<td><a href="{{ URL::to_route('view_discussion', $disc->id ) }}">{{ $disc->title }}</a></td>
	<td> {{ $disc->post()->count() - 1 }} </td>
	<td> {{ $disc->views }} </td>
	<td>{{ $disc->element->name  }}</td>
	<td>
		{{ User::name($disc->updated_by) }} - {{ Misc::NiceDateTS($disc->updated_at) }}<br />
	</td>
</tr>
@endforeach
</table>
<?php } else { ?>
<p><h3 class="error">هنوز مبحثی ساخته نشده است!!</h3></p>
<?php } ?>

<div class="pagination pagination-centered">
	{{ $discs->links() }}
</div>

@endsection

