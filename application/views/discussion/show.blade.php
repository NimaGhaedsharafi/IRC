@layout('master')
@section('title')
    {{ $title }}
@endsection

@section('style')
    {{ HTML::style('css/posts.css') }}
    <style type="text/css">
    .pagination {
    	margin: 10px;
    	margin-bottom: 2px;
    	float:left;
    	clear:both;
    }
    .answer {
    	clear:both;	
    }
    </style>
@endsection

@section('content')
    <h2> {{ $title }} <small>{{ $disc->title }}</small> </h2>

<div class="pagination pagination-right pagination-small">
    {{ $posts->links() }}
</div>

@foreach($posts->results as $post)

<div class="postbody">

	<div class="header">
		{{ Misc::NiceDateTS($post->created_at) }}
	</div>
	<div class="author_info">
		<dl>
			<dt><strong><a data-toggle="popover" data-poload="{{ URL::to_route('view_profile', $post->author->id) }}" href="{{ URL::to_route('view_profile', $post->author->id) }}">{{ $post->author->name }}</a></strong></dt> 
			<dd class="usertitle">عنوان: {{ $post->author->title }}</dd>
			<dd class="usercontacts"><span class="email">ایمیل: <a href="mailto:{{ $post->author->email }}">{{ $post->author->email }}</a></span></dd>
			<dd>گروه: {{ $post->author->group->name }}</dd>
		</dl>
	</div>
		<div class="textbody">
			<p>{{ $post->body }}</p>
		</div>
</div>
@endforeach
<div class="pagination pagination-right pagination-small">
	{{ $posts->links() }}
</div>
<div class="answer">
	<h3>ارسال پاسخ:</h3>
	{{ Form::open(URL::to_route('reply_post'), 'post')}}
	{{ Form::token() }}
	{{ Form::hidden('disc_id', $disc->id) }}
	<?php if($errors->has('body') ) echo "<p class='error'>متن پاسخ الزامی است.</p>"; ?>
	{{ Form::textarea('body', Input::old('body',''), array( 'style' => 'width:100%', 'id' => 'reply') )}}	
	&nbsp;
	<div>
		{{ Form::submit('ارسال', array('class' => 'btn btn-primary') ) }}
	</div>
	{{ Form::close() }}
</div>
@endsection

@section('js')
{{ HTML::script('richtext/tiny_mce.js');}}
<script type="text/javascript">
 $('*[data-poload]').hover(function(event){
 	console.log(event);
 	if (event.type === 'mouseenter') {
      var e=$(this);
      e.unbind('hover');
      $.get(e.data('poload'),function(d){
          e.popover({content: d, html: true,'placement': 'left', title: 'پروفایل کاربر',trigger: 'hover' ,delay: { show: 100, hide: 500 } }).popover('show');
      });
  }else
	{
		$(this).popover('hide');
	}
    });
</script>
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "table,autolink,contextmenu,advhr,advimage,directionality",

        // Theme options
        theme_advanced_buttons1 : ",outdent,indent,|,table,bullist,numlist|,link,image,|,justifyleft,justifycenter,justifyright,justifyfull,|,|,ltr,rtl,|,bold,italic,underline,strikethrough,",
        theme_advanced_buttons2 : "",

        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "bottom",
        theme_advanced_toolbar_align : "right",
        theme_advanced_statusbar_location : "none",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css :'{{ URL::base() . "public/richtext/themes/content.css" }}' ,
});
</script>

@endsection
