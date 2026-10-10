<?php

namespace Model;

class Doctores extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'doctores';
    protected static $columnasDB = ['id','nombre','apellido','email','password'];
    const LONGITUDES = ['nombre'=>60,'apellido'=>60,'email'=>30];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    //Mensajes de validacion para la creacion de una cuenta
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][]='El Nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][]='El Apellido es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][]='El email es obligatorio';
        }elseif(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][]='El email no es válido';
        }
        if(!$this->password){
            self::$alertas['error'][]='La contraseña es obligatoria';
        }elseif(strlen($this->password) < 8){
            self::$alertas['error'][]='La contraseña debe tener al menos 8 caracteres';
        }
        $this->validarLongitudes();
        
        return self::$alertas;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        return self::$alertas;
    }

    public function existeUsuario(){
        $existe = self::where('email', $this->email);

        if($existe){
            self::$alertas['error'][] = 'El usuario ya está registrado';
        }
        return $existe;
    }
    public function hashPassword(){
        $this-> password = password_hash($this-> password, PASSWORD_BCRYPT);
    }
    public function comprobarPasswordAndVerificado($password){
        // trim(): el INSERT anterior guardaba el último valor (el hash) con un espacio al final
        $resultado = password_verify($password, trim($this->password));
        if(!$resultado){
            // Mismo mensaje que cuando el correo no existe, para no revelar qué cuentas hay
            self::$alertas['error'][]='Correo o contraseña incorrectos';
        }else{
            return true;
        }
    }

}
        
    
