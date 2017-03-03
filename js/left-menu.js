function menuInit() {
	var dropdown = document.getElementById("dropdown-item");
	var submenu = document.getElementById("submenu");

	dropdown.onmouseover = popOutMenu;
	dropdown.onmouseout = hideDropdown;

	submenu.onmouseover = popOutMenu;
	submenu.onmouseout = hideDropdown;
}

function popOutMenu () {
	submenu.className = "show-submenu";
}

function hideDropdown () {
	submenu.className = "hide-submenu";
}