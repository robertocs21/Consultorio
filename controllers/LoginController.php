<?php

namespace Controllers;
include_once __DIR__ . '/../models/doctores.php';
include_once __DIR__ . '/../models/deudores.php';
use Model\Doctores;
use Model\Deudores;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        // Con sesión iniciada no tiene caso mostrar el login
        if(!empty($_SESSION['login'])){
            header('Location: /Inicio');
            exit;
        }
        
        $auth = new Doctores;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $alertas = [];
            $auth = new Doctores($_POST);
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                $doctor = Doctores::where('email', $auth->email);
                if($doctor){
                    if($doctor->comprobarPasswordAndVerificado($auth->password)){
                        // Id de sesión nuevo al entrar, para evitar fijación de sesión
                        session_regenerate_id(true);
                        $_SESSION['id'] = $doctor->id;
                        $_SESSION['nombre'] = trim($doctor->nombre);
                        $_SESSION['login'] = true;

                        header('location: /Inicio');
                        exit;
                    }
                }else{
                    // Mismo mensaje que con contraseña incorrecta, para no revelar qué correos existen
                    Doctores::setAlerta('error','Correo o contraseña incorrectos');
                }
            }
           
        }
        $alertas = Doctores::getAlertas();
        $router->render('auth/login', [
            'alertas'=>$alertas,
            'auth'=>$auth,
            'permitirRegistro'=>!Doctores::get(1)
        ]);
    }
    public static function logout(){
        $_SESSION = [];
        session_destroy();
        header('Location: /');
        exit;
    }
    public static function crear(Router $router){
        // Solo alguien con sesión puede dar de alta usuarios; la excepción es la primera cuenta del sistema
        $esPrimeraCuenta = !Doctores::get(1);
        if(!$esPrimeraCuenta){
            isAuth();
        }

        $doctor = new Doctores();
        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
           
            $doctor->sincronizar($_POST);
            $alertas = $doctor->validarNuevaCuenta();


            if(empty($alertas)){
                $resultado = $doctor->existeUsuario();
                if($resultado){
                    $alertas = Doctores:: getAlertas();
                }else{
                    //Hashear el password
                    $doctor->hashPassword();
                    //Crear el usuario
                    $resultado = $doctor->guardar();
                    if($resultado['resultado']){
                        if($esPrimeraCuenta){
                            header('Location: /');
                            exit;
                        }
                        $alertas['exito'][] = 'Usuario creado. Ya puede iniciar sesión con su correo.';
                        $doctor = new Doctores();
                    }
                }
            }
        }
        $router->render('auth/crear-usuario',[
            'doctor'=> $doctor,
            'alertas'=> $alertas,
            'esPrimeraCuenta'=> $esPrimeraCuenta
        ]);
    }
   
    public static function inicio(Router $router){
        isAuth();
        $deudas = Deudores::buscardoc($_SESSION['id']);
        $router->render('auth/inicio',[
            'deudas'=>$deudas
        ]);
    }
   
}