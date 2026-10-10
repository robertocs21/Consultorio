<?php
    $titulo = 'Buscar paciente';
?>
<div class="encabezado">
    <div>
        <h1>Buscar paciente</h1>
        <p>Escribe el nombre o el apellido. Si conoces el folio, te llevamos directo a su ficha.</p>
    </div>
</div>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="tarjeta formulario formulario--angosto" method="POST" action="/busqueda">
    <div class="grid-campos grid-campos--2">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                placeholder="Nombre del paciente"
                name="nombre"
                value="<?php echo s($busqueda->nombre); ?>"
                autofocus
            />
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input
                type="text"
                id="apellido"
                placeholder="Apellido(s) del paciente"
                name="apellido"
                value="<?php echo s($busqueda->apellido); ?>"
            />
        </div>
    </div>
    <div class="separador"><span>o</span></div>
    <div class="campo">
        <label for="folio">Número de folio</label>
        <input
            type="number"
            id="folio"
            placeholder="Ej. 125"
            name="folio"
            min="1"
            inputmode="numeric"
        />
    </div>
    <div class="formulario__acciones">
        <a href="/Inicio" class="boton boton--secundario"><?php echo icono('regresar', 18); ?> Regresar</a>
        <button type="submit" class="boton"><?php echo icono('buscar', 18); ?> Buscar</button>
    </div>
</form>
