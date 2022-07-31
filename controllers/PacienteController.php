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
            $resultado->sincronizar($_POST);
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
            if(!$busqueda->nombre){
                header("Location: lista-busqueda?apellido=$busqueda->apellido");
            }
            
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

        if(!$nombre){
            $apellido = $_GET['apellido'];
            $resultado = $busqueda->buscarap($apellido);
        }else{
            $resultado = $busqueda->buscar($nombre);
        }
        
        $router->render('auth/lista-busqueda',[
            'resultado'=>$resultado
        ]);
    }
    
}
