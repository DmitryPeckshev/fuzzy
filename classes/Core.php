<?php
abstract class Core {
	
	protected $db;
	
	public function __construct() {
		$this->db = mysqli_connect (HOST,USER,PASSWORD,DB);
		if(!$this->db) {
			exit("Ошибка соединения с базой данных" .mysqli_error());
		}
		if(!mysqli_select_db($this->db,DB)) {
			exit("Нет такой базы данных".mysqli_error());
		}
		mysqli_query($this->db, "SET NAMES 'UTF8'");
		
	}
	protected function get_auth() {
		include "auth.php";
	}
	
	protected function get_header() {
		include "head.php";
	}	
	
	abstract function get_content();

	public function get_body() {
		
		$this->get_auth();
		$this->get_header();
		$this->get_content();
	}	
	
}

?>