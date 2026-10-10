<?php

namespace Model;

class Pacientes extends ActiveRecord{
    protected static $tabla = 'pacientes';
    protected static $columnasDB = ['id','nombre','apellido','edad','telefono','estado','ocupacion','email',
'diabetes','cardio','cancer','epilepsia','hipertension','asma','convulsiones','vih','bebe','fuma','embarazo',
'diabetesf','cardiof','cancerf','epilepsiaf','hipertensionf','asmaf','convulsionesf','vihf','accidente',
'operacion','tratamiento','enfermedades','alergias','cepillado','radio','visita','anotaciones','sistema','fiebre','tubercolosis',
'odontograma'];

    // Colores del odontograma: rojo = por tratar, azul = realizado, negro = ausente / otro (deben coincidir con app.js)
    const COLORES_ODONTOGRAMA = ['#d0342c', '#1a5fa8', '#102033'];

    // Tamaños de las columnas en la tabla pacientes (todas VARCHAR); las que no aparecen son de 60
    const LONGITUDES = ['nombre'=>60,'apellido'=>60,'edad'=>10,'telefono'=>10,'estado'=>60,'ocupacion'=>60,'email'=>30,
'diabetes'=>60,'cardio'=>60,'cancer'=>60,'epilepsia'=>60,'hipertension'=>60,'asma'=>60,'convulsiones'=>60,'vih'=>60,'bebe'=>60,
'fuma'=>60,'embarazo'=>60,'diabetesf'=>60,'cardiof'=>60,'cancerf'=>60,'epilepsiaf'=>60,'hipertensionf'=>60,'asmaf'=>60,
'convulsionesf'=>60,'vihf'=>60,'accidente'=>60,'operacion'=>60,'tratamiento'=>60,'enfermedades'=>60,'alergias'=>60,
'cepillado'=>60,'radio'=>10,'visita'=>10,'anotaciones'=>10000,'sistema'=>60,'fiebre'=>60,'tubercolosis'=>60];

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
    public $odontograma;

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
        $this->odontograma = $args['odontograma'] ?? '';
    
        

    }
    public function validarPaciente(){
        // Solo dígitos: "55 1234 5678" no cabe en la columna de 10 caracteres
        $this->telefono = preg_replace('/\D/', '', (string) $this->telefono);

        if(!$this->nombre){
            self::$alertas['error'][]='El Nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][]='El Apellido es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][]='El Teléfono es obligatorio';
        }elseif(strlen($this->telefono) > 10){
            self::$alertas['error'][]='El Teléfono debe tener máximo 10 dígitos';
        }
        $this->validarLongitudes();
        $this->normalizarOdontograma();
        return self::$alertas;
        
}

    // El odontograma llega del navegador como JSON; solo se conservan trazos con color permitido y puntos numéricos
    public function normalizarOdontograma(){
        if(strlen((string) $this->odontograma) > 2000000){
            self::$alertas['error'][]='El odontograma tiene demasiados trazos; borra algunos e intenta de nuevo';
            return;
        }
        $datos = json_decode((string) $this->odontograma, true);
        $trazos = [];
        foreach(($datos['trazos'] ?? []) as $trazo){
            if(!is_array($trazo) || !in_array($trazo['c'] ?? '', self::COLORES_ODONTOGRAMA, true) || !is_array($trazo['p'] ?? null)) continue;
            $puntos = [];
            foreach($trazo['p'] as $punto){
                if(is_array($punto) && count($punto) === 2 && is_numeric($punto[0] ?? null) && is_numeric($punto[1] ?? null)){
                    $puntos[] = [round((float) $punto[0], 1), round((float) $punto[1], 1)];
                }
            }
            if($puntos){
                $trazos[] = ['c' => $trazo['c'], 'p' => $puntos];
            }
        }
        $this->odontograma = $trazos ? json_encode(['v' => 1, 'trazos' => $trazos]) : '';
    }


}