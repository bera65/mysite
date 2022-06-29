<?php

	try {
		 $db = new PDO("mysql:host=localhost;dbname=mysite", "root", "");
	} catch ( PDOException $e ){
		 print $e->getMessage();
	}
	$db->query("SET CHARACTER SET utf8");
	include('tools.php');
	include('model/function.php');
	include('page.php');
	include('imageupload.php');
	
	$page = new Page();