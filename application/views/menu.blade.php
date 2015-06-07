<div class="span2" style="width:200px !important">
	<div class="well sidebar-nav">
		<ul class="nav nav-list"> 
			<li class="nav-header">منو اصلی</li>
			<li ><a href="{{ URL::to_route('add_discussion') }}"><i class="icon-plus"></i> ایجاد بحث</a></li>
			<li ><a href="{{ URL::to_route('discussions_list') }}"><i class="icon-th-list"></i>لیست بحث ها</a></li>
			<li ><a href="{{ URL::to_route('list_changelog') }}"><i class="icon-list-alt"></i> تاریخچه تغییرات</a></li>
			
			<li ><a href="{{ URL::to_route('show_elements') }}"><i class="icon-th-large"></i> مدیریت المان ها</a></li>
			<?php if(Auth::User()->acl == 0) { ?>
			<li ><a href="{{ URL::to_route('show_users') }}"><i class="icon-user"></i> مدیریت کاربران</a></li>
			<li ><a href="{{ URL::to_route('group_index') }}"><i class="icon-leaf"></i> مدیریت گروه ها</a></li>
			<?php } ?>
		</ul>
	</div><!--/.well -->
</div><!--/span-->