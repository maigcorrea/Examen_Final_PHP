<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "clases2.php";
        $bd=new Mysqli("localhost","root","","relacion");

        if($bd){
            echo "<p>Conexión hecha</p>";
        }else{
            echo "<p>Error al conectar con la base de datos</p>";
        }

        //EJERCICIO 1
        echo "<h2>EJERCICIO 1 - MOSTRAR DATOS DE CLIENTES</h2>";
        $cli=new Cliente($bd);
        $cli->mostrarDatos();
    ?>
</body>
</html>