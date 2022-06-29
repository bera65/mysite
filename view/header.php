<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
	<meta name="generator" content="Ramazan Benek">
	<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.0, initial-scale=1.0">
	<link rel="icon" type="image/vnd.microsoft.icon" href="img/favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="view/css/font-awesome.min.css" rel="stylesheet">
    <link href="view/css/style.css" rel="stylesheet">
	<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

  </head>
  <body>
    <div class="container-fulled">
		<header>
			<nav>
			<div class="container">
				<?php if ($name != 'index') { echo '<a href="index.php">Ana Sayfa </a> | '; } ?>
				<a href="addproduct.php">Ürün Ekle</a>
			</div>
			</nav>
		</header>
	</div>
	<div class="container">