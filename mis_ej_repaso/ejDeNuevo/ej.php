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



        //EJERCICIO 2
        echo "<h2>EJERCICIO 2 - MOSTRAR VENTAS</h2>";
        $venta=new Venta($bd);
        $venta->mostrarVentas();



        //EJERCICIO 3
        echo "<h2>EJERCICIO 3 - INSERTAR CLIENTE</h2>";
        //En base a los datos de un formulario, creamos un nuevo cliente, y llamamos a la funciín de insertarCliente

        if(isset($_POST["regCli"])){
            if($_POST["cont1"]===$_POST["cont2"]){
                $cliente=new Cliente($bd,$_POST["nif"],$_POST["nom"],$_POST["ed"],$_POST["user"],$_POST["cont1"]);

                $cliente->insertarCliente();
            }else{
                echo "<p>Las contraseñas no coinciden</p>";
            }
        }else{
    ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="text" name="nif" id="" placeholder="NIF"><br>
            <input type="text" name="nom" id="" placeholder="Nombre"><br>
            <input type="number" name="ed" id="" placeholder="Edad"><br>
            <input type="text" name="user" id="" placeholder="Usuario"><br>
            <input type="text" name="cont1" id="" placeholder="Contraseña"><br>
            <input type="text" name="cont2" id="" placeholder="Repetir Contraseña"><br>

            <input type="submit" value="Registrar usuario" name="regCli">
        </form>

    <?php
        }


        //EJERCICIO 4
        echo "<h2>EJERCICIO 4 - INSERTAR Producto</h2>";
        if(isset($_POST["regProd"])){
            //Pasar precio a double
            $precio=doubleval($_POST["prec"]);

            $producto=new Producto($bd,$_POST["prod"],$precio);
            $producto->insertarProd();
        }else{
    ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="text" name="prod" id="" placeholder="Producto"><br>
            <input type="text" name="prec" id="" placeholder="Precio"><br>

            <input type="submit" value="Enviar" name="regProd">
        </form>
    <?php
        }
    ?>
</body>
</html>