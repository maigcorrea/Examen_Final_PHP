<?php
    class cliente{
        private $bd;
        private $nif;
        private $nombre;
        private $edad;
        private $usuario;
        private $pass;

        public function __construct(MySqli $db, $id="", $nom="", $ed=0, $usu="", $p=""){
            $this->bd=$db;
            $this->nif=$id;
            $this->nombre=$nom;
            $this->edad=$ed;
            $this->usuario=$usu;
            $this->pass=$p;
        }

        public function getLista(){
            $sent="SELECT nif,nombre FROM Cliente";

            $cons=$this->bd->prepare($sent);
            $cons->bind_result($this->nif, $this->nombre);
            $cons->execute();

            $lista=[];
            while($cons->fetch()){
                $lista[$this->nif]=$this->nombre;
            }

            $cons->close();
            return $lista;
        }

        public function insertarCliente(){
            $sent="INSERT INTO cliente VALUES(?,?,?,?,?);";

            $cons=$this->bd->prepare($sent);
            $cons->bind_param("ssiss",$this->nif, $this->nombre, $this->edad, $this->usuario, $this->pass);
            $cons->execute();

            $cons->close();
        }


        public function mostrarDatos(){
            $sent="SELECT nif,nombre,edad,usuario FROM cliente";

            $cons=$this->bd->prepare($sent);
            $cons->bind_result($this->nif, $this->nombre, $this->edad, $this->usuario);
            $cons->execute();

            while($cons->fetch()){
                echo $this;
            }

            $cons->close();
        }


        public function __toString(){
            $str="<br>NIF: $this->nif<br>NOMBRE: $this->nombre<br>EDAD: $this->edad<br> USUARIO: $this->usuario<br>";
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


        public function __construct(MySqli $db, $cli="",$prod=0, $fe="",$cant=""){
            $this->bd=$db;
            $this->cliente=$cli;
            $this->producto=$prod;
            $this->fecha=$fe;
            $this->cantidad=$cant;
        }

        public function ventasNoPagadas(){
            $sent="SELECT c.nombre, p.descripcion, v.fecha, v.cantidad, v.estado FROM cliente c, venta v, producto p WHERE v.cliente=c.nif AND v.producto=p.cod AND v.estado IS NULL;";

            $cons=$this->bd->prepare($sent);
            $cons->bind_result($this->cliente,$this->producto,$this->fecha,$this->cantidad, $this->estado);
            $cons->execute();

            $lista=[];
            while($cons->fetch()){
                echo $this."";
            }
            $cons->close();
        }

        public function insertarVenta(){
            $sent="INSERT INTO venta (cliente,producto,fecha,cantidad) VALUES (?,?,?,?);";

            $cons=$this->bd->prepare($sent);
            $cons->bind_param("sisd",$this->cliente, $this->producto, $this->fecha, $this->cantidad);
            $cons->execute();

            $cons->close();
        }

        public function mostrarVentas(){
            $sent="SELECT c.nombre, p.descripcion, v.fecha, v.cantidad, v.estado FROM venta v ,cliente c, producto p WHERE v.cliente=c.nif AND v.producto=p.cod;";

            $cons=$this->bd->prepare($sent);
            $cons->bind_result($this->cliente, $this->producto, $this->fecha, $this->cantidad, $this->estado);

            $cons->execute();
            while($cons->fetch()){
                echo $this;
            }

            $cons->close();
        }


        public function __toString(){
            $str="Cliente: $this->cliente<br>Producto: $this->producto<br>Fecha de compra: $this->fecha<br>Cantidad: $this->cantidad<br>Estado: $this->estado<br><br>";

            return $str;
        }
    }


    class Producto{
        private $bd;
        private $cod;
        private $descripcion;
        private $precio;

        public function __construct(MySqli $db, $desc="", $pre=0){
            $this->bd=$db;
            $this->descripcion=$desc;
            $this->precio=$pre;
        }


        public function mostrarPrecio($cod){
            $sent="SELECT descripcion, precio FROM producto WHERE cod=?;";

            $cons=$this->bd->prepare($sent);
            $cons->bind_param("i",$cod);
            $cons->bind_result($this->descripcion,$this->precio);
            $cons->execute();

            $cons->fetch();

            $cons->close();

            echo "El precio de $this->descripcion es $this->precio €<br>";
        }

        public function getLista(){
            $sent="SELECT cod, descripcion FROM producto;";

            $cons=$this->bd->prepare($sent);
            $cons->bind_result($this->cod,$this->descripcion);
            $cons->execute();

            $lista=[];
            while($cons->fetch()){
                $lista[$this->cod]=$this->descripcion;
            }

            $cons->close();
            return $lista;
        }


        public function insertarProd(){
            $sent="INSERT INTO producto(descripcion,precio) VALUES (?,?);";

            $cons=$this->bd->prepare($sent);
            $cons->bind_param("sd",$this->descripcion,$this->precio);
            $cons->execute();

            $cons->close();
        }
    }
?>