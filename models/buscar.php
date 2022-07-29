<?php 
namespace Model;
class Busqueda extends ActiveRecord{
    protected static $tabla = 'pacientes';
    protected static $columnasDB = ['id','nombre','apellido'];
    public $id;
    public $nombre;
    public $apellido;
    

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
    }

public function validarBusqueda(){
    if(!$this->id){
       
    }       
    return self::$alertas;
}

}

?>