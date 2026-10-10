<?php

namespace Model;

class Deudores extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'deuda';
    protected static $columnasDB = ['id','nombre','apellido','doctor','total'];
    // El doctor y el total los asigna el controlador, nunca el formulario
    protected static $noAsignables = ['id','doctor','total'];
    const LONGITUDES = ['nombre'=>60,'apellido'=>60];
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

    public function validarAdeudo(){
        if(!trim($this->nombre)){
            self::$alertas['error'][]='El Nombre es obligatorio';
        }
        if(!trim($this->apellido)){
            self::$alertas['error'][]='El Apellido es obligatorio';
        }
        $this->validarLongitudes();
        return self::$alertas;
    }
}
?>