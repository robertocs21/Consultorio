<?php

namespace Controllers;
include '../models/buscar.php';
include '../models/pacientes.php';
include '../models/deudores.php';
use Model\Pacientes;
use Model\Busqueda;
use Model\Deudores;
use MVC\Router;

class DeudaController{
    public static function deudores(Router $router){
        $pacientes = new Deudores();
        $id = $_SESSION['id'];
        $lista = $pacientes->buscardoc($id);
        //debuguear($lista);
        $router->render('auth/deudores',[
            'lista'=>$lista
        ]);
    }
    public static function agregar(Router $router){
        $paciente = new Deudores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $doctor = $_SESSION['id'];
            $cobro = $_POST['cobro'];
            $total = $cobro;
            $paciente->sincronizar($_POST);
            $paciente->total=$total;
            $paciente->doctor=$_SESSION['id'];
            $paciente->guardar();
            
            
        }
        $router->render('auth/agregar',[
            'paciente'=>$paciente
        ]);
    }
    public static function modificar(Router $router){
        $id=$_GET['id'];
        $modificar= new Deudores();
        $resultado = $modificar->find($id);
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resultado->sincronizar($_POST);
            $abono = $_POST['abono'];
            $cobro = $_POST['cobro'];
            $totalant = $resultado->total;
            if(!$cobro){
                $total = $totalant - $abono;
                $resultado->total=$total;
                $resultado->guardar();
            }else{
                $total = $totalant + $cobro;
                $resultado->total=$total;
                $resultado->guardar();
            }
    
        }
        $router->render('auth/modificar',[
            'resultado'=>$resultado
        ]);
    }
}
