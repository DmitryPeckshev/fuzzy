<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
<?php
	if(!$_GET['option'] || $_GET['option'] == 'main') {
		echo 'Вход';
	}
	if($_GET['option'] == 'boss') {
		echo 'Директор';
	}
	if($_GET['option'] == 'expert') {
		echo 'Эксперт';
	}
	if($_GET['option'] == 'admin' || $_GET['option'] == 'properties' || $_GET['option'] == 'objects' || $_GET['option'] == 'change') {
		echo 'Администратор';
	}
?>	
	</title>
	<link rel="stylesheet" href="resourses/style.css" media="screen" type="text/css" />
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>