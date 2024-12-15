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


        //EJERCICIO 5
        echo "<h2>EJERCICIO 5 - INSERTAR VENTA</h2>";
        if(isset($_POST["regVenta"])){
            //Comprobar que la fecha no sea posterior al dia de hoy
            $tiempoActual=time();
            $tiempoFecha=strtotime($_POST["fecha"]);

            if($tiempoFecha<=$tiempoActual){
                $vent=new Venta($bd,$_POST["cliente"],$_POST["producto"],$_POST["fecha"],$_POST["cantidad"]);
                $vent->insertarVenta();
            }
        }else{
    ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <select name="cliente" id="">
                <option value="" disabled selected>Selecciona un cliente</option>
                <?php
                    $clie=new Cliente($bd);
                    $listaClientes=$clie->getLista();
                    foreach ($listaClientes as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }
                ?>
            </select><br>

            <select name="producto" id="">
                <option value="" disabled selected>Selecciona un producto</option>
                <?php
                    $produ=new Producto($bd);
                    $listaProd=$produ->getLista();
                    foreach ($listaProd as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }
                ?>
            </select><br>

            <input type="date" name="fecha" id="" placeholder="Fecha"><br>
            <input type="text" name="cantidad" id="" placeholder="Cantidad"><br>

            <input type="submit" value="Enviar" name="regVenta">
        </form>
    <?php
        }

        //EJERCICIO 6
        echo "<h2>EJERCICIO 6 - COMPROBAR PRECIO DE PRODUCTOS</h2>";
        if(isset($_POST["obtP"])){
            $prod=new Producto($bd);
            foreach ($_POST as $key => $value) {
                if(str_contains($key,"prod")){
                    $prod->mostrarPrecio($value);
                }
            }
        }else{
    ?>
        <form action="#" method="post" enctype="multipart/form-data">
            
            <?php
                $produc=new Producto($bd);
                $listaP=$produc->getLista();
                foreach ($listaP as $key => $value) {
                    echo "$value<input type='checkbox' name='prod$key' value='$key'><br>";
                }
            ?>

            <input type="submit" value="Enviar" name="obtP">
        </form>
    <?php
        }

        //EJERCICIO 7
        echo "<h2>EJERCICIO 7 - MODIFICAR VENTAS</h2>";
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <?php
            $vent=new Venta($bd);
            echo $vent->ventasNoPagadas()."<input type='checkbox' name='' value=''><br>";
        ?>
    </form>
</body>
</html>