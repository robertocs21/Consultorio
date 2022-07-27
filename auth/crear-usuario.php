<h1 class="nombre-pagina">Crear usuario</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear un usuario</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";

?>

<form class="formulario" method="POST" action="/crear-usuario">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu Nombre"
            value="<?php echo s($doctor->nombre); ?>"
        />
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu Apellido"
            value="<?php echo s($doctor->apellido); ?>"
        />
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
            value="<?php echo s($doctor->email); ?>"
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu contraseña"
            
        />
    </div>
    
    <input type="submit" value="Crear Usuario" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes un usuario? Inicia Sesión</a>
</div>