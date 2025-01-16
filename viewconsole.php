<?php
require_once "database.php";
require_once "helpers.php";
require_once "session.php";
require_once "opts.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./js/tailwind.js"></script>
	<link href="./css/output.css" rel="stylesheet">  
</head>
<body class="flex items-center justify-center h-screen">
    <?php include_once "processconsole.php"; ?>  
    <span class="p-8 max-w-lg border border-indigo-300 rounded-2xl hover:shadow-xl hover:shadow-indigo-50 flex flex-col items-center"
    href="#">
        <img src="getimages.php?image=<?php echo $row['image'];?>&type=<?php echo CONSOLES;?>" alt="<?php echo $row['consolename'];?>" title="<?php echo $row['consolename'];?>" class="shadow rounded-lg overflow-hidden border" >
        <div class="mt-6 w-full flex items-center">
            <div class="w-2/3">
                <h4 class="font-bold text-xl"><?php echo $row['maker'];?> <?php echo $row['consolename'];?></h4>
                <p class="mt-2 text-gray-600"><?php echo $row['comment'];?></p>
                <small class="text-neutral-500 dark:text-neutral-400">Fecha adqusición: <?php echo date('d-m-Y',strtotime($row['dateadquisition']));?></small>
            </div>
            <div class="w-1/3 flex-shrink-0">
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="getimages.php?image=<?php echo $profile['image'];?>&type=<?php echo PORTRAITS;?>"
                    alt="<?php echo $profile['username'];?>" title="<?php echo $profile['username'];?>">
            </div>            
        </div>
        <div class="mt-1">
            <button type="button" id="volver" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Volver al listado</button>
        </div>
    </span>
    <script type="application/javascript">
        document.getElementById("volver").addEventListener("click", function() {
            window.location.href = 'http://localhost/inventario/dist/consoles.php';
        });
    </script>      
</body>
</html>