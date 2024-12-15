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
        //Conexión bd
        $bd=new Mysqli("localhost","root","","relacion");
        echo "Conexión hecha";
        
        //EJERCICIO 5 - INSERTAR VENTA
        if(isset($_POST["regVenta"])){
            $cliente=$_POST["cliente"];
            $producto=$_POST["producto"];
            $fecha=$_POST["fecha"];
            $cantidad=$_POST["cantidad"];

            //Comprobar que la fecha no es posterior a la fecha actual
            $segActuales=time();
            $segFecha=strtotime($fecha);
            if($segFecha<=$segActuales){
                //Convertir el campo de la cantidad(texto) a double
                $cantidad=doubleval($cantidad);

                $venta=new Venta($bd,$cliente,$producto,$fecha,$cantidad);
                $venta->insertar_Venta();
                echo "<p>Venta insertada</p>";
            }else{
                echo "Error. La fecha no puede ser futura";
            }
        }else{
    ?>
        <form action="" method="post">
            <select name="cliente" id="">
                <option value="" selected disabled>Selecciona un cliente</option>
                <?php
                    $cliente=new Cliente($bd);
                    $listaClientes=$cliente->get_lista();
                    foreach ($listaClientes as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }
                ?>
            </select><br>
            <select name="producto" id="">
                <option value="" selected disabled>Selecciona un producto</option>
                <?php
                    $producto=new Producto($bd);
                    $listaProd=$producto->get_lista();
                    foreach ($listaProd as $key => $value) {
                        echo "<option value='$key'>$value</option>";
                    }
                ?>
            </select><br>
            <label for="fecha">Introduce una fecha</label><br>
            <input type="date" name="fecha" id=""><br>
            <label for="cantidad">Intriduce la cantidad</label><br>
            <input type="text" name="cantidad" id=""><br>

            <input type="submit" value="Registrar venta" name="regVenta">
        </form>

    <?php
        }
    ?>

</body>
</html>