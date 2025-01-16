<?php
require_once "opts.php";
require_once "helpers.php";
require_once "database.php";
if (isset($_POST['sent'])) {
  $username = filtering($_POST['username']);
  $password = $_POST['password'];
  $repassword = $_POST['repassword'];
  $result = validateUserName($username);
  if (isset($usernameErrors[$result])) $messages['username'] = $usernameErrors[$result];
  $connection = createConnection($connectionData);
  $result = checkIfUserExists($connection,$username);
  if (isset($usernameErrors[$result])) $messages['username'] = $usernameErrors[$result];
  $result = checkPassword($password);
  if (isset($passwordErrors[$result])) $messages['password'] = $passwordErrors[$result];
  $messages["repassword"] = checkRepassword($password, $repassword);
  if (isset($repasswordErrors[$result])) $messages['repassword'] = $repasswordErrors[$result];
  $result = uploadFile(PORTRAITSDIR);
  if (is_int($result) && isset($imageErrors[$result])) $messages["image"] = $imageErrors[$result];
  if (empty($messages['username']) && empty($messages['password']) && empty($messages['repassword'])
  && empty($messages['image'])) {
    $hash = encryptPassword($password);
    setUser($connection, $username, $hash, $result);
    $connection->close();
    // Redirigir al usuario al login
    header('Location: http://localhost/inventario/dist/index.php');
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
      <form class="bg-gray-400 shadow-md rounded px-8 pt-6 pb-8 mb-4"  method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
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
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Repetir contraseña
          </label>
          <input class="shadow appearance-none border <?php if (!empty($messages["repassword"])) echo "border-red-500"; ?> rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="repassword" name="repassword" type="password" placeholder="******************">
          <p class="text-red-500 text-xs italic"><?php echo $messages["repassword"]; ?></p>
        </div>     
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Retrato
          </label>          
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" name="image" type="file">
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG, JPEG (MAX.1000x1000px).</p>
          <p class="text-red-500 text-xs italic"><?php echo $messages["image"]; ?></p>
        </div>           
        <input type="hidden" name="sent" value="1">
        <div class="flex items-center justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Registro
          </button>
        </div>
      </form>       
    </div>
    <p class="text-center text-gray-500 text-xs">
        &copy;<?php echo date('Y'); ?> Antonio Corp. All rights reserved.
    </p>   
    </body>
</html>