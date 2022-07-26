<?php

namespace Controllers;
include '../models/buscar.php';
include '../models/pacientes.php';
use Model\Pacientes;
use Model\Busqueda;
use Intervention\Image\ImageManagerStatic as Image;
use MVC\Router;


class PacienteController{
    public static function registro(Router $router){
        $paciente = new Pacientes();
        $alertas = [];
        
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){            
            $paciente->sincronizar($_POST);
            $carpetaImagenes = '../views/auth/imagenes/';
            $imagen = $_FILES['imagen'];
            
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }
            $nombreImagen = md5(uniqid(rand(),true) ). ".jpg" ;
            move_uploaded_file($imagen['tmp_name'],$carpetaImagenes . $nombreImagen);
            $paciente->setImagen($nombreImagen);
            $alertas = $paciente->validarPaciente();
            if(empty($alertas)){
            $resultado = $paciente->guardar();
            }
        }
        $router->render('auth/crear-registro',[
            'paciente'=> $paciente,
            'alertas'=>$alertas
        ]);
           
    }
    public static function actualizar(Router $router){
        $id=$_GET['id'];
        $busqueda = new Pacientes();
        $alertas = [];
        $resultado = $busqueda->find($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $carpetaImagenes = '../views/auth/imagenes/';
        $imagen = $_FILES['imagen'];
            $resultado->sincronizar($_POST);
            $nombreImagen = md5(uniqid(rand(),true) ). ".jpg" ;
            move_uploaded_file($imagen['tmp_name'],$carpetaImagenes . $nombreImagen);
            $resultado->setImagen($nombreImagen);
            $resultado->guardar();
        }
        $router->render('auth/busqueda-registro',[
            'alertas'=>$alertas,
            'resultado'=>$resultado
        ]);
    }
    public static function busqueda(Router $router){
        $busqueda = new Busqueda();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $busqueda->sincronizar($_POST);
            $alertas = $busqueda->validarBusqueda();
            if(empty($alertas)){
            header("Location: lista-busqueda?nombre=$busqueda->nombre");
            
            }
        }
 
        $router->render('auth/busqueda',[
            'busqueda'=> $busqueda,
            'alertas'=>$alertas
        ]);
    }
    public static function lista(Router $router){
        $nombre = $_GET['nombre'];
        $busqueda = new Busqueda();
        $resultado = $busqueda->buscar($nombre);
        
        $router->render('auth/lista-busqueda',[
            'resultado'=>$resultado
        ]);
    }
    public static function deudores(Router $router){
        $pacientes = new Pacientes();
        $lista = $pacientes->all();
        
        $router->render('auth/deudores',[
            'lista'=>$lista
        ]);
    }
}
