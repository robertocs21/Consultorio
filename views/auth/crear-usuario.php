<?php
    $titulo = 'Crear usuario';
    // La primera cuenta se crea desde la pantalla de acceso; las demás, ya dentro del sistema
    $layout = $esPrimeraCuenta ? 'auth' : '';
?>
<?php if ($esPrimeraCuenta): ?>
    <h1 class="auth__titulo">Crea la primera cuenta</h1>
    <p class="auth__descripcion">Todavía no hay usuarios. Después, solo alguien con sesión iniciada podrá crear más.</p>
<?php else: ?>
    <div class="encabezado">
        <div>
            <a href="/Inicio" class="enlace-regreso"><?php echo icono('regresar', 16); ?> Inicio</a>
            <h1>Nuevo usuario</h1>
            <p>Da acceso a otra persona del consultorio. Compartirá los expedientes de pacientes; los adeudos son de cada usuario.</p>
        </div>
    </div>
<?php endif; ?>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario<?php echo $esPrimeraCuenta ? '' : ' tarjeta formulario--angosto'; ?>" method="POST" action="/crear-usuario">
    <div class="grid-campos grid-campos--2">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Nombre"
                autocomplete="given-name"
                maxlength="<?php echo Model\Doctores::LONGITUDES['nombre']; ?>"
                value="<?php echo s($doctor->nombre); ?>"
                required
            />
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input
                type="text"
                id="apellido"
                name="apellido"
                placeholder="Apellido"
                autocomplete="family-name"
                maxlength="<?php echo Model\Doctores::LONGITUDES['apellido']; ?>"
                value="<?php echo s($doctor->apellido); ?>"
                required
            />
        </div>
    </div>
    <div class="campo">
        <label for="email">Correo electrónico</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="correo@ejemplo.com"
            autocomplete="email"
            maxlength="<?php echo Model\Doctores::LONGITUDES['email']; ?>"
            value="<?php echo s($doctor->email); ?>"
            required
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Crea una contraseña"
            autocomplete="new-password"
            minlength="8"
            required
        />
        <small class="campo__ayuda">Mínimo 8 caracteres.</small>
    </div>

    <?php if ($esPrimeraCuenta): ?>
        <button type="submit" class="boton boton--bloque">Crear cuenta</button>
    <?php else: ?>
        <div class="formulario__acciones">
            <a href="/Inicio" class="boton boton--secundario">Cancelar</a>
            <button type="submit" class="boton"><?php echo icono('guardar', 18); ?> Crear usuario</button>
        </div>
    <?php endif; ?>
</form>
