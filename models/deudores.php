<?php

namespace Model;

class Deudores extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'deuda';
    protected static $columnasDB = ['id','nombre','apellido','doctor','total'];
    public $id;
    public $nombre;
    public $apellido;
    public $doctor;
    public $total;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->doctor = $args['doctor'] ?? '';
        $this->total = $args['total'] ?? '';
    }
}
?>