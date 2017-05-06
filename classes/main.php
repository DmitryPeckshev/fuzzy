<?php
class main extends Core {
	
	public function get_content () {
				
		echo '
		<body>
	<div class="mainMenu" id="mainMenu">
		<p class="mainTittle">Выберите ваш статус</p>
		<div class="mainMenuElem">
			<a href="?option=boss"><p>Директор</p></a>
		</div>
		<div class="mainMenuElem">
			<a href="?option=expert"><p>Эксперт</p></a>
		</div>
		<div class="mainMenuElem">
			<a href="?option=admin"><p>Администратор</p></a>
		</div>
	</div>
		<script type="text/javascript" src="resourses/script.js"></script>
		</body>
		</html>
		';
	}
}
?>