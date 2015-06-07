<!DOCTYPE html>

<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-type" value="text/html; charset=UTF-8" />
	<title>@yield('title') </title>
	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/style.css') }}
	@yield('style')

</head>
  <body>

	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
		<div class="container-fluid">
		  <a class="brand" href="#"><h4>{{ Setting::item('company.name') }}</h4></a>
		  <div class="nav-collapse collapse">
			<p class="navbar-text pull-right">
			  خوش آمدید, {{ Auth::User()->name }} <a href="{{ URL::to_route('logout')}}" class="navbar-link">(خروج)</a>
			</p>
			<ul class="nav">
			  <li><a href="{{ URL::to_route('base') }}">صفحه اصلی</a></li>
			  <li><a href="{{ URL::to_route('view_profile') }}">نمایش پروفایل</a></li>
			</ul>
		  </div><!--/.nav-collapse -->
		</div>
	  </div>
	</div>
	<div class="container-fluid">
	  <div class="row-fluid">
		
@include('menu')

		<div class="span9 well">
			@yield('content')
		</div><!--/span-->
	  </div><!--/row-->

	  <hr>

	  <footer>
		<p>طراحی و اجرا توسط <a href="http://www.code-nevis.ir" target="_blank" >گروه برنامه نویسی کد نویس</a> نسخه 1.0 .</p>
	  </footer>

	</div><!--/.fluid-container-->
	{{ HTML::script('js/jquery.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	@yield('js')
  </body>
</html>
