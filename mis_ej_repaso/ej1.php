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
        echo "<h2>EJERCICIO 1</h2>";
        $cliente=new Cliente($bd);
        $cliente->obtener_datos();
        
        //EJERCICIO 2
        echo "<h2>EJERCICIO 2</h2>";
        echo "<h3>Las ventas son:</h3>";
        $ventas=new Venta($bd);
        $ventas->mostrar_ventas();

        //EJERCICIO 3
        echo "<h2>EJERCICIO 3 - REGISTRO DE CLIENTE</h2>";
        //Formulario de registro de cliente
        if(isset($_POST["reg"])){
            if($_POST["pass"]===$_POST["repPass"]){

                $regCliente=new Cliente($bd,$_POST["id"], $_POST["name"], $_POST["edad"], $_POST["user"], $_POST["pass"]);

                $regCliente->insertar_cliente();
                
            }else{
                echo "<p>Error. Las contraseñas no coinciden</p>";
            }
        }else{
    ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="id">Introduce tu nif</label><br>
            <input type="text" name="id"><br>
            <label for="name">Introduce tu nombre</label><br>
            <input type="text" name="name" id=""><br>
            <label for="edad">Introduce tu edad</label><br>
            <input type="number" name="edad" id=""><br>
            <label for="user">Introduce tu nickname</label><br>
            <input type="text" name="user" id=""><br>
            <label for="pass">Introduce una contraseña</label><br>
            <input type="text" name="pass" id=""><br>
            <label for="repPass">Repite la contraseña</label><br>
            <input type="text" name="repPass" id=""><br>

            <input type="submit" value="Registrarse" name="reg">
        </form>

    <?php
        }
        
        
        //EJERCICIO 4
        echo "<h2>EJERCICIO 4 - REGISTRO DE PRODUCTOS</h2>";
        if(isset($_POST["regProd"])){
            $regProd=new Producto($bd,$_POST["desc"],$_POST["prec"]);

            $regProd->insertar_Producto();
        }else{
    ?>

        <form action="#" method="post" enctype="multipart/form-data">
            <label for="desc">Introduce el nombre del producto</label><br>
            <input type="text" name="desc" id=""><br>
            <label for="prec">Introduce su precio</label><br>
            <input type="number" name="prec" step="0.11" id=""><br>

            <input type="submit" value="Registrar producto" name="regProd">
        </form>

    <?php
        }
    ?>
</body>
</html>