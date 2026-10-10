<?php
    $titulo = 'Iniciar sesión';
    $layout = 'auth';
?>
<h1 class="auth__titulo">Iniciar sesión</h1>
<p class="auth__descripcion">Entra con tu correo y contraseña.</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Correo electrónico</label>
        <input
            type="email"
            id="email"
            placeholder="tu@correo.com"
            name="email"
            autocomplete="email"
            value="<?php echo s($auth->email); ?>"
            required
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            placeholder="Tu contraseña"
            name="password"
            autocomplete="current-password"
            required
        />
    </div>
    <button type="submit" class="boton boton--bloque">Iniciar sesión</button>
</form>

<?php if ($permitirRegistro): ?>
    <div class="auth__enlaces">
        <a href="/crear-usuario">¿Primera vez? <strong>Crea la cuenta principal</strong></a>
    </div>
<?php endif; ?>
