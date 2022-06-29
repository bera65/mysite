<?php

Class Page {
	
	public static function createPage($name, $title)
	{
		include('view/header.php');
		include('view/'.$name.'.php');
		include('view/footer.php');
	}
}