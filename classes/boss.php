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
		echo' </p>';	

		$exp_array = array();
		$exp_query = "SELECT id, name, status FROM users WHERE status = 'expert' ORDER BY name";
		$exp_result = mysqli_query($this->db,$exp_query);
		if(!$exp_result) {exit(mysqli_error());}
		for($i=1;$i<=mysqli_num_rows($exp_result);$i++) {
			$exp_array[$i] = mysqli_fetch_array($exp_result, MYSQLI_ASSOC);
		}
		
		$exp_prop_array = array();
		$exp_prop_query = "SELECT id, exp, prop, cat FROM exp_prop WHERE cat = {$_GET['cat']}";
		$exp_prop_result = mysqli_query($this->db,$exp_prop_query);
		if(!$exp_prop_result) {exit(mysqli_error());}
		for($k=0;$k<mysqli_num_rows($exp_prop_result);$k++) {
			$exp_prop_array[$k] = mysqli_fetch_array($exp_prop_result, MYSQLI_ASSOC);
		}
		
		$objects_array = array();
		$objects_query = "SELECT id, name, cat FROM obj WHERE cat = {$_GET['cat']}";
		$objects_result = mysqli_query($this->db,$objects_query);
		if(!$objects_result) {exit(mysqli_error());}
		for($m=0;$m<mysqli_num_rows($objects_result);$m++) {
			$objects_array[$m] = mysqli_fetch_array($objects_result, MYSQLI_ASSOC);
		}
		
		$obj_prop_array = array();
		$obj_prop_query = "SELECT * FROM obj_prop WHERE cat = {$_GET['cat']}";
		$obj_prop_result = mysqli_query($this->db,$obj_prop_query);
		if(!$obj_prop_result) {exit(mysqli_error());}
		$maches = 0;
		for($n=0;$n<mysqli_num_rows($obj_prop_result);$n++) { 
			$obj_prop_array[$n] = mysqli_fetch_array($obj_prop_result, MYSQLI_ASSOC);
		}
		
		if(empty($objects_array)){
			echo '<p class="expname">Нет объектов!</p>';
			goto endpage;
		}
		function result_sort($a, $b) {
			if ($a['round'] == $b['round']) {return 0;}
			return ($a['round'] > $b['round']) ? -1 : 1;
		}
		
		foreach($exp_array as $expert){
			$major_prop = array();
			foreach($exp_prop_array as $one_major_prop){
				if($one_major_prop['exp'] == $expert['id']){
					array_push($major_prop, $one_major_prop['prop']);
				}
			}
			$result_table = array();
			foreach($objects_array as $object){
				$result_row = array();
				$result_row['name'] = $object['name'];
				$one_obj_prop = 0;
				$maches = 0;
				foreach($obj_prop_array as $obj_prop){
					if($obj_prop['obj'] != $object['id']){
						continue;
					}
					if(in_array($obj_prop['prop'], $major_prop)){
						$maches++;
					}
					$one_obj_prop++;
				}
				$result_row['denominator'] = count($major_prop)+$one_obj_prop-$maches;
				$result_row['maches'] = $maches;
				$result_row['round'] = round($maches/$result_row['denominator'], 2);
				array_push($result_table, $result_row);
			}
			usort($result_table, "result_sort");
			printf(
				'<p class="expname">Эксперт %s</p>
				<table class="restable">'
				,$expert['name']
			);
			if(empty($major_prop)){
				echo '<th>Нет экспертной оценки</th></table><br/><br/>';
				continue;
			}else{
				echo '
				<tr>
					<th>Объект</th><th class="mu">&#956;</th><th class="mu">&#956;</th>
				</tr>';
			}
			foreach($result_table as $result_row){
				printf(
					'<tr>
						<td>%s</td>
						<td>%s/%s</td>
						<td>%s</td>
					</tr>', $result_row['name'], $result_row['maches'], $result_row['denominator'], $result_row['round']
				);
			}
			echo '
				</table>
				<br/><br/>';
		}
		endpage:
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