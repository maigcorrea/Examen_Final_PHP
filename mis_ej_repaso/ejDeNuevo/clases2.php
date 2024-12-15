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

        public function mostrarDatos(){
            $sent="SELECT nif,nombre,edad,usuario FROM cliente";

            $cons=$this->bd->prepare($sent);
            $cons->bind_result($this->nif, $this->nombre, $this->edad, $this->usuario);
            $cons->execute();

            while($cons->fetch()){
                echo $this;
            }
        }

        public function __toString(){
            $str="<br>NIF: $this->nif<br>NOMBRE: $this->nombre<br>EDAD: $this->edad<br> USUARIO: $this->usuario<br>";
            return $str;
        }
    }

?>