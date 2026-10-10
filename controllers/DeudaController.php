<?php

namespace Controllers;
include_once __DIR__ . '/../models/buscar.php';
include_once __DIR__ . '/../models/pacientes.php';
include_once __DIR__ . '/../models/deudores.php';
use Model\Pacientes;
use Model\Busqueda;
use Model\Deudores;
use MVC\Router;

class DeudaController{
    // Busca el adeudo y verifica que sea del doctor con sesión; si no, regresa a la lista
    private static function adeudoPropio($id){
        $adeudo = Deudores::find($id);
        if(!$adeudo || (string) $adeudo->doctor !== (string) $_SESSION['id']){
            header('Location: /deudores');
            exit;
        }
        return $adeudo;
    }

    public static function deudores(Router $router){
        isAuth();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resultado = self::adeudoPropio($_POST['id'] ?? 0);
            $resultado->eliminar();
            header('location: /deudores');
            exit;
        }
        $lista = Deudores::buscardoc($_SESSION['id']);
        $router->render('auth/deudores',[
            'lista'=>$lista
        ]);
    }
    public static function agregar(Router $router){
        isAuth();
        $paciente = new Deudores();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $cobro = (float) ($_POST['cobro'] ?? 0);
            $paciente->sincronizar($_POST);
            $alertas = $paciente->validarAdeudo();
            if($cobro <= 0){
                $alertas['error'][] = 'El monto del adeudo debe ser mayor a cero';
            }
            if(empty($alertas)){
                $paciente->total=$cobro;
                $paciente->doctor=$_SESSION['id'];
                $paciente->guardar();
                header('Location: /deudores');
                exit;
            }
        }
        $router->render('auth/agregar',[
            'paciente'=>$paciente,
            'alertas'=>$alertas
        ]);
    }
    public static function modificar(Router $router){
        isAuth();
        $resultado = self::adeudoPropio($_GET['id'] ?? 0);
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resultado->sincronizar($_POST);
            $abono = (float) ($_POST['abono'] ?? 0);
            $cobro = (float) ($_POST['cobro'] ?? 0);
            $alertas = $resultado->validarAdeudo();
            if($cobro < 0 || $abono < 0){
                $alertas['error'][] = 'Las cantidades no pueden ser negativas';
            }
            if(empty($alertas)){
                $totalant = (float) $resultado->total;
                // Antes, si se capturaban cargo y abono a la vez, el abono se ignoraba
                $total = $totalant + $cobro - $abono;
                $resultado->total=$total;
                $resultado->guardar();
                $alertas['exito'][] = ($cobro || $abono)
                    ? 'Movimiento guardado. Nuevo saldo: ' . dinero($total)
                    : 'Datos del paciente actualizados.';
            }
        }
        $router->render('auth/modificar',[
            'resultado'=>$resultado,
            'alertas'=>$alertas
        ]);
    }
}
