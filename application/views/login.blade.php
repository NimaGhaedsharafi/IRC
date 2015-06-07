<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{ 'ورود به سایت' }}</title>

    <!-- Le styles -->
    {{ HTML::style("css/bootstrap.min.css") }}
	{{ HTML::style('css/style.css')}}
    {{ HTML::style('css/login.css')}}
  </head>

  <body>
    <div class="container">
		{{ Form::open(URL::to_route('login_attempt'), 'POST' , array('class' => 'form-signin') ); }}
      	{{ Form::token( ); }}
	        <h2 class="form-signin-heading">ورود به سایت <small><h4>امروز {{ Misc::niceDate( Misc::jDateNow() ) }}</h4></small></h2>
	        <?php if(Session::get('msg') != '' ) { ?>
			<div class="alert alert-error">
				{{ Session::get('msg') }}
				<a class="close" href="#" data-dismiss="alert" type="button">×</a>
			</div>
			<?php } ?>
	        <input type="text" class="input-block-level" placeholder="ایمیل" name="email">
	        <input type="password" class="input-block-level" placeholder="رمز عبور" name="password">
	        <label class="checkbox">
	        	<input type="checkbox" name="rememberme" value="1" checked="checked" > مرا به خاطر بسپار
	        	<button id="submit" class="btn btn-large btn-primary" type="submit">ورود</button>
	        </label>
		{{ Form::close() }}

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{ HTML::script("js/jquery.js"); }}
    {{ HTML::script("js/bootstrap.min.js"); }}

    <script type="text/javascript">
		(function() {
			$(".alert").alert();
			var box = $('div.container'),
				w = $(window).width() / 2 - box.outerWidth() / 2,
				h = $(window).height() / 2 - box.outerHeight() / 2;

			box.css({
				'left': w,
				'top': h,
				'position': 'absolute',
				'duration': 500,
			});
		})();
	</script>
  </body>
</html>
