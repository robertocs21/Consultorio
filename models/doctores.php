<?php

namespace Model;

class Doctores extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'doctores';
    protected static $columnasDB = ['id','nombre','apellido','email','password'];
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
        }
        if(!$this->password){
            self::$alertas['error'][]='La contraseña es obligatorio';
        }
        
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
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '". $this->email . "' LIMIT 1";
        
        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El usuario ya está registrado';
        }
        return $resultado;
    }
    public function hashPassword(){
        $this-> password = password_hash($this-> password, PASSWORD_BCRYPT);
    }
    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado){
            self::$alertas['error'][]='Contraseña incorrecta';
        }else{
            return true;
        }
    }

}
        
    
