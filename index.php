<?php 
session_start();
header("Content-Type:text/html; charset-utf-8");
require_once("config.php");
require_once("classes/Core.php");

if($_GET['option']) {
	$class = trim(strip_tags($_GET['option']));
	if($_GET['option']=='properties'||$_GET['option']=='objects'){
		if(!$_SESSION['user_id']) {
			$class = 'main';
		}
	}
}
else {
	$class = 'main';
}

if(file_exists("classes/".$class.".php")) {
	include("classes/".$class.".php");
	if (class_exists($class)){
		$obj = new $class;
		$obj->get_body();
	}
	else {exit("<p>Неправильные данные</p>");	
	}
}
else {
	printf('Введен неверный адрес<br/>
			<a href="?option=main">Перейти на главную страницу.</a>');
}
?>