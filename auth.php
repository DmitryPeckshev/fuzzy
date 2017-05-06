<?php
session_start();

if (isset($_GET['action']) AND $_GET['action']=="logout") {
    session_destroy();
	$_SESSION['usernow'] = false;
	$_SESSION['user_id'] = false;
	$_SESSION['user_pass'] = false;
	$_SESSION['user_status'] = false;
}

if (isset($_POST['auth_ok'])) {	
	$_GET['action'] = false;
    $user_name = $_POST['auth_name'];
    $sql_query = "SELECT * FROM users WHERE name = '$user_name'";
    $sql_result = mysqli_query($this->db,$sql_query);
    if(!$sql_result) {
		$_SESSION['reg_err'] = 'user';
	}
    if(mysqli_num_rows($sql_result ) == 1) {
        $sql_row = array();
        $sql_row = mysqli_fetch_array($sql_result, MYSQLI_ASSOC);
		if($sql_row['status'] == $_POST['auth_status']) {
			$_SESSION['usernow'] = $_POST['auth_name'];
			$_SESSION['user_status'] = $_POST['auth_status'];
			$passwd = $_POST['auth_pass'];
			$hashwd = md5($passwd);
		
			if($sql_row['pass'] == $hashwd) {
				$_SESSION['user_id'] = $sql_row['id'];
				$_SESSION['reg_err'] = false;
			}else{
				$_SESSION['reg_err'] = 'pass';
			}
		}else{
			$_SESSION['reg_err'] = 'status';
		}
    }
	else {
		$_SESSION['reg_err'] = 'unknown';
		if(mysqli_num_rows($sql_result ) < 1) {
			$_SESSION['reg_err'] = 'log';
		}
	}
}
?>