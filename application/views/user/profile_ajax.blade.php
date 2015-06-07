@layout('ajax_master')


@section('content')
<table class="table table-hover" style="margin:20px">
	 <tr>
		 <td>نام: </td>
		 <td>{{ $user->name }}</td>
	 </tr>
	 <tr>
		 <td>عنوان: </td>
		 <td>{{ $user->title }}</td>
	 </tr>
	 <tr>
		 <td>ایمیل: </td>
		 <td>{{ $user->email }}</td>
	 </tr>
	 <tr>
	 	<td>تعداد مبحث ها: </td>
	 	<td>{{ $user->discussion()->count() }}</td>
	 </tr>
	 <tr>
	 	<td>تعداد پست ها: </td>
	 	<td>{{ $user->post()->count() }}</td>
	 </tr>
 </table>
@endsection
