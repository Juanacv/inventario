<?php
require_once "opts.php";
require_once "helpers.php";
require_once "database.php";
require_once "session.php";
require_once "profile.php";
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="./css/output.css" rel="stylesheet">
</head>
<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
    <div class="w-full">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <?php       
            include_once "processconsole.php";           
            if (!empty($_POST)) {
                $row['consolename'] = $_POST['consolename'];
                $row['price'] = $_POST['price'];
                $row['maker'] = $_POST['maker'];
                $row['dateadquisition'] = $_POST['dateadquisition'];
                $row['comment'] = $_POST['comment'];
            } 
        ?>
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
        
            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <svg class="w-12 h-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z" fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z" fill="white"></path>
                        </svg>
                        
                        <span class="mx-2 text-2xl font-semibold text-white">Inventario</span>
                    </div>
                </div>        
                <?php  $_SESSION['highlight'] = FORM; 
                $_SESSION['urlform'] = $forms[CONSOLES][0];
                $_SESSION['tagform'] = $forms[CONSOLES][1];
                include_once "navside.php"; ?> 
            </div>
            <div class="flex flex-col flex-1 overflow-hidden">
                <?php 
                $_SESSION['nosearch'] = 0;
                include_once "header.php"; ?>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <div class="container px-6 py-8 mx-auto">
                        <h3 class="text-3xl font-medium text-gray-700">Añadir consola</h3>
                        <div class="mt-8">
                        </div>
                        <div class="flex flex-col mt-8">
                            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div
                                    class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-300 shadow sm:rounded-lg">
                                    <form class="w-full max-w-lg p-1" action="<?php echo $_SERVER["PHP_SELF"];?>?console=<?php echo isset($_GET['console']) ? $_GET['console']  : "";?>" enctype="multipart/form-data" method="POST">
                                        <div class="flex flex-wrap -mx-3 mb-6">
                                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="consolename">
                                                Nombre consola
                                            </label>
                                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border <?php if (!empty($messages["consolename"])) { echo "border-red-500"; } else { echo "border-gray-300 focus:border-gray-500"; }; ?> rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="consolename" name="consolename" value="<?php echo isset($row['consolename']) ? $row['consolename'] : "";?>" type="text" placeholder="Super Nintendo">
                                            <p class="text-red-500 text-xs italic"><?php echo $messages['consolename'] ?></p>
                                            </div>
                                            <div class="w-full md:w-1/3 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="price">
                                                Precio adquisición
                                            </label>
                                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border <?php if (!empty($messages["price"])) { echo "border-red-500"; } else { echo "border-gray-300 focus:border-gray-500"; }; ?> rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="price" name="price" type="number" min="0" max="100000" value="<?php echo isset($row['price']) ? $row['price'] : "";?>" placeholder="10">
                                            <p class="text-red-500 text-xs italic"><?php echo $messages['price'] ?></p>
                                            </div>
                                            <div class="w-full md:w-1/3 px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="maker">
                                                Fabricante
                                            </label>
                                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border <?php if (!empty($messages["maker"])) { echo "border-red-500"; } else { echo "border-gray-300 focus:border-gray-500"; }; ?> rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="maker" name="maker" value="<?php echo isset($row['maker']) ? $row['maker'] : "";?>" type="text" placeholder="Nintendo">
                                            <p class="text-red-500 text-xs italic"><?php echo $messages['maker'] ?></p>
                                            </div>                                            
                                        </div>
                                        <div class="flex flex-wrap -mx-3 mb-6">
                                            <div class="w-full px-3">
                                                <?php include_once "imageinput.php"?>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap -mx-3 mb-2">
                                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="dateadquisition">
                                                    Fecha adquisición
                                                </label>
                                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border <?php if (!empty($messages["dateadquisition"])) { echo "border-red-500"; } else { echo "border-gray-300 focus:border-gray-500"; }; ?> rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="dateadquisiton" name="dateadquisition" value="<?php echo isset($row['dateadquisition']) ? date('Y-m-d',strtotime($row['dateadquisition'])) : "";?>" type="date" placeholder="">                                                
                                                <p class="text-red-500 text-xs italic"><?php echo $messages["dateadquisition"]; ?></p>
                                            </div>
                                            <div class="w-full md:w-2/3 px-3 mb-6 md:mb-0">
                                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="comment">
                                                    Comentarios
                                                </label>
                                                <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border <?php if (!empty($messages["comment"])) { echo "border-red-500"; } else { echo "border-gray-300 focus:border-gray-500"; }; ?> rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="comment" name="comment"  placeholder="Comentarios"><?php echo isset($row['comment']) ? $row['comment'] : ""; ?></textarea>
                                                <p class="text-red-500 text-xs italic"><?php echo $messages["comment"]; ?></p>                                                
                                            </div>
                                        </div>
                                        <?php if (isset($row['id'])) { ?><input type="hidden" name="consoleid" value="<?php echo $row['id']; ?>"><?php } ?>
                                        <div class="flex items-center justify-between">
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                            <?php if (isset($row['id'])) { ?>Actualizar<?php } else { ?>Añadir<?php } ?>
                                            </button>       
                                        </div>                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
