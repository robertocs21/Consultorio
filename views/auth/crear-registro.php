<?php
    $titulo = 'Nuevo paciente';
    $accion = '/crear-paciente';
    $textoBoton = 'Registrar paciente';
?>
<div class="encabezado">
    <div>
        <h1>Nuevo paciente</h1>
        <p>Los campos marcados con <span class="obligatorio">*</span> son obligatorios.</p>
    </div>
</div>

<?php include_once __DIR__ . "/../templates/ficha-paciente.php"; ?>
