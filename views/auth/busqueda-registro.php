<?php
    $titulo = 'Ficha de ' . $resultado->nombre . ' ' . $resultado->apellido;
    $paciente = $resultado;
    $accion = '/busqueda-registro?id=' . $resultado->id;
    $textoBoton = 'Guardar cambios';
?>
<div class="encabezado">
    <div>
        <a href="/busqueda" class="enlace-regreso"><?php echo icono('regresar', 16); ?> Buscar paciente</a>
        <h1><?php echo s($resultado->nombre . ' ' . $resultado->apellido); ?></h1>
        <p>
            <span class="folio">Folio #<?php echo s($resultado->id); ?></span>
            <?php if ($resultado->telefono): ?>
                · <?php echo s($resultado->telefono); ?>
            <?php endif; ?>
        </p>
    </div>
</div>

<?php include_once __DIR__ . "/../templates/ficha-paciente.php"; ?>
