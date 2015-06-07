<?php 

class Mail
{
	protected $to = '';
	protected $view = '';
	protected $data = array();
	
	function __construct($to, $view, $data = array())
	{
		$this->to = $to;
		$this->view = $view;
		$this->data = $data;

		return $this->send_mail();
	}

	public function send_mail()
	{
		$to = $this->to;
		$title = $this->data['title'];
		$view = $this->make_view();
		return Message::send(function($message)  use ($to , $title, $view)
		{
		    $message->to($to);
		    $message->from('estrap.irc@gmail.com', 'Estrap IRC');
		    $message->subject('[ Estrap IRC Channel ] ' . $title);
		    $message->body($view);
		    $message->html(true);
		});
	}
	public function make_view()
	{
		$view = new View($this->view , $this->data);
		return $view->render();
	}

	public static function inform_reply($disc_id , $data)
	{
		$posts = Discussion::find($disc_id)->post()->get('created_by');
		$queue = array();
		foreach($posts as $post)
			if(!in_array($post->author->id, $queue))
				$queue[] = $post->author->id;
		foreach ($queue as $author) 
		{
			$user = User::find($author);
			$mail = new Mail($user->email, 'mail.new_reply', array_merge($data, array('user' => $user)));
			unset($mail);
		}
	}
}