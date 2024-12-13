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
        private $producto;
        private $fecha;
        private $cantidad;
        private $estado;
    }
?>