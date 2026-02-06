<?php
switch ($_SERVER["SCRIPT_NAME"]) {
	case "/juegoAntonio.php":
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


//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('206199796443-h5l61a9kpfu6oetvpekko37gtpm7pvm2.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost:8080/index.php');


$google_client->addScope('email');

$google_client->addScope('profile');


$login_button = '';


?>