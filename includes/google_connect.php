<?php
require_once __DIR__ . '/../controlador/Conexion.php';
require_once __DIR__ . '/../controlador/ControladorUsuario.php';

// Cuando el index.php es llamado desde Google tras la autenticación
// nos pasa el parámetro "code" mediante una petición get.    
if(isset($_GET["code"]))
{
  try {
    // Obtenemos el objeto token
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    // Si ha habido algún error en la autenticación, el array asociativo $token 
    // contendrá la variable "error", en caso contrario hay éxito y 
    // ya podemos recuperar los datos del perfil del usuario
    if(!isset($token['error']))
    {
      // Set the access token used for requests
      $google_client->setAccessToken($token['access_token']);

      // Store "access_token" value in $_SESSION variable for future use.
      $_SESSION['access_token'] = $token['access_token'];

      // Create Object of Google Service OAuth 2 class
      $google_service = new Google_Service_Oauth2($google_client);

      // Get user profile data from google
      $data = $google_service->userinfo->get();

      // Store Google profile data in session
      if(!empty($data['given_name']))
      {
        $_SESSION['user_first_name'] = $data['given_name'];
      }

      if(!empty($data['family_name']))
      {
        $_SESSION['user_last_name'] = $data['family_name'];
      }

      if(!empty($data['email']))
      {
        $_SESSION['user_email_address'] = $data['email'];
      }

      if(!empty($data['picture']))
      {
        $_SESSION['user_image'] = $data['picture'];
      }
      
      $email = $data['email'];

      // Buscar usuario en la base de datos
      $conex = new Conexion();
      $stmt = $conex->prepare("SELECT id_usuario, id_direccion, id_tipo_usuario, nombre, apellido1 FROM usuario WHERE email = :email");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      
      if ($stmt->rowCount() > 0) {
        // Usuario existe. Si venimos del flujo de registro iniciado por Google,
        // evitamos hacer auto-login y devolvemos al usuario a la página de registro
        // para que confirme/complemente sus datos.
        if (!empty($_SESSION['google_autoregistered'])) {
          $_SESSION['google_email'] = $email;
          $_SESSION['google_nombre'] = $data['given_name'] ?? '';
          $_SESSION['google_apellido'] = $data['family_name'] ?? '';
          header("Location: registro.php");
          exit();
        }

        // Usuario existe y no es un registro reciente por Google: iniciar sesión
        $usuario = $stmt->fetch(PDO::FETCH_OBJ);
        $_SESSION['id_usuario'] = $usuario->id_usuario;
        $_SESSION['email'] = $email;
        $_SESSION['id_direccion'] = $usuario->id_direccion;
        $_SESSION['id_tipo_usuario'] = $usuario->id_tipo_usuario;
        $_SESSION['nombre'] = $usuario->nombre;

        // Redirigir al index
        header("Location: index.php");
        exit();
      } else {
        // Usuario no existe, registrar automáticamente con Google
        $nombre = $data['given_name'] ?? 'Usuario';
        $apellido1 = $data['family_name'] ?? 'Google';
        $apellido2 = '';
        $telefono = '000000000'; // Teléfono por defecto para usuarios de Google
        
        // Generar contraseña aleatoria (no la usarán porque siempre usarán Google)
        $passwordAleatorio = bin2hex(random_bytes(16));
        
        // Registrar usuario automáticamente
        if (ControladorUsuario::registrarUsuarioCliente(
          $nombre,
          $apellido1,
          $apellido2,
          $email,
          $telefono,
          $passwordAleatorio
        )) {
          // Registro automático completado: llevar al usuario a la página de registro
          // para que confirme/complemente sus datos (correo/nombre ya están en sesión).
          $_SESSION['google_email'] = $email;
          $_SESSION['google_nombre'] = $nombre;
          $_SESSION['google_apellido'] = $apellido1;
          $_SESSION['google_autoregistered'] = true;
          header("Location: registro.php");
          exit();
        } else {
          // Si falla el registro automático, redirigir a registro manual
          $_SESSION['google_email'] = $email;
          $_SESSION['google_nombre'] = $nombre;
          $_SESSION['google_apellido'] = $apellido1;
          $_SESSION['error_google'] = "No se pudo crear tu cuenta automáticamente. Por favor, completa el registro.";
          header("Location: registro.php");
          exit();
        }
      }
    } else {
      // Error en el token de Google
      $_SESSION['error_google'] = "Error al autenticar con Google. Inténtalo de nuevo.";
      header("Location: login.php");
      exit();
    }
  } catch (Exception $e) {
    // Error general
    $_SESSION['error_google'] = "Error de conexión con Google: " . htmlspecialchars($e->getMessage());
    header("Location: login.php");
    exit();
  }
}

// Si no se ha hecho el login con Google, mostramos un botón para iniciar sesión
if(!isset($_SESSION['access_token']))
{
  // Create a URL to obtain user authorization
  $login_button = '<a href="'.$google_client->createAuthUrl().'" class="btn btn-outline-secondary py-2 d-flex align-items-center justify-content-center text-decoration-none">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48" class="me-2">
      <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
      <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
      <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
      <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
    </svg>
    <span class="text-dark">Continuar con Google</span>
  </a>';
}
?>