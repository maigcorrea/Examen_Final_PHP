<?php
class Cliente{
    //Establecemos los atributos, generalmente coinciden con las columnas de la tabla
    private $bd;
    private $nif;
    private $nombre;
    private $edad;
    private $usuario;
    private $pass;

    public function __construct(MySqli $db, $nf="", $nom="", $ed=0, $usu="", $pss=""){
        $this->bd = $db;
        $this->nif = $nf;
        $this->nombre = $nom;
        $this->edad = $ed;
        $this->usuario = $usu;
        $this->pass= $pss;
    }

    public function get_datos(){
        //Establecemos la sentencia
        $sent = "SELECT * FROM cliente;";
        //Preparamos la consulta
        $cons = $this->bd->prepare($sent);

        //Ligamos las columnas resultado a los atributos de la clase
        $cons->bind_result($this->nif, $this->nombre, $this->edad, $this->usuario, $this->pass);

        //Ejecutamos la consulta
        $cons->execute();

        //Recojemos los resultados
        while($cons->fetch()){
            //Llamamos al método toString()
            echo $this."<br>";
        }

        //Cerramos la consulta
        $cons->close();
    }

    public function registro(){
        //Establecemos la sentencia, tantas ? como valores a introducir
        $sent = "INSERT INTO cliente VALUES (?, ?, ?, ?, ?)";
        //Preparamos la consulta
        $cons = $this->bd->prepare($sent);

        //Ligamos los atributos de la clase (los valores) a las ?
        //Indicamos en un string los tipos de las variables s:String i:int
        $cons->bind_param("ssiss",$this->nif, $this->nombre, $this->edad, $this->usuario, $this->pass);

        //Ejecutamos la consulta
        $cons->execute();

        //Cerramos la consulta
        $cons->close();
    }

    public function get_lista(){
        $sent = "SELECT nif, nombre FROM cliente;";

        $cons = $this->bd->prepare($sent);

        $cons->bind_result($this->nif, $this->nombre);

        $cons->execute();

        $lista = array();

        //Generamos una lista con clave - DNI y Valor - Nombre
        while($cons->fetch()){
            $lista[$this->nif] = $this->nombre;
        } 

        $cons->close();

        return $lista;
    }

    public function __toString(){
        $str = "NIF: $this->nif<br>
                Nombre: $this->nombre<br>
                Edad: $this->edad<br>
                Usaurio: $this->usuario<br>";
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

    public function __construct(MySqli $db, $cl="", $pr=0, $fec="", $cant=0, $est=null){
        $this->bd = $db;
        $this->cliente = $cl;
        $this->producto = $pr;
        $this->fecha = $fec;
        $this->cantidad = $cant;
        $this->estado = $est;
    }

    public function get_datos(){
        //Establecemos la sentencia
        $sent = "SELECT nombre, descripcion, fecha, cantidad, estado FROM cliente, producto, venta
                    WHERE nif=cliente AND cod=producto;";
        //Preparamos la consulta
        $cons = $this->bd->prepare($sent);

        //Ligamos las columnas resultado a los atributos de la clase
        $cons->bind_result($this->cliente, $this->producto, $this->fecha, $this->cantidad, $this->estado);

        //Ejecutamos la consulta
        $cons->execute();

        //Recojemos los resultados
        while($cons->fetch()){
            //Llamamos al método toString()
            echo $this."<br>";
        }

        //Cerramos la consulta
        $cons->close();
    }

    public function crear(){
        //Establecemos la sentencia, tantas ? como valores a introducir
        $sent = "INSERT INTO venta(cliente, producto, fecha, cantidad) VALUES (?, ?, ?, ?)";
        //Preparamos la consulta
        $cons = $this->bd->prepare($sent);

        //Ligamos los atributos de la clase (los valores) a las ?
        //Indicamos en un string los tipos de las variables s:String i:int
        $cons->bind_param("sisd",$this->cliente, $this->producto, $this->fecha, $this->cantidad);

        //Ejecutamos la consulta
        $cons->execute();

        //Cerramos la consulta
        $cons->close();
    }

    public function __toString(){
        $str = "Cliente: $this->cliente<br>
                Producto: $this->producto<br>
                Fecha: $this->fecha<br>
                Cantidad: $this->cantidad<br>
                Estado: $this->estado<br>";
        return $str;
    }
}

class Producto{
    private $bd;
    private $cod;
    private $descripcion;
    private $precio;
    
    public function __construct(MySqli $db, $dsc="", $pr=0){
        $this->bd = $db;
        $this->descripcion = $dsc;
        $this->precio = $pr;
    }

    public function get_lista(){
        $sent = "SELECT cod, descripcion FROM producto;";

        $cons = $this->bd->prepare($sent);

        $cons->bind_result($this->cod, $this->descripcion);

        $cons->execute();

        $lista = array();

        while($cons->fetch()){
            $lista[$this->cod] = $this->descripcion;
        } 

        $cons->close();

        return $lista;
    }

    public function get_prod(int $id){
        $sent = "SELECT * FROM producto WHERE cod=?;";

        $cons = $this->bd->prepare($sent);

        $cons->bind_param("i", $id);

        $cons->bind_result($this->cod, $this->descripcion, $this->precio);

        $cons->execute();

        while($cons->fetch()){
            echo $this."<br>";
        }

        $cons->close();
    }

    public function __toString(){
        $str = "Producto $this->cod: $this->descripcion Precio: $this->precio<br>";
        return $str;
    }
}

?>