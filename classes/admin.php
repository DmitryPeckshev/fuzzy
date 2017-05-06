<?php
class admin extends Core {
	
	public function get_content () {
	
	if (isset($_SESSION['user_id'])&& $_SESSION['user_status'] == 'admin') {
			
	if (isset($_POST['newcat_send'])){
		$name_newcat = $_REQUEST['name_new']; 
			
		if(!empty($name_newcat)){
			$insert_sql = "INSERT INTO cat (name) VALUES ('$name_newcat')"; 
			$cat_add_result = mysqli_query($this->db,$insert_sql);
			if(!$cat_add_result){
				mysqli_error($this->db);
			}else{
				printf ('<div class="sucsessmsg">Категория &quot%s&quot добавлена!</div>',$name_newcat);
			}
		}
	}
	
	if($_POST['cat_delete']&& $_POST['select_todelete']) {
		$opt_del = $_POST['select_todelete'];
		$query_todelete = "DELETE FROM cat WHERE name = '$opt_del'";
		mysqli_query($this->db,$query_todelete);
		if (mysqli_query($this->db,$query_todelete)) {
			printf ('<div class="sucsessmsg">Категория &quot%s&quot удалена!</div>',$opt_del);
		}else {
			echo '<div class="sucsessmsg">Ошибка удаления!</div>';
		}
	}	
		
		echo '
	<body>
	<div class="adminlist">
		<a href="?action=logout" class="backbtn"><span>&#8592 Выйти</span></a>
		<p class="status">Администратор</p>
		<p class="mainTittle">Выберите категорию</p>
		<ul>
		
		';
		
		$cat_query = "SELECT id, name FROM cat ORDER BY name";
		$cat_result = mysqli_query($this->db,$cat_query);
		if(!$cat_result) {
			exit(mysqli_error($this->db));
		}
		$cat_row = array();
		for($i=1; $i<=mysqli_num_rows($cat_result); $i++) {
			$cat_row = mysqli_fetch_array($cat_result, MYSQLI_ASSOC);
			printf(
			'<li onclick="showSubmenu(%s)">%s</li>
			<div class="submenugroup" id="submenugroup%s">
				<a href="?option=objects&cat=%s" class="listsubmenu">Объекты</a>
				<a href="?option=properties&cat=%s" class="listsubmenu">Свойства</a>
			</div>'
			,$i,$cat_row['name'],$i,$cat_row['id'],$cat_row['id']);
		}
		
		echo '
		
		</ul>
		<p class="mainTittle">Добавить категорию</p>
		<form action="" method="post">
			<input type="text" name="name_new" placeholder="Новая категория...">
			<input type="submit" name="newcat_send" value="Добавить"/>
		</form>
		
		<p class="mainTittle">Удалить категорию</p>
		<form action="" method="post">
		<select name="select_todelete">
			<option></option>
		';
		$opt_query = "SELECT id, name FROM cat ORDER BY name";
		$opt_result = mysqli_query($this->db,$opt_query);
		if(!$opt_result) {
			exit(mysqli_error($this->db));
		}
		$opt_row = array();
		for($i=1; $i<=mysqli_num_rows($opt_result); $i++) {
			$opt_row = mysqli_fetch_array($opt_result, MYSQLI_ASSOC);
			printf(
			'<option>%s</option>'
			,$opt_row['name']);
		}
		
		echo '
		</select>
		<div class="btndel" onclick="showDelCaution()">Удалить</div><br>
		<div class="delcaution" id="delcaution">
			Данное действие удалит все объекты и свойства связанные с выбранной категорией.
			Удалить?
			<input type="submit" name="cat_delete" value="Да"/>
			<span onclick="showDelCaution()">Нет</span>
		</div>
		</form><br>
		
		<p class="mainTittle">Управление пользователями</p>
		<ul>
			<a href="?option=change&ch=exp"><li>Добавить/Удалить эксперта</li></a>
			<a href="?option=change&ch=boss"><li>Сменить логин/пароль директора</li></a>
			<a href="?option=change&ch=adm"><li>Сменить свой логин/пароль</li></a>
		</ul>
	</div>
	<br><br>

<script type="text/javascript" src="resourses/script.js"></script>
</body>
</html>
				
		';	
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
					<h1 class="freeb">администратор</h1>
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
						<input type="hidden" name="auth_status" value="admin">
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