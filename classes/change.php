<?php
class change extends Core {
	
	public function get_content () {
	
	if (isset($_SESSION['user_id'])&& $_SESSION['user_status'] == 'admin') {
		
		if(isset($_POST['add_exp_ok'])) {
			if(!empty($_POST['add_exp_log']) && !empty($_POST['add_exp_pass'])) {
				$exp_add_log = $_POST['add_exp_log'];
				$exp_add_pass = md5($_POST['add_exp_pass']);
				$exp_add_query = "INSERT INTO users (name, pass, status) VALUES ('$exp_add_log','$exp_add_pass','expert')";
				$exp_add_result = mysqli_query($this->db,$exp_add_query);
				if(!$exp_add_result){
					mysqli_error($this->db);
				}else{
					printf ('<div class="sucsessmsg">Эксперт %s добавлен!</div>',$exp_add_log);
				}
			}
			if(!empty($_POST['add_exp_log']) && empty($_POST['add_exp_pass'])) {
				echo '<div class="sucsessmsg">Не введен пароль!</div>';
			}
			if(empty($_POST['add_exp_log']) && !empty($_POST['add_exp_pass'])) {
				echo '<div class="sucsessmsg">Не введен логин!</div>';
			}
		}
		
		if(isset($_POST['exp_delete']) && !empty($_POST['exp_todelete'])) {
			$exp_del_name = $_POST['exp_todelete'];
			$exp_del_query = "DELETE FROM users WHERE name = '$exp_del_name' AND status = 'expert'";
			$exp_del_result = mysqli_query($this->db,$exp_del_query);
			if(!$exp_del_result){
				mysqli_error($this->db);
			}else{
				printf ('<div class="sucsessmsg">Эксперт %s удален!</div>',$exp_del_name);
			}
		}
		
		if(isset($_POST['boss_log_ok']) && !empty($_POST['boss_old_log'])&& !empty($_POST['boss_new_log'])) {
			$boss_old_log = $_POST['boss_old_log'];
			$boss_new_log = $_POST['boss_new_log'];
			$boss_log_query = "SELECT id, name, status FROM users WHERE name = '$boss_old_log' AND status = 'boss'";
			$boss_log_result = mysqli_query($this->db,$boss_log_query);
			if(mysqli_num_rows($boss_log_result)==1) {
				$boss_log_update_query = "UPDATE users SET name = '$boss_new_log' WHERE name = '$boss_old_log'";
				$boss_log_update_result = mysqli_query($this->db,$boss_log_update_query);
				if(!$boss_log_update_result){
					mysqli_error($this->db);
				}else{
					echo '<div class="sucsessmsg">Логин изменен!</div>';
				}
			}else{
				echo '<div class="sucsessmsg">Неверный логин!</div>';
			}
		}
		
		if(isset($_POST['boss_pass_ok']) && !empty($_POST['boss_old_pass'])&& !empty($_POST['boss_new_pass'])&& !empty($_POST['boss_again_pass'])) {
			$boss_old_pass = md5($_POST['boss_old_pass']);
			$boss_new_pass =  md5($_POST['boss_new_pass']);
			$boss_again_pass =  md5($_POST['boss_again_pass']);
			if($_POST['boss_new_pass'] === $_POST['boss_again_pass']) {
				$boss_pass_query = "SELECT id, pass, status FROM users WHERE pass = '$boss_old_pass' AND status = 'boss'";
				$boss_pass_result = mysqli_query($this->db,$boss_pass_query);
				if(mysqli_num_rows($boss_pass_result)==1) {
					$boss_pass_update_query = "UPDATE users SET pass = '$boss_new_pass' WHERE pass = '$boss_old_pass'";
					$boss_pass_update_result = mysqli_query($this->db,$boss_pass_update_query);
					if(!$boss_pass_update_result){
						mysqli_error($this->db);
					}else{
						echo '<div class="sucsessmsg">Пароль изменен!</div>';
					}
				}else{
					echo '<div class="sucsessmsg">Неверный пароль!</div>';
				}
			}else{
				echo '<div class="sucsessmsg">Пароли не соответствуют!</div>';
			}
		}
		
		if(isset($_POST['adm_log_ok']) && !empty($_POST['adm_old_log'])&& !empty($_POST['adm_new_log'])) {
			$adm_old_log = $_POST['adm_old_log'];
			$adm_new_log = $_POST['adm_new_log'];
			$adm_log_query = "SELECT id, name, status FROM users WHERE name = '$adm_old_log' AND status = 'admin'";
			$adm_log_result = mysqli_query($this->db,$adm_log_query);
			if(mysqli_num_rows($adm_log_result)==1) {
				$adm_log_update_query = "UPDATE users SET name = '$adm_new_log' WHERE name = '$adm_old_log'";
				$adm_log_update_result = mysqli_query($this->db,$adm_log_update_query);
				if(!$adm_log_update_result){
					mysqli_error($this->db);
				}else{
					echo '<div class="sucsessmsg">Логин изменен!</div>';
				}
			}else{
				echo '<div class="sucsessmsg">Неверный логин!</div>';
			}
		}
		
		if(isset($_POST['adm_pass_ok']) && !empty($_POST['adm_old_pass'])&& !empty($_POST['adm_new_pass'])&& !empty($_POST['adm_again_pass'])) {
			$adm_old_pass = md5($_POST['adm_old_pass']);
			$adm_new_pass =  md5($_POST['adm_new_pass']);
			$adm_again_pass =  md5($_POST['adm_again_pass']);
			if($_POST['adm_new_pass'] === $_POST['adm_again_pass']) {
				$adm_pass_query = "SELECT id, pass, status FROM users WHERE pass = '$adm_old_pass' AND status = 'admin'";
				$adm_pass_result = mysqli_query($this->db,$adm_pass_query);
				if(mysqli_num_rows($adm_pass_result)==1) {
					$adm_pass_update_query = "UPDATE users SET pass = '$adm_new_pass' WHERE pass = '$adm_old_pass'";
					$adm_pass_update_result = mysqli_query($this->db,$adm_pass_update_query);
					if(!$adm_pass_update_result){
						mysqli_error($this->db);
					}else{
						echo '<div class="sucsessmsg">Пароль изменен!</div>';
					}
				}else{
					echo '<div class="sucsessmsg">Неверный пароль!</div>';
				}
			}else{
				echo '<div class="sucsessmsg">Пароли не соответствуют!</div>';
			}
		}
		
		if($_GET['ch'] == exp) {
		echo'	
<body>
	<div class="adminlist">
		<a href="?option=admin" class="backbtn"><span>&#8592 Назад</span></a>
		<p class="status">Администратор</p>
		<p class="mainTittle">Добавить эксперта</p>
		<form action="" method="post">
			<input type="text" name="add_exp_log" placeholder="Логин..."><br><br>
			<input type="password" name="add_exp_pass" placeholder="Пароль...">
			<input type="submit" name="add_exp_ok" value="Добавить"/>
		</form>
	</div>
	<div class="propertieslist">
		<p class="mainTittle">Удалить эксперта</p>
		<form action="" method="post">
			<select name="exp_todelete">
				<option></option>
		';
		$exp_query = "SELECT id, name, status FROM users WHERE status = 'expert' ORDER BY name";
		$exp_result = mysqli_query($this->db,$exp_query);
		if(!$exp_result) {exit(mysqli_error($this->db));}
		$exp_row = array();
		for($i=1;$i<=mysqli_num_rows($exp_result);$i++) {
			$exp_row = mysqli_fetch_array($exp_result,MYSQLI_ASSOC);
			printf(
				'<option>%s</option>'
				,$exp_row['name']
			);
		}
		echo'
			</select>
			<div class="btndel" onclick="showDelCaution()">Удалить</div><br>
			<div class="delcaution" id="delcaution">
				Удалить выбранного эксперта?
				<input type="submit" name="exp_delete" value="Да"/>
				<span onclick="showDelCaution()">Нет</span>
			</div>
		</form><br>
		<p class="mainTittle">Список экспертов</p>
		<ul>
		';
		$exp_query = "SELECT id, name, status FROM users WHERE status = 'expert' ORDER BY name";
		$exp_result = mysqli_query($this->db,$exp_query);
		if(!$exp_result) {exit(mysqli_error($this->db));}
		$exp_row = array();
		for($i=1;$i<=mysqli_num_rows($exp_result);$i++) {
			$exp_row = mysqli_fetch_array($exp_result,MYSQLI_ASSOC);
			printf(
				'<li>%s</li>'
				,$exp_row['name']
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
		}
		
		if($_GET['ch'] == boss) {
		echo '
<body>
	<div class="adminlist">
		<a href="?option=admin" class="backbtn"><span>&#8592 Назад</span></a>
		<p class="status">Администратор</p>
		<p class="mainTittle">Изменить логин директора</p>
		<form action="" method="post">
			<input type="text" name="boss_old_log" placeholder="Старый логин..."><br><br>
			<input type="text" name="boss_new_log" placeholder="Новый логин...">
			<input type="submit" name="boss_log_ok" value="Изменить"/>
		</form>
		<p class="mainTittle">Изменить пароль директора</p>
		<form action="" method="post">
			<input type="password" name="boss_old_pass" placeholder="Старый пароль..."><br><br>
			<input type="password" name="boss_new_pass" placeholder="Новый пароль..."><br><br>
			<input type="password" name="boss_again_pass" placeholder="Подтверждение нового пароля...">
			<input type="submit" name="boss_pass_ok" value="Изменить"/>
		</form>
	</div>
	<br><br>
<script type="text/javascript" src="resourses/script.js"></script>
</body>
</html>
		';
		}
		
		if($_GET['ch'] == adm) {
		echo '
<body>
	<div class="adminlist">
		<a href="?option=admin" class="backbtn"><span>&#8592 Назад</span></a>
		<p class="status">Администратор</p>
		<p class="mainTittle">Изменить свой логин</p>
		<form action="" method="post">
			<input type="text" name="adm_old_log" placeholder="Старый логин..."><br><br>
			<input type="text" name="adm_new_log" placeholder="Новый логин...">
			<input type="submit" name="adm_log_ok" value="Изменить"/>
		</form>
		<p class="mainTittle">Изменить свой пароль</p>
		<form action="" method="post">
			<input type="password" name="adm_old_pass" placeholder="Старый пароль..."><br><br>
			<input type="password" name="adm_new_pass" placeholder="Новый пароль..."><br><br>
			<input type="password" name="adm_again_pass" placeholder="Подтверждение нового пароля...">
			<input type="submit" name="adm_pass_ok" value="Изменить"/>
		</form>
	</div>
	<br><br>
<script type="text/javascript" src="resourses/script.js"></script>
</body>
</html>
		';
		}
		
	}//session	
	
	}//get_content
	
}//class
?>