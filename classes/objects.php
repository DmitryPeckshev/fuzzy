<?php
class objects extends Core {
	
	public function get_content () {
			
	if(!$_GET['cat']) {
		exit("<p>Неверный запрос!</p>");
	}
		
	if (isset($_POST['newobj_send'])){
		$name_newobj = $_REQUEST['obj_new']; 	
		if(!empty($name_newobj)){
			$insert_obj =  "INSERT INTO obj (name,cat)" . "VALUES('{$name_newobj}',{$_GET['cat']});"; 
			mysqli_query($this->db,$insert_obj);
			printf ('<div class="sucsessmsg">Объект &quot%s&quot добавлен!</div>',$name_newobj);
		}
	}
	
	if($_POST['obj_delete'] && $_POST['selectobj_del']) {
		$obj_del = $_POST['selectobj_del'];
		$query_todelete = "DELETE FROM obj WHERE name = '$obj_del'";
		mysqli_query($this->db,$query_todelete);
		if (mysqli_query($this->db,$query_todelete)) {
			printf ('<div class="sucsessmsg">Объект &quot%s&quot удален!</div>',$obj_del);
		}else {
			echo '<div class="sucsessmsg">Ошибка удаления!</div>';
		}
	}
	
	if (isset($_POST['selprop_add'])){
		$cat_num = $_GET['cat'];
		$name_newprop_add = $_REQUEST['selprop_obj']; 	
		$prop_id_query = mysqli_query($this->db,"SELECT id, name, cat FROM prop WHERE name = '$name_newprop_add' AND cat = $cat_num");
		if(!$prop_id_query) {exit(mysqli_error());}
		$prop_id = mysqli_fetch_array($prop_id_query, MYSQLI_ASSOC);
		if(!empty($name_newprop_add)){
			$insert_obj_prop =  "INSERT INTO obj_prop (obj,prop)" . "VALUES({$_POST['obj_id']},{$prop_id['id']});"; 
			mysqli_query($this->db,$insert_obj_prop);
			printf ('<div class="sucsessmsg">Свойство &quot%s&quot добавлено!</div>',$name_newprop_add);
		}
	}
		
	if (isset($_POST['selprop_del'])){
		$obj_prop_id = $_POST['obj_prop_id'];
		$key_id_del = "DELETE FROM obj_prop WHERE key_id = $obj_prop_id";
		mysqli_query($this->db,$key_id_del);
		if (mysqli_query($this->db,$key_id_del)) {
			printf ('<div class="sucsessmsg">Свойство &quot%s&quot удалено!</div>',$_POST['obj_prop_name']);
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
		<p class="mainTittle">Добавить объект</p>
		<form action="" method="post">
			<input type="text" name="obj_new" placeholder="Новый объект...">
			<input type="submit" name="newobj_send" value="Добавить"/>
		</form>
	
	
	<p class="mainTittle">Удалить объект</p>
		<form action="" method="post">
		<select name="selectobj_del">
			<option></option>
		';
		
		$cat_num = $_GET['cat'];
		$objsel_query = "SELECT id, name, cat FROM obj WHERE cat = $cat_num ORDER BY name";
		$objsel_result = mysqli_query($this->db,$objsel_query);
		if(!$objsel_result) {exit(mysqli_error());}
		$objsel_row = array();
		for($i=1;$i<=mysqli_num_rows($objsel_result);$i++) {
			$objsel_row = mysqli_fetch_array($objsel_result, MYSQLI_ASSOC);
			printf(
			'<option>%s</option>'
			,$objsel_row['name']);
		}
		
		echo '
		
		</select>
		<div class="btndel" onclick="showDelCaution()">Удалить</div><br>
		<div class="delcaution" id="delcaution">
			Удалить выбранный обЪект?
			<input type="submit" name="obj_delete" value="Да"/>
			<span onclick="showDelCaution()">Нет</span>
		</div>
		</form></div><br>
	
	';
	
	$cat_num = $_GET['cat'];
	$obj_query = "SELECT id, name, cat FROM obj WHERE cat = $cat_num ORDER BY name";
	$obj_result = mysqli_query($this->db,$obj_query);
	/*if(!$obj_result) {exit(mysqli_error());}*/
	$obj_row = array();
	for($i=1;$i<=mysqli_num_rows($obj_result);$i++) {
		$obj_row = mysqli_fetch_array($obj_result, MYSQLI_ASSOC);
		printf('<div class="propertieslist">
			<p class="mainTittle">%s</p>
			<ul>'
			,$obj_row['name']
		);
		
		$obj_prop_query = "SELECT * FROM obj_prop INNER JOIN prop ON prop.id = obj_prop.prop WHERE obj = {$obj_row['id']} ORDER BY prop.name";
		$obj_prop_result = mysqli_query($this->db,$obj_prop_query);
		$obj_prop_row = array();
		$obj_prop_row_id = array();
		for($j=1;$j<=mysqli_num_rows($obj_prop_result);$j++) {
			$obj_prop_row = mysqli_fetch_array($obj_prop_result, MYSQLI_ASSOC);
			$obj_prop_row_id[$j] = $obj_prop_row['id'];
			printf('
				<li>%s
					<form action="" method="post">
						<input type="hidden" name="obj_prop_id" value="%s"/>
						<input type="hidden" name="obj_prop_name" value="%s"/>
						<button name="selprop_del" class="delbtn">Удалить</button>
					</form>
				</li>'
			,$obj_prop_row['name'], $obj_prop_row['key_id'] ,$obj_prop_row['name']
			);
		}
		
		printf('</ul>
			<form action="" method="post">
			<select name="selprop_obj">
				<option></option>');
					
		$obj_sel_query = "SELECT id, name, cat FROM prop WHERE cat = $cat_num ORDER BY name";
		$obj_sel_result = mysqli_query($this->db,$obj_sel_query);
		$obj_sel_row = array();
		for($k=1;$k<=mysqli_num_rows($obj_sel_result);$k++) {
			$obj_sel_row = mysqli_fetch_array($obj_sel_result, MYSQLI_ASSOC);
			if(in_array($obj_sel_row['id'],$obj_prop_row_id)) {
				continue;
			}
			printf('
				<option>%s</option>'
			,$obj_sel_row['name']
			);
		}
			
		printf('
			</select>
			<input type="hidden" name="obj_id" value="%s"/>
			<input type="submit" name="selprop_add" value="Добавить"/>
			</form>
			</div><br>'
			,$obj_row['id']
		);
	}
	
	echo'
<br><br>
<script type="text/javascript" src="resourses/script.js"></script>
</body>
</html>
	';
		
	}
	
}

?>