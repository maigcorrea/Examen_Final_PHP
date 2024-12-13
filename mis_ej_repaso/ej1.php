<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "clases.php";

        //Hacer conexión con base de datos
        $servidor="localhost";
        $usuario="root";
        $contraseña="";
        $db="relacion";

        $bd=new mysqli($servidor,$usuario,$contraseña,$db);

        if ($bd->connect_errno) {
            echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }else{
            echo "Conexión establecida";
        }


        //EJERCICIO 1
        $cliente=new Cliente($bd);
        $cliente->obtener_datos();
        
        //EJERCICIO 2
        
    ?>
</body>
</html>