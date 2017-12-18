<?php
/*
	"You must first have a lot of patience to learn to have patience." 
	~ Stanislaw Jerzy Lec
*/
class PageMetadata{
	function __construct($title,$copyright){
		$this->title = htmlspecialchars($title);
		$this->copyright = htmlspecialchars($copyright);
	}
}
class ImageMetadata{
	function __construct($title,$filename,$description,$orginal_name,$author,$type){
		$this->title = htmlspecialchars($title);
		$this->filename = htmlspecialchars($filename);
		$this->orginal_name = htmlspecialchars($orginal_name);
		$this->description = htmlspecialchars($description);
                $this->author = htmlspecialchars($author);
		$this->type = htmlspecialchars($type);
	}
}
?>