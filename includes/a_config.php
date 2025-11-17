<?php
switch ($_SERVER["SCRIPT_NAME"]) {
	case "/index.php":
		$CURRENT_PAGE = "Index";
		$PAGE_TITLE = "Inicio";
		break;
	case "/registro.php":
		$CURRENT_PAGE = "Registro";
		$PAGE_TITLE = "Registrate";
		break;
	case "/login.php":
		$CURRENT_PAGE = "Login";
		$PAGE_TITLE = "Inicia Sesion";
		break;
	case "/listadoProductos.php":
		$CURRENT_PAGE = "Ropa";
		$PAGE_TITLE = "Ropa";
		break;
	case "/about.php":
		$CURRENT_PAGE = "About";
		$PAGE_TITLE = "About Us";
		break;
	case "/contact.php":
		$CURRENT_PAGE = "Contact";
		$PAGE_TITLE = "Contact Us";
		break;
	default:
		$CURRENT_PAGE = "Index";
		$PAGE_TITLE = "Welcome to my homepage!";
}
?>