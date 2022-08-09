<?php

namespace Model;

class Pacientes extends ActiveRecord{
    protected static $tabla = 'pacientes';
    protected static $columnasDB = ['id','nombre','apellido','edad','telefono','estado','ocupacion','email',
'diabetes','cardio','cancer','epilepsia','hipertension','asma','convulsiones','vih','bebe','fuma','embarazo',
'diabetesf','cardiof','cancerf','epilepsiaf','hipertensionf','asmaf','convulsionesf','vihf','accidente',
'operacion','tratamiento','enfermedades','alergias','cepillado','radio','visita','anotaciones','sistema','fiebre','tubercolosis'];

    public $id;
    public $nombre;
    public $apellido;
    public $edad;
    public $telefono;
    public $estado;
    public $ocupacion;
    public $email;
    public $diabetes;
    public $cardio;
    public $cancer;
    public $epilepsia;
    public $hipertension;
    public $asma;
    public $convulsiones;
    public $vih;
    public $bebe;
    public $fuma;
    public $embarazo;
    public $diabetesf;
    public $cardiof;
    public $cancerf;
    public $epilepsiaf;
    public $hipertensionf;
    public $asmaf;
    public $convulsionesf;
    public $vihf;
    public $accidente;
    public $operacion;
    public $tratamiento;
    public $enfermedades;
    public $alergias;
    public $cepillado;
    public $radio;
    public $visita;
    public $imagen;
    public $anotaciones;
    public $sistema;
    public $fiebre;
    public $tubercolosis;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->edad = $args['edad'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->ocupacion = $args['ocupacion'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->diabetes = $args['diabetes'] ?? '';
        $this->cardio = $args['cardio'] ?? '';
        $this->cancer = $args['cancer'] ?? '';
        $this->epilepsia = $args['epilepsia'] ?? '';
        $this->hipertension = $args['hipertension'] ?? '';
        $this->asma = $args['asma'] ?? '';
        $this->convulsiones = $args['convulsiones'] ?? '';
        $this->vih = $args['vih'] ?? '';
        $this->bebe = $args['bebe'] ?? '';
        $this->fuma = $args['fuma'] ?? '';
        $this->embarazo = $args['embarazo'] ?? '';
        $this->diabetesf = $args['diabetesf'] ?? '';
        $this->cardiof = $args['cardiof'] ?? '';
        $this->cancerf = $args['cancerf'] ?? '';
        $this->epilepsiaf = $args['epilepsiaf'] ?? '';
        $this->hipertensionf = $args['hipertensionf'] ?? '';
        $this->asmaf = $args['asmaf'] ?? '';
        $this->convulsionesf = $args['convulsionesf'] ?? '';
        $this->vihf = $args['vihf'] ?? '';
        $this->accidente = $args['accidente'] ?? '';
        $this->operacion = $args['operacion'] ?? '';
        $this->tratamiento = $args['tratamiento'] ?? '';
        $this->enfermedades = $args['enfermedades'] ?? '';
        $this->alergias = $args['alergias'] ?? '';
        $this->cepillado = $args['cepillado'] ?? '';
        $this->radio = $args['radio'] ?? '';
        $this->visita = $args['visita'] ?? '00/00/0000';
        $this->anotaciones = $args['anotaciones'] ?? '';
        $this->sistema = $args['sistema'] ?? '';
        $this->fiebre = $args['fiebre'] ?? '';
        $this->tubercolosis = $args['tubercolosis'] ?? '';
    
        

    }
    public function validarPaciente(){
        if(!$this->nombre){
            self::$alertas['error'][]='El Nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][]='El Apellido es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][]='El Teléfono es obligatorio';
        }
        return self::$alertas;
        
}


}