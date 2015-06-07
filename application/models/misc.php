<?php

class Misc extends Eloquent 
{
	public static function niceDate($date)
	{
		require_once 'jdf.php';

		$date = explode('/', $date);
		
		$year = $date[0];
		$month = jdate_words(array('mm' => $date[1]));
		$day = $date[2];
		
		return $day . " " .  $month['mm'] . " " . $year ;
	}

	public static function NiceDateTS($date)
	{
		return $date = jDate::forge($date)->format('j F y - H:i');
	}
	public static function jDateNow()
	{
		require_once 'jdf.php';
		return jdate('y/m/d');
	}
	public static function jTimeNow()
	{
		require_once 'jdf.php';
		return jdate('H:i');
	}
	public static function encrypt($string)
	{
		return base64_encode($string);
	}
	public static function decrypt($encrypted)
	{
		return base64_decode($encrypted);
	}
	public static function htmlent($value)
	{
		$data = array( '/' , ':', '.',);
		foreach ($data as $val)
		{
			$value = str_replace($val, '\\'.$val, $value);
		}
		return $value;

	}

	public static function piority()
	{
		return array(
			'0' => Setting::item('priority.text.high'),
			'1' => Setting::item('priority.text.mid'),
			'2' => Setting::item('priority.text.low'),
		);
	}

	public static function profile_kind()
	{
		return array(
			'0' => Setting::item('profile.kind.haghighi'),
			'1' => Setting::item('profile.kind.hoghogh'),
		);
	}

	public static function upload($key, $directory, $name = null)
	{

		$urls = array();
		if(!file_exists($directory))
			mkdir($directory);

        $i = 0;
        $names = Input::file($key . '.name');
        foreach(Request::foundation()->files->get($key) as $file) 
        {
            if(!is_null($file) && $file->getClientSize() <= $file->getMaxFilesize() ) 
            {
                $md5 = substr(sha1(md5(time().md5('codenevis'))), 0,10);
                $name = "crm_" . "_" . $md5 . '.' . File::extension($names[$i]);
                $urls[$i] = $directory . $name;
                $file->move($directory, $name );
                $i++;
            }
        }
        return $urls;
	}

	public static function menuLinks($url1, $url2)
	{
		 return preg_match("/^" . Misc::htmlent($url1) .  '(.)*$/', $url2);
	}
	public static function piority_color_text($id)
	{
		switch ($id)
		{
			case 0:
				$label = 'high';
				break;
			case 1:
				$label = 'mid';
				break;
			case 2:
				$label = 'low';
				break;
		}
		$color = Setting::item('priority.color.' . $label);
		$text = Setting::item('priority.text.' . $label);
		return "<span style='color:$color; font-weight:bold'>$text</span>";
	}
	public static function make_badge($count)
	{
		$string = '';
		if($count != 0)
		{
			$string = '<span class="badge badge-warning" id="tickets">';
			$string .= $count;
			$string .= "</span>";
		}
		return $string;
	}
	public static function make_ticket_table($tickets)
	{
		$headers = array(
			'piorty_id' => 'اولویت',
			'title' => 'عنوان',
			'to_groupid' => 'بخش',
			'from_userid' => 'فرستنده',
			'flag_uid' => 'بررسی توسط',
			'date' => 'تاریخ',
			'status' => 'وضعیت',
			'operation' => 'عملیات',
		);

		if(!empty($tickets))
		{
			$string = '<table class="table table-hover"><thead>';
			foreach($headers as $key => $val)
			{
				$string .= "<td>". $val . "</td>";
			}
			$string .= "</thead>";

			foreach($tickets as $ticket)
			{
				$string .= "<tr" ;
				if($ticket->status == 0 || $ticket->status == 2)
				{
					$string .= "class='info'";
				}
				$string .= ">";
				$string .= '<td width="35px">';
		    	if($ticket->piorty_id == 0)
		    		$string .= HTML::image('img/red_flag.png', 'ضروری'); 
		    	else if($ticket->piorty_id == 1)
		    		$string .= HTML::image('img/orange_flag.png', 'مهم');
		    	else
		    		$string .= HTML::image('img/green_flag.png', 'معمولی');
				$string .= "</td>";
				
				$string .= '<td style="min-width:250px">';
				$string .= $ticket->title  ;
				$string .= '</td>';
				$string .= '<td width="60px" >';
				$string .= StaffGroup::name($ticket->to_groupid);
				$string .= '</td>';
				$string .= '<td width="100px" >';
				$string .= User::name($ticket->from_userid);
				$string .= '</td>';
				$string .= '<td>';
				if( $ticket->flag == 1)
				{
					$string .= User::name($ticket->flag_uid);
				}
		    	else
		    	{
		    		$string .= '-';
		    	}

				$string .= '</td>';

				$string .= '<td>';
				$string .= Misc::niceDate($ticket->date) . '-' . $ticket->time;
				$string .= '</td>';

				$string .= '<td>';
				$string .= Ticket::status( $ticket->status ) ;
				$string .= '</td>';

				$string .= '<td>';

				$string .= '<td width="90px">
					<div class="btn-group" >
					    <button class="btn btn-small">عملیات</button>
					    <button class="btn dropdown-toggle" data-toggle="dropdown">
					    	<span class="caret "></span>
					    </button>
						<ul class="dropdown-menu">' ;
						if( Ticket::isAdmin($ticket->id) )
						{ 
							$string .='<li><a rel=\'facebox\' href="' . URL::to_route('forward_ticket' , $ticket->id) .'"><i class="icon-share-alt" ></i> ارجاع به ...</a></li>
							<li class="divider"> <li>';
						}
						if(Ticket::isAdminOrBelongsTo($ticket->id) ) { 
							$string .= '<li><a href="' . URL::to_route('view_ticket', array($ticket->id, $ticket->token)) . '"><i class="icon-info-sign"></i> مشاهده</a></li>';
						}
						$string .= '</ul></div>';
				$string .= '</td>';

				$string .= '</tr>';
			}
		}
		else
		{
			$string = '<p class="error" >هنوز تیکتی ندارید.</p>';
		}
		return $string;
	}

	public static function make_msgs_table($msgs)
	{
		$headers = array(
            'piorty_id' => 'اولویت',
            'title' =>'عنوان' ,
            'date' =>'تاریخ' ,
            'time' =>'ساعت' ,
            'from_id' => 'فرستنده',
            'status' => 'وضعیت',
            'attachments' => 'پیوست',
            'operation' => 'عملیات'
        );
        if(!empty($msgs))
        {
	        $string = '
			<table class="table table-hover"><thead>';
			foreach($headers as $header => $label)
			{
				$string .= '<td>';
				$string .= $label ;
				$string .= '</td>';
			}
		$string .= '</thead>';
		foreach($msgs as $msg)
		{
			$string .= '<tr ';
			if($msg->status == 0){ 
				$string .= "class='info'"; 
			}
			$string .=  '><td width="35px">';
	    	if($msg->piorty_id == 0)
	    		$string .=  HTML::image('img/red_flag.png', 'ضروری'); 
	    	else if($msg->piorty_id == 1)
	    		$string .= HTML::image('img/orange_flag.png', 'مهم');
	    	else
	    		$string .= HTML::image('img/green_flag.png', 'معمولی');
				$string .= '</td>';
				$string .= '<td style="min-width:250px">';
			    $string .= $msg->title;
				$string .= '</td>';
				$string .= '<td width="90px" >';
			    $string .= Misc::niceDate($msg->date);
				$string .= '</td><td width="60px" >';
			   	$string .= $msg->time;
				$string .= '</td><td width="100px" >';
			    $string .= User::name($msg->to_uid);
				$string .= '</td><td>';
				if( $msg->status == 1)
			    	$string .=  HTML::image('img/read_pm.png', 'خوانده شده');
			    else
			    	$string .= HTML::image('img/unread_pm.png', 'هنوز خوانده نشده');
				$string .= '</td><td>';
				if( $msg->attachments != '')
			    	$string .=  HTML::image('img/with_attachment.png', 'با پیوست');
			    else
			    	$string .= HTML::image('img/without_attachment.png', 'بدون پیوست');
				$string .= '</td><td>
					<div class="btn-group">
					    <button class="btn btn-small">عملیات</button>
					    <button class="btn dropdown-toggle" data-toggle="dropdown">
					    	<span class="caret"></span>
					    </button>
						<ul class="dropdown-menu">
							<li><a rel="facebox" href="'.  URL::to_route("prev_msg", $msg->id) . '"><i class="icon-eye-open"></i> پیش نمایش</a></li>
							<li><a href="'. URL::to_route("prev_msg",$msg->id) . '"> <i class="icon-info-sign"></i> مشاهده</a></li>
							<li><a rel=\'facebox\' href="'. URL::to_route('forward_message',$msg->id) . '"><i class="icon-share-alt" ></i> ارجاع به ...</a></li>
						</ul>
				    </div>
				</td>
			</tr>';
			}
		}
		else
		{
			$string = '<p class="error" >هنوز پیامی ندارید.</p>';
		}
		return $string;
	}

	public static function member_groupname()
	{
		$groups = Auth::User()->GroupsMembers()->get('group_id');
		if($groups != NULL)
		{
			$string = "<ul>";
			foreach($groups as $group)
			{
				$string .= '<li>';
				$string .= StaffGroup::name($group->group_id);
				$string .= '</li>';
			}
			$string .= "</ul>";
		}
		else
			$string = 'شما در گروه ی عضو نیستید.';
		return $string;
	}

}