<?php
class boss extends Core {
	public function get_content() {
	
	if (isset($_SESSION['user_id'])&& $_SESSION['user_status'] == 'boss') {
	
	if(!$_GET['cat']) {
		echo'
			<body>
				<div class="expertlist">
					<a href="?action=logout" class="backbtn"><span>&#8592 Выйти</span></a>
					<p class="status">Директор</p>
					<p class="mainTittle">Выберите категорию</p>
					<ul>
		';
		$all_cat_query = "SELECT * FROM cat ORDER BY name";
		$all_cat_result = mysqli_query($this->db,$all_cat_query);
		$all_cat_row = array();
		for($i=1;$i<=mysqli_num_rows($all_cat_result);$i++) {
			$all_cat_row = mysqli_fetch_array($all_cat_result, MYSQLI_ASSOC);
			printf(
				'<a href="?option=boss&cat=%s"><li>%s</li></a>'
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
				<a href="?option=boss" class="backbtn"><span>&#8592 Назад</span></a>
				<p class="status">Директор</p>
				<p class="mainTittle"> ';
				
		$tittlecat_query = mysqli_query($this->db,"SELECT id, name FROM cat WHERE id = {$_GET['cat']}");
		if(!$tittlecat_query) {exit(mysqli_error());}
		$tittlecat = mysqli_fetch_array($tittlecat_query, MYSQLI_ASSOC);
		printf($tittlecat['name']);
		echo' </p>
		';	
		
		$exp_query = "SELECT id, name, status FROM users WHERE status = 'expert' ORDER BY name";
		$exp_result = mysqli_query($this->db,$exp_query);
		if(!$exp_result) {exit(mysqli_error());}
		$exp_row = array();
		for($i=1;$i<=mysqli_num_rows($exp_result);$i++) {
			$exp_row = mysqli_fetch_array($exp_result, MYSQLI_ASSOC);
			
			$exp_prop_query = "SELECT id, exp, prop, cat FROM exp_prop WHERE cat = {$_GET['cat']} AND exp = {$exp_row['id']}";
			$exp_prop_result = mysqli_query($this->db,$exp_prop_query);
			if(!$exp_prop_result) {exit(mysqli_error());}
			$exp_prop_row = array();
			$exp_prop_array = array();
			
			$table_array = array();
			$max_mu = 0;
			
			printf('
				<p class="expname">Эксперт %s</p>
				<table class="restable">
				
				',$exp_row['name']
			);
			
			for($k=0;$k<mysqli_num_rows($exp_prop_result);$k++) {
				$exp_prop_row = mysqli_fetch_array($exp_prop_result, MYSQLI_ASSOC);
				$exp_prop_array[$k] = $exp_prop_row['prop'];
			}
			
			$objects_query = "SELECT id, name, cat FROM obj WHERE cat = {$_GET['cat']}";
			$objects_result = mysqli_query($this->db,$objects_query);
			$objects_result2 = mysqli_query($this->db,$objects_query);
			if(!$objects_result) {exit(mysqli_error());}
			$objects_row = array();
			$objects_id_array = array();
			
			for($m=0;$m<mysqli_num_rows($objects_result);$m++) {
				$objects_row = mysqli_fetch_array($objects_result, MYSQLI_ASSOC);
				$objects_id_array[$m] = $objects_row['id'];
				
				$obj_prop_query = "SELECT * FROM prop INNER JOIN obj_prop ON obj_prop.prop = prop.id WHERE prop.cat = {$_GET['cat']} AND obj_prop.obj = {$objects_row['id']}";
				$obj_prop_result = mysqli_query($this->db,$obj_prop_query);
				if(!$obj_prop_result) {exit(mysqli_error());}
				$obj_prop_row = array();
				$obj_prop_array = array();
				$maches = 0;
				for($n=0;$n<mysqli_num_rows($obj_prop_result);$n++) {
					$obj_prop_row = mysqli_fetch_array($obj_prop_result, MYSQLI_ASSOC);
					$obj_prop_array[$n] = $obj_prop_row['prop'];
					if(in_array($obj_prop_row['prop'],$exp_prop_array)) {
						$maches++;
					}
				}
				
				$denominator = count($obj_prop_array) + count($exp_prop_array) - $maches;
				if($denominator != 0){
					$mu = $maches/$denominator;
				}
				if($mu>$max_mu){$max_mu=$mu;}
				
				$round_mu = round($mu,2); 
				$table_row = <<<EOL
				<tr>
					<td>{$objects_row['name']}</td>
					<td>$maches/$denominator</td>
					<td>$round_mu</td>
				</tr>
EOL;
				$str_mu = strval($mu);
				if($mu==0){
					$str_mu = strval($m/1000);
				}
				if (array_key_exists($str_mu,$table_array)){
					$str_mu = strval($mu+($m/1000));
				}
				$table_array[$str_mu] = $table_row;
			}
			
			krsort($table_array);
			if(mysqli_num_rows($objects_result)>0) {
				if($max_mu==0){
					echo '<th>Нет экспертной оценки</th>';
				}else{
					echo '<tr>
					<th>Объект</th><th class="mu">&#956;</th><th class="mu">&#956;</th>
					</tr>';
					foreach ($table_array as $value) {
						echo $value ;
					}
				}	
			}else{
				echo '<th>Нет объектов</th>';
			}
			
			echo '
				</table>
				<br><br>';
		}

		echo '
			</div>

		<br><br>
		<script type="text/javascript" src="resourses/script.js"></script>
		</body>
		</html>
		';
	}
	
	}//session
	
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
					<h1 class="freeb">директор</h1>
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
						<input type="hidden" name="auth_status" value="boss">
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
	
	
	}//get_content
}//class
?>