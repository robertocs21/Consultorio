<?php
    $titulo = 'Inicio';
    $deudas = $deudas ?? [];
    $porCobrar = array_sum(array_map(fn($deuda) => (float) $deuda->total, $deudas));
    $conAdeudo = count(array_filter($deudas, fn($deuda) => (float) $deuda->total > 0));
?>
<section class="bienvenida">
    <div>
        <p class="sobretitulo">Panel del consultorio</p>
        <h1>Hola, <?php echo s($_SESSION['nombre'] ?? ''); ?></h1>
        <p class="bienvenida__texto">¿Qué quieres hacer hoy?</p>
    </div>
    <div class="estadisticas">
        <a class="estadistica" href="/deudores">
            <span class="estadistica__etiqueta">Saldo por cobrar</span>
            <strong class="estadistica__valor"><?php echo dinero($porCobrar); ?></strong>
        </a>
        <a class="estadistica" href="/deudores">
            <span class="estadistica__etiqueta">Pacientes con adeudo</span>
            <strong class="estadistica__valor"><?php echo $conAdeudo; ?></strong>
        </a>
    </div>
</section>

<div class="accesos">
    <a class="acceso" href="/crear-paciente">
        <span class="acceso__icono"><?php echo icono('paciente-nuevo', 28); ?></span>
        <span class="acceso__texto">
            <strong>Registrar paciente</strong>
            <span>Abre una ficha clínica nueva con antecedentes y consentimiento.</span>
        </span>
        <span class="acceso__flecha"><?php echo icono('flecha'); ?></span>
    </a>
    <a class="acceso" href="/busqueda">
        <span class="acceso__icono"><?php echo icono('buscar', 28); ?></span>
        <span class="acceso__texto">
            <strong>Buscar paciente</strong>
            <span>Encuentra un expediente por nombre, apellido o folio.</span>
        </span>
        <span class="acceso__flecha"><?php echo icono('flecha'); ?></span>
    </a>
    <a class="acceso" href="/deudores">
        <span class="acceso__icono"><?php echo icono('adeudos', 28); ?></span>
        <span class="acceso__texto">
            <strong>Adeudos</strong>
            <span>Consulta saldos pendientes y registra cargos o abonos.</span>
        </span>
        <span class="acceso__flecha"><?php echo icono('flecha'); ?></span>
    </a>
</div>

<p class="nota-inicio">¿Alguien más del consultorio necesita acceso? <a href="/crear-usuario">Crear usuario</a></p>
