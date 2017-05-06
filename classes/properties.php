<?php
class properties extends Core {
	
	public function get_content () {session_start();
			
	if(!$_GET['cat']) {
		exit("<p>Неверный запрос!</p>");
	}
	
	if (isset($_POST['newprop_send'])){
		$name_newprop = $_REQUEST['prop_new']; 	
		if(!empty($name_newprop)){
			$insert_sql = "INSERT INTO prop (name,cat)" . "VALUES('{$name_newprop}',{$_GET['cat']});"; 
			mysqli_query($this->db,$insert_sql);
			printf ('<div class="sucsessmsg">Свойство &quot%s&quot добавлено!</div>',$name_newprop);
			$_GET['propdel'] = false;
		}
	}
	
	if (isset($_POST['prop_del'])){
		$prop_del_id = $_POST['prop_del_id'];
		$prop_del_query = "DELETE FROM prop WHERE id = $prop_del_id";
		mysqli_query($this->db,$prop_del_query);
		if (mysqli_query($this->db,$prop_del_query)) {
			printf ('<div class="sucsessmsg">Свойство &quot%s&quot удалено!</div>',$_POST['prop_del_name']);
		}else {
			echo '<div class="sucsessmsg">Ошибка удаления!</div>';
		}
	}
		
	echo '
	<body>
	<div class="adminlist">
		<a href="?option=admin" class="backbtn"><span>&#8592 Назад</span></a>
		<p class="status">Администратор</p>
		<p class="mainTittle">Категория: 
	';
		
	$tittlecat_query = mysqli_query($this->db,"SELECT id, name FROM cat WHERE id = {$_GET['cat']}");
	if(!$tittlecat_query) {exit(mysqli_error());}
	$tittlecat = mysqli_fetch_array($tittlecat_query, MYSQLI_ASSOC);
	printf($tittlecat['name']);
		
	echo'
		 </p>
		<p class="mainTittle">Добавить свойство</p>
		<form action="" method="post">
			<input type="text" name="prop_new" placeholder="Новое свойство...">
			<input type="submit" name="newprop_send" value="Добавить"/>
		</form>
	</div>
	<div class="propertieslist">
		<p class="mainTittle">Свойства</p>
		<ul>
	';
		$cat_num = $_GET['cat'];
		$prop_query = "SELECT id, name, cat FROM prop WHERE cat = $cat_num ORDER BY name";
		$prop_result = mysqli_query($this->db,$prop_query);
		/*if(!$prop_result) {exit(mysqli_error());}*/
		$prop_row = array();
		for($i=1; $i<=mysqli_num_rows($prop_result); $i++) {
			$prop_row = mysqli_fetch_array($prop_result, MYSQLI_ASSOC);
			printf(
			'<li>%s
				<form action="" method="post">
					<input type="hidden" name="prop_del_id" value="%s"/>
					<input type="hidden" name="prop_del_name" value="%s"/>
					<button name="prop_del" class="delbtn">Удалить</button>
				</form>
			</li>'
			,$prop_row['name'],$prop_row['id'],$prop_row['name']);
		}
		
	echo '
		</ul>	
	</div>
	<br><br>
	
<script type="text/javascript" src="resourses/script.js"></script>
</body>
</html>	
	';		
		
	}
	
}
?>