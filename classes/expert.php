<?php
class expert extends Core {
	public function get_content() {
	
	if (isset($_SESSION['user_id'])&& $_SESSION['user_status'] == 'expert') {
	
	if(isset($_POST['check_ok'])) {
		$check_arr = $_POST['check_prop'];
		$num_checks = count($check_arr);
		if(isset($num_checks)) {
			printf( '<div class="sucsessmsg"> Выбрано %s свойств</div>',$num_checks);
		}
		$exp_check_query = "SELECT id, exp, prop, cat FROM exp_prop WHERE cat = {$_GET['cat']} AND exp = {$_SESSION['user_id']}";
		$exp_check_result = mysqli_query($this->db,$exp_check_query);
		if(!$exp_check_result) {exit(mysqli_error());}
		$exp_check_row = array();
		for($i=1;$i<=mysqli_num_rows($exp_check_result);$i++) {
			$exp_check_row = mysqli_fetch_array($exp_check_result, MYSQLI_ASSOC);
			if(!$check_arr){
				$check_arr = array();
			}
			if(in_array($exp_check_row['prop'],$check_arr)) {
				$key = array_search($exp_check_row['prop'], $check_arr);
				unset($check_arr[$key]);
			}else{
				$del_check_query = "DELETE FROM exp_prop WHERE cat = {$_GET['cat']} AND exp = {$_SESSION['user_id']} AND prop = {$exp_check_row['prop']}";
				$del_check = mysqli_query($this->db,$del_check_query);
				if(!$del_check) {exit(mysqli_error());}
			}
		}
		if($check_arr){
			$check_arr = array_values($check_arr);
		}
		for($j=0;$j<count($check_arr);$j++) {
			$add_check_query = "INSERT INTO exp_prop(exp,prop,cat) VALUES({$_SESSION['user_id']},$check_arr[$j],{$_GET['cat']})";
			$add_check_result = mysqli_query($this->db,$add_check_query);
			if(!add_check_result) {exit(mysqli_error());}
		}
		
	}
	
	if(!$_GET['cat']) {
		echo'
			<body>
				<div class="expertlist">
					<a href="?action=logout" class="backbtn"><span>&#8592 Выйти</span></a>
					<p class="status">Эксперт 
					';
					echo $_SESSION['usernow'];
					echo '</p>
					<p class="mainTittle">Выберите категорию</p>
					<ul>
		';
		$all_cat_query = "SELECT * FROM cat ORDER BY name";
		$all_cat_result = mysqli_query($this->db,$all_cat_query);
		$all_cat_row = array();
		for($i=1;$i<=mysqli_num_rows($all_cat_result);$i++) {
			$all_cat_row = mysqli_fetch_array($all_cat_result, MYSQLI_ASSOC);
			printf(
				'<a href="?option=expert&cat=%s"><li>%s</li></a>'
				,$all_cat_row['id'],$all_cat_row['name']
			);
		}
		
		echo'
					</ul>
				</div>
			<br><br>
			<script type="text/javascript" src="resourses/script.js"></script>
			</body>
			</html>
		';
	}else{
		echo'
		<body>
			<div class="experchecks">
				<a href="?option=expert" class="backbtn"><span>&#8592 Назад</span></a>
				<p class="status">Эксперт  
				';
				echo $_SESSION['usernow'];
				echo '</p>
				<p class="mainTittle">
		';

		$tittlecat_query = mysqli_query($this->db,"SELECT id, name FROM cat WHERE id = {$_GET['cat']}");
		if(!$tittlecat_query) {exit(mysqli_error());}
		$tittlecat = mysqli_fetch_array($tittlecat_query, MYSQLI_ASSOC);
		printf($tittlecat['name']);
		echo' </p>
				<p class="mainTittle">Выберите важные свойства</p>
					<form method="post">
						<ul>
		';

		$prop_query = "SELECT id, name, cat FROM prop WHERE cat = {$_GET['cat']} ORDER BY name";
		$exp_prop_query = "SELECT id, exp, prop, cat FROM exp_prop WHERE cat = {$_GET['cat']} AND exp = {$_SESSION['user_id']}";
		$prop_result = mysqli_query($this->db,$prop_query);
		$exp_prop_result = mysqli_query($this->db,$exp_prop_query);
		if(!$prop_result || !$exp_prop_result) {
			exit(mysqli_error($this->db));
		}
		$prop_row = array();
		$exp_prop_row = array();
		$exp_prop_arr = array();
		for($j=1;$j<=mysqli_num_rows($exp_prop_result);$j++) {
			$exp_prop_row = mysqli_fetch_array($exp_prop_result, MYSQLI_ASSOC);
			$exp_prop_arr[$j] = $exp_prop_row['prop'];
		}
		for($i=1;$i<=mysqli_num_rows($prop_result);$i++) {
			$prop_row = mysqli_fetch_array($prop_result, MYSQLI_ASSOC);
			echo '<li><input type="checkbox" ';
			if(in_array($prop_row['id'],$exp_prop_arr)){
				echo ' checked ';
			}
			printf(
				' id="check%s" name="check_prop[]" value="%s"><label for="check%s">%s</label></li>'
				,$i,$prop_row['id'],$i,$prop_row['name']
			);
		}
		echo'
					</ul>
					';
					if(mysqli_num_rows($prop_result)>0) {
						echo '<input type="submit" name="check_ok" value="Отправить"/>';
					}else{
						echo '<ul><li>Нет доступных свойств</li></ul>';
					}
					echo '
				</form>
			</div>
		<br><br>
		<script type="text/javascript" src="resourses/script.js"></script>
		</body>
		</html>
		';
	}

	}
	
	if (!$_SESSION['user_id']) {
		echo '
		<body>
		<div class="login-wrap login-now">
			<div class="login-form-wrap">
				<div class="card-holder-wrap">
					<div class="hole"></div>
					<div class="l-stroke"></div>
					<div class="r-stroke"></div>
					<div class="ring-large-wrap"></div>
					<div class="ring-small-wrap"></div>
				</div>
				<form action="" class="login-form" method="post">
					<h1 class="freeb">эксперт</h1>
					';
					if($_SESSION['reg_err'] == 'user'){echo '<p class="regwrong">нет такого пользователя</p>';}
					if($_SESSION['reg_err'] == 'pass'){echo '<p class="regwrong">неверный пароль</p>';}
					if($_SESSION['reg_err'] == 'unknown'){echo '<p class="regwrong">ошибка авторизации</p>';}
					if($_SESSION['reg_err'] == 'log'){echo '<p class="regwrong">неверный логин</p>';}
					if($_SESSION['reg_err'] == 'status'){echo '<p class="regwrong">неверный статус</p>';}
					
					echo'
					<div class="input-wrap">
						<label for="" class="user-id"><input type="text" name="auth_name" placeholder="Ваш логин"></label> 
						<hr class="form-hr">
						<label for="" class="password"><input type="password" name="auth_pass" placeholder="Ваш пароль"></label> 
						<input type="hidden" name="auth_status" value="expert">
					</div>
					<input type="submit" class="button" name="auth_ok" value="ВОЙТИ">
					<a href="?option=main&action=logout"><div class="mainback">назад</div></a>
				</form>
			</div>
		</div>

		<script type="text/javascript" src="resourses/script.js"></script>
		</body>
		</html>
		';
	}
	
	}	
}
?>