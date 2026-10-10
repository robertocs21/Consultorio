<?php

namespace Controllers;
include_once __DIR__ . '/../models/buscar.php';
include_once __DIR__ . '/../models/pacientes.php';
use Model\Pacientes;
use Model\Busqueda;
use Intervention\Image\ImageManagerStatic as Image;
use MVC\Router;


class PacienteController{
    public static function registro(Router $router){
        isAuth();
        $paciente = new Pacientes();
        $alertas = [];
        
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){            
            $paciente->sincronizar($_POST);
            
            $alertas = $paciente->validarPaciente();
            if(empty($alertas)){
            $resultado = $paciente->guardar();
                if($resultado['resultado']){
                    header('Location: /busqueda-registro?id=' . $resultado['id'] . '&creado=1');
                    exit;
                }
            }
        }
        $router->render('auth/crear-registro',[
            'paciente'=> $paciente,
            'alertas'=>$alertas
        ]);
           
    }
    public static function actualizar(Router $router){
        isAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $alertas = [];
        $resultado = Pacientes::find($id);
        if(!$resultado){
            header("Location: /busqueda?noencontrado=$id");
            exit;
        }
        if(isset($_GET['creado'])){
            $alertas['exito'][] = 'Paciente registrado correctamente.';
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resultado->sincronizar($_POST);
            $alertas = $resultado->validarPaciente();
            if(empty($alertas)){
                $resultado->guardar();
                $alertas['exito'][] = 'Cambios guardados.';
            }
        }
        $router->render('auth/busqueda-registro',[
            'alertas'=>$alertas,
            'resultado'=>$resultado
        ]);
    }
    public static function busqueda(Router $router){
        isAuth();
        $busqueda = new Busqueda();
        $alertas = [];
        if(isset($_GET['noencontrado'])){
            $alertas['error'][] = 'No existe un paciente con el folio ' . (int) $_GET['noencontrado'] . '.';
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $busqueda->sincronizar($_POST);
            $alertas = $busqueda->validarBusqueda();
            if(empty($alertas)){
                $folio = (int) ($_POST['folio'] ?? 0);
                if($folio){
                    header("Location: /busqueda-registro?id=$folio");
                }elseif($busqueda->nombre){
                    header('Location: /lista-busqueda?nombre=' . urlencode($busqueda->nombre));
                }else{
                    header('Location: /lista-busqueda?apellido=' . urlencode($busqueda->apellido));
                }
                exit;
            }
        }
 
        $router->render('auth/busqueda',[
            'busqueda'=> $busqueda,
            'alertas'=>$alertas
        ]);
    }
    public static function lista(Router $router){
        isAuth();
        $nombre = $_GET['nombre'] ?? '';
        $apellido = $_GET['apellido'] ?? '';
        $busqueda = new Busqueda();

        if(!$nombre){
            $resultado = $busqueda->buscarap($apellido);
        }else{
            $resultado = $busqueda->buscar($nombre);
        }
        
        $router->render('auth/lista-busqueda',[
            'resultado'=>$resultado,
            'termino'=>$nombre ?: $apellido
        ]);
    }
    
}
