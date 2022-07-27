<h1 class="nombre-pagina">Olvidé contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña</p>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
        />
    </div>
    <input type="submit" value="Enviar Instrucciones" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes un usuario? Inicia Sesión</a>
    <a href="/crear-usuario">¿Aún no tienes una usuario? Crea una</a>
</div>