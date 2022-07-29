<h1 class="nombre-pagina">Busca a un paciente</h1>
<p class="descripcion-pagina">Ingresa sus datos para hacer la busqueda</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<form class="formulario" method="POST" action="/busqueda">
    <div class="campo">
        <label for="paciente">Nombre</label>
        <input
            type="text"
            id="nombre"
            placeholder="Nombre del paciente"
            name="nombre"
        />
    </div>
    <div class="campo">
        <label for="apellido">Apellido del paciente</label>
        <input
            type="text"
            id="apellido"
            placeholder="Apellido(s) del paciente"
            name="apellido"
        />
    </div>
    <div class="campo">
        <label for="folio">Número de folio</label>
        <input
            type="number"
            id="folio"
            placeholder="Folio (opcional)"
            name="folio"
        />
    </div>
    <div class="botones">
    <input type="submit" value="Buscar" class="boton" name="enviar" >
    <a href="/Inicio"><b>Regresar</a>



