<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tu usuario</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">email</label>
        <input
            type="text"
            id="email"
            placeholder="Tu email"
            name="email"
            value="<?php echo s($auth->email); ?>"
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            placeholder="Tu Contraseña"
            name="password"
        />
    </div>
    <input type="submit" class="boton" value="Inicar Sesión">
</form>

<div class="acciones">
    <a href="/crear-usuario">¿Aún no tienes un usuario? Crea Uno</a>
</div>