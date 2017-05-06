
// admin
var currentSubmenu = false;
function showSubmenu(num) {
	if(currentSubmenu != num) {
		var submenu = document.getElementById("submenugroup" + num);
		submenu.style.marginTop = "0";
		submenu.style.opacity = "1";
		submenu.style.visibility = "visible";
		if(currentSubmenu != false) {
			var pastSubmenu = document.getElementById("submenugroup" + currentSubmenu);
			pastSubmenu.style.marginTop = "-40px";
			pastSubmenu.style.opacity = "0";
			pastSubmenu.style.visibility = "hidden";
		}
		currentSubmenu = num;
	}else{
		var submenu = document.getElementById("submenugroup" + num);
		submenu.style.marginTop = "-40px";
		submenu.style.opacity = "0";
		submenu.style.visibility = "hidden";
		currentSubmenu = false;
	}
}
var cautionStatus = false;
function showDelCaution() {
	var caution = document.getElementById("delcaution");
	if(!cautionStatus) {
		caution.style.height = "50px";
		cautionStatus = true;
	}else{
		caution.style.height = "0px";
		cautionStatus = false;
	}
}
		

