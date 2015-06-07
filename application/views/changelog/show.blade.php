@layout('master')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <h2> {{ $title }} </h2>

<div class="span6">
	<table class="table table-hover">
		<tr>
			<td width="70px">
				عنوان
			</td>
			<td>
				{{ $info->title }}
			</td>
		</tr>
		<tr>
			<td>
				نسخه
			</td>
			<td>
				{{ $info->version }}
			</td>
		</tr>
		<tr>
			<td>
				مترتبط با
			</td>
			<td>
				{{ $info->group->name }}
			</td>
		</tr>
		<tr>
			<td>
				المان
			</td>
			<td>
				{{ $info->element->name }}
			</td>
		</tr>
		<tr>
			<td>
				توسط
			</td>
			<td>
				{{ $info->author->name }}
			</td>
		</tr>
		<tr>
			<td style="min-height:120px !important" >
				توضیحات
			</td>
			<td>
				{{ $info->description }}
			</td>
		</tr>
	</table>
</div>
@endsection
