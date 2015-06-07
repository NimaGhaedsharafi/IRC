<?php 

/**
* 
*/
class header
{

	public $title; # HEADER TITLE
	public $width; # TH WIDHT
	public $enabled; # TRUE : HAVE ACTIVE LINK , FALSE: HAVE ANY LINK
	
	function __construct($title, $width = '', $enabled = TRUE )
	{
		$this->title = $title;
		$this->set_width($width);
		$this->enabled = $enabled;
		return $this;
	}

	public function set_width($width)
	{
		if($width == '')
			$this->width = 'auto';
		else
			$this->width = $width;
	}
}