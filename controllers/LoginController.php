<?php

namespace Controllers;
include '../models/doctores.php';
use Model\Doctores;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        
        $auth = new Doctores;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $alertas = [];
            $auth = new Doctores($_POST);
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                $doctor = Doctores::where('email', $auth->email);
                if($doctor){
                    if($doctor->comprobarPasswordAndVerificado($auth->password)){
                        session_start();
                        $_SESSION['id'] = $doctor->id;
                        $_SESSION['nombre'] = $doctor->nombre;
                        $_SESSION['login'] = true;

                        header('location: /Inicio');
                    }
                }else{
                    Doctores::setAlerta('error','Usuario no encontrado');
                }
            }
           
        }
        $alertas = Doctores::getAlertas();
        $router->render('auth/login', [
            'alertas'=>$alertas,
            'auth'=>$auth
        ]);
    }
    public static function logout(){
        echo "desde logout";
    }
    public static function olvide(Router $router){
        $router->render('auth/olvide-password',[

        ]);
    }
    public static function recuperar(){
        echo "desde recuperar";
    }
    public static function crear(Router $router){
        $doctor = new Doctores();
        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
           
            $doctor->sincronizar($_POST);
            $alertas = $doctor->validarNuevaCuenta();


            if(empty($alertas)){
                $resultado = $doctor->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Doctores:: getAlertas();
                }else{
                    //Hashear el password
                    $doctor->hashPassword();
                    //Crear el usuario
                    $resultado = $doctor->guardar();
                    if($resultado){
                       header('Location: /');
                    }
                    
                    
                }
            }
        }
        $router->render('auth/crear-usuario',[
            'doctor'=> $doctor,
            'alertas'=> $alertas 
        ]);
    }
   
    public static function inicio(Router $router){
        $router->render('auth/inicio',[
            
        ]);
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
   
}