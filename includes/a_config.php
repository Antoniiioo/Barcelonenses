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
	case "/vistaprevia.php":
		$CURRENT_PAGE = "Vista";
		$PAGE_TITLE = "Vista Previa";
		break;
	case "/privacidad.php":
		$CURRENT_PAGE = "Privacidad";
		$PAGE_TITLE = "Privacidad";
		break;
	case "/quienessomos.php":
		$CURRENT_PAGE = "QuienesSomos";
		$PAGE_TITLE = "Quienes Somos";
		break;
	case "/favoritos.php":
		$CURRENT_PAGE = "Favoritos";
		$PAGE_TITLE = "Favoritos";
		break;
	case "/ayuda.php":
		$CURRENT_PAGE = "Ayuda";
		$PAGE_TITLE = "Ayuda";
		break;
	case "/cesta.php":
		$CURRENT_PAGE = "Cesta";
		$PAGE_TITLE = "Cesta";
		break;
	default:
		$CURRENT_PAGE = "Index";
		$PAGE_TITLE = "Welcome to my homepage!";
}
?>