<?php
    $titulo = 'Página no encontrada';
    $conSesion = !empty($_SESSION['login']);
    $layout = $conSesion ? '' : 'auth';
?>
<div class="vacio<?php echo $conSesion ? ' tarjeta' : ''; ?>">
    <p class="vacio__codigo">404</p>
    <h2>Página no encontrada</h2>
    <p>La dirección que abriste no existe o cambió de lugar.</p>
    <div class="vacio__acciones">
        <a href="<?php echo $conSesion ? '/Inicio' : '/'; ?>" class="boton">Ir al inicio</a>
    </div>
</div>
