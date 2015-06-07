<html>
<head>
	<style>
		div.wrap {
			direction: rtl !important;
			padding: 10px;
			margin: 10px;
		}
		div.wrap img {
			margin: 5px;
			border:none;
		}
		div.wrap input {
			margin: 5px 0;
		}
	</style>
</head>
<body>

<div class="wrap">
@yield('content')

</div>
@yield('js')
</body>
</html>
