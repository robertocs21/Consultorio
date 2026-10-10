<?php
    // Cada vista puede definir $titulo y $layout = 'auth' antes de llegar aquí
    $esAuth = ($layout ?? '') === 'auth';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo) ? s($titulo) . ' · ' : ''; ?>Consultorio Martín Peraza</title>
    <link rel="icon" type="image/png" href="/build/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body class="<?php echo $esAuth ? 'body-auth' : 'body-app'; ?>">

<?php if ($esAuth): ?>
    <main class="auth">
        <aside class="auth__marca">
            <img src="/build/img/logo-completo.png" alt="Martín Peraza · Servicios Dentales" width="900" height="676">
            <p>Expedientes clínicos y control de cobros del consultorio.</p>
        </aside>
        <section class="auth__panel">
            <?php echo $contenido; ?>
        </section>
    </main>
<?php else: ?>
    <header class="barra">
        <div class="barra__contenido">
            <a class="barra__logo" href="/Inicio">
                <img src="/build/img/marca.png" alt="" width="40" height="40">
                <span>Consultorio <strong>Martín Peraza</strong></span>
            </a>

            <nav class="barra__nav" aria-label="Principal">
                <a href="/Inicio" class="<?php echo claseActiva('/Inicio'); ?>"><?php echo icono('inicio'); ?> Inicio</a>
                <a href="/crear-paciente" class="<?php echo claseActiva('/crear-paciente'); ?>"><?php echo icono('paciente-nuevo'); ?> <span>Nuevo<span class="barra__extra"> paciente</span></span></a>
                <a href="/busqueda" class="<?php echo claseActiva('/busqueda'); ?>"><?php echo icono('buscar'); ?> Buscar</a>
                <a href="/deudores" class="<?php echo claseActiva('/deudores'); ?>"><?php echo icono('adeudos'); ?> Adeudos</a>
            </nav>

            <div class="barra__usuario">
                <?php if (!empty($_SESSION['nombre'])): ?>
                    <span class="barra__nombre"><?php echo s($_SESSION['nombre']); ?></span>
                <?php endif; ?>
                <a href="/logout" class="boton boton--fantasma boton--chico"><?php echo icono('salir', 18); ?> Salir</a>
            </div>
        </div>
    </header>

    <main class="pagina">
        <?php echo $contenido; ?>
    </main>
<?php endif; ?>

    <script src="/build/js/app.js" defer></script>
</body>
</html>
