<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require_once "class.BDConn.php"; ?>
    <h2>Ejercicio 1</h2>
    <?php 
        $bd = new mysqli("localhost", "root", "", "relacion");
        //Seteo el set de caracteres a utf8, para mostrar tildes y tal
        $bd->set_charset("utf8");

        $clientes = new Cliente($bd);

        $clientes->get_datos();
    ?>

    <h2>Ejercicio 2</h2>
    <?php
        $ventas = new Venta($bd);
        $ventas->get_datos();
    ?>

    <h3>Ejercicio 3</h3>
    <?php
        if(isset($_POST["env"])){
            $nif = $_POST["nif"];
            $nom = $_POST["nom"];
            $ed = $_POST["ed"];
            $usu = $_POST["usu"];
            $pass = $_POST["pass"];

            //Instanciamos la clase usando los datos del formulario
            $cli = new Cliente($bd, $nif, $nom, $ed, $usu, $pass);

            //Llamamos al método para insertar
            $cli->registro();

            echo '<meta http-equiv="Location" content="rel10.php">';
        }
    ?>
        <form action="#" method="post">
            <label for="nif">NIF:</label>
            <input type="text" name="nif">
            <br>
            <label for="nom">Nombre:</label>
            <input type="text" name="nom">
            <br>
            <label for="ed">Edad:</label>
            <input type="number" name="ed">
            <br>
            <label for="usu">Usuario:</label>
            <input type="text" name="usu">
            <br>
            <label for="pass">Contraseña:</label>
            <input type="password" name="pass">
            <br>
            <input type="submit" value="Enviar" name="env">
        </form>


        <h3>Ejercicio 5</h3>
        <?php
            if(isset($_POST["env2"])){
                $dni = $_POST["idCli"];
                $idProd = $_POST["idProd"];
                $fecha = $_POST["fec"];
                $precio = $_POST["prec"];

                //Comprobamos que se haya introducido el valor de dni e id correctamente
                if(strcmp($dni,"-") != 0 && strcmp($idProd, "-")){
                    $tmstmp = time();
                    $fVent = strtotime($fecha);

                    //Comprobamos que la fecha de venta no sea posterior a la de hoy
                    if($fVent <= $tmstmp){
                        //Pasamos el precio de texto a double
                        $precio = doubleval($precio);
                        $venta = new Venta($bd, $dni, $idProd, $fecha, $precio);

                        //Insertamos la venta
                        $venta->crear();

                        echo '<meta http-equiv="Location" content="rel10.php">';
                    }
                }

            }
        ?>      
        <form action="#" method="post">
            <select name="idCli">
                <option value="-">Selecciona el cliente</option>
                <?php
                    $clientes = new Cliente($bd);
                    //Obtenemos la lista de DNI y nombre de clientes
                    $lCli = $clientes->get_lista();

                    foreach($lCli as $DNI => $nom){
                        echo '<option value="'.$DNI.'">'.$nom.'</option>';
                    }
                ?>
            </select>
            <br>
            <select name="idProd">
                <option value="-">Selecciona el producto</option>
                <?php
                    $prods = new Producto($bd);
                    //Obtenemos la lista de id y nombre de productos
                    $lProd = $prods->get_lista();

                    foreach($lProd as $id => $desc){
                        echo '<option value="'.$id.'">'.$desc.'</option>';
                    }
                ?>
            </select>
            <br>
            <input type="date" name="fec">
            <br>
            <input type="text" name="prec">
            <br>
            <input type="submit" value="Enviar" name="env2">
        </form>

        <h3>Ejercicio 6</h3>
        <?php
            if(isset($_POST["env3"])){
                $prod = new Producto($bd);
                foreach($_POST as $key => $value){
                    if(str_contains($key, "Prd"))
                        $prod->get_prod($value);
                }
            }
        ?>
        <form action="#" method="post">
            <?php
                $prods = new Producto($bd);
                //Obtenemos la lista de id y nombre de productos
                $lProd = $prods->get_lista();

                foreach($lProd as $id => $desc){
                    echo '<label for="'.$id.'">'.$desc.'</label>';
                    echo '<input type="checkbox" name="Prd'.$id.'" value="'.$id.'"><br>';
                }
            ?>
            <br>
            <input type="submit" value="Enviar" name="env3">
        </form>
</body>
</html>