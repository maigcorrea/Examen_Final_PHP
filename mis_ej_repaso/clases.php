<?php
    class Cliente{
        private $bd;
        private $nif;
        private $nombre;
        private $edad;
        private $usuario;
        private $contraseña;


        //Constructor
        public function __construct(Mysqli $db, $id="",$nom="",$ed="",$usu="",$pass=""){
            $this->bd=$db;
            $this->nif=$id;
            $this->nombre=$nom;
            $this->edad=$ed;
            $this->usuario=$usu;
            $this->contraseña=$pass;
        }

        //Get
        public function __get($param){
            return $this->$param;
        }


        //Función para insertar cliente
        public function insertar_cliente(){
            $sent="INSERT INTO Cliente VALUES(?,?,?,?,?);";

            //Como es insertar, no nos va a traer datos(fetch) y no hace falta almacenar resultados(bind_result)
            try{
                $cons=$this->bd->prepare($sent);
                $cons->bind_param("ssiss", $this->nif, $this->nombre, $this->edad,$this->usuario, $this->contraseña);
                $cons->execute();

                echo "<p>Usuario registrado correctamente</p>";
                $cons->close();
            }catch(Exception $e){
                echo "<p>Error al insertar nuevo cliente en la bd</p><br>";
                echo $e->getMessage();
            }
            

        }


        //Función para obtener todos los datos de los clientes menos la contraseña
        public function obtener_datos(){
            try{
                $sent="SELECT nif,nombre,edad,usuario from cliente";

                $cons=$this->bd->prepare($sent);//Se prepara ls consulta en la bd
                $cons->bind_result($this->nif,$this->nombre,$this->edad,$this->usuario);//Se almacenan los datos recojidos tras la ejecución de la sent en las propiedades de la clase
                $cons->execute();//Se ejecuta la sentencia

                //Recojemos los datos de la ejecución
                //Cómo nos va a devolver más de un dato en cada variable, hay que hacer un bucle para el fetch(va a ahber más de un nif, nombre,etc), también se puede almacenando los datos en un array fetch_array(MYSQLI_ASSOC) o en una matriz (fetch_all(MYSQLI_ASSOC))
                while($cons->fetch()){//Mientras la consulta devuelva datos(fetch extrae una fila de los valores devueltos por la consulta) 
                    //Llamamos al método toString()
                    echo $this."<br>";
                }

                $cons->close();//Cerrar conexión

            }catch(Exception $e){
                echo "<br>Error. No se pudieron obtener los datos de los usuarios de la bd";
                echo $e->getMessage();
            }
            

            
        }





        //toString
        public function __toString(){
            $str="<br>NIF: $this->nif<br>Nombre: $this->nombre<br>Edad: $this->edad<br>Usuario:$this->usuario<br><br>";
            return $str;
        }
    }



    class Venta{
        private $bd;
        private $cliente;
        private $producto;
        private $fecha;
        private $cantidad;
        private $estado;


        public function __construct(Mysqli $db, $cli="", $p=0, $fech="", $cant=0, $est=null){
            $this->bd=$db;
            $this->cliente=$cli;
            $this->producto=$p;
            $this->fecha=$fech;
            $this->cantidad=$cant;
            $this->estado=$est;
        }


        public function mostrar_ventas(){
            $sent="SELECT c.nombre, p.descripcion, v.fecha, v.cantidad, v.estado FROM Cliente c,Producto p,Venta v WHERE c.nif=v.cliente AND p.cod=v.producto;";

            $cons=$this->bd->prepare($sent);
            $cons->bind_result($this->cliente,$this->producto,$this->fecha,$this->cantidad,$this->estado);
            $cons->execute();

            //Nos va a devolver más de una fila para cada dato, hay que hacer un bucle
            while($cons->fetch()){
                echo $this;
            }

            $cons->close();
        }



        public function __toString(){
            $str="Cliente: $this->cliente<br>Producto: $this->producto<br>Fecha de compra: $this->fecha<br>Cantidad: $this->cantidad<br>Estado: $this->estado<br><br><br>";

            return $str;
        }
    }



    class Producto{
        private $bd;
        // private $cod;
        private $descripcion;
        private $precio;

        public function __construct(Mysqli $db, $desc="", $p=0){
            $this->bd=$db;
            $this->descripcion=$desc;
            $this->precio=$p;
        }

        public function insertar_Producto(){
            $sent="INSERT INTO producto(descripcion,precio) VALUES(?,?);";

            try {
                $cons=$this->bd->prepare($sent);
                $cons->bind_param("sd",$this->descripcion, $this->precio);
                $cons->execute();

                $cons->close();
            } catch (Exception $th) {
                echo "<p>Error al insertar el producto</p>";
                echo $th->getMessage();
            }
        }
    }
?>