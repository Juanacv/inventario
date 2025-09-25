<?php
require_once "opts.php";
require_once "helpers.php";
require_once "database.php";
require_once "session.php";

if (isset($_POST['sent'])) {
  $username = filtering($_POST['username']);
  $password = $_POST['password'];
  $result = validateUserName($username);
  if (isset($usernameErrors[$result])) $messages['username'] = $usernameErrors[$result];
  $result = checkPassword($password);
  if (isset($passwordErrors[$result])) $messages['password'] = $passwordErrors[$result];
  $found = false;
  if (empty($messages['username']) && empty($messages['password'])) {
    $connection = createConnection($connectionData);
    $pwd_hashed = getHash($connection, $username);
    $found = checkHash($password, $pwd_hashed);
  }  
  if ($found) {
    $id = getId($connection, $username);
    $_SESSION['user'] = base64_encode($id);
    // Redirigir al usuario al listado de consolas
    header('Location: http://localhost/inventario/dist/consoles.php');
    exit(); // Es importante llamar a exit después de una redirección
  }
  else {
    // Redirigir al usuario al listado de consolas
    header('Location: http://localhost/inventario/dist/index.php?error=1');
    exit(); // Es importante llamar a exit después de una redirección
  }
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="./js/tailwind.js"></script>
        <link href="./css/output.css" rel="stylesheet">
    </head>
    <body>
    <div class="w-screen flex mt-3 items-center justify-center">
      <form class="bg-gray-400 shadow-md rounded px-8 pt-6 pb-8 mb-4 min-w-96"  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if (isset($_GET['error'])) { ?> <p class="text-red-500 text-xs italic pt-1 pb-1">¿Seguro que estás registrado? No se ha encontrado tu perfil.</p><?php } ?>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
            Nombre de usuario
          </label>
          <input class="shadow appearance-none border <?php if (!empty($messages["username"])) echo "border-red-500"; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" value="<?php if (!empty($_POST['username'])) echo $_POST['username'];?>" placeholder="Username">
          <p class="text-red-500 text-xs italic"><?php echo $messages["username"]; ?></p>
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Contraseña
          </label>
          <input class="shadow appearance-none border <?php if (!empty($messages["password"])) echo "border-red-500"; ?> rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="******************">
          <p class="text-red-500 text-xs italic"><?php echo $messages["password"]; ?></p>
        </div>        
        <input type="hidden" name="sent" value="1">
        <div class="flex items-center justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Login
          </button>
          <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="http://localhost/inventario/dist/register.php">
            Registro
          </a>          
        </div>
      </form>       
    </div>
    <p class="text-center text-gray-500 text-xs">
        &copy;<?php echo date('Y'); ?> Antonio Corp. All rights reserved.
    </p>   
    </body>
</html>