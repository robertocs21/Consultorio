<h1 class="nombre-pagina">Lista de Adeudos</h1>

<form class="formulario" method="POST" action="/agregar">
<div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nombre"
            value="<?php echo s($paciente->nombre); ?>"
        />
    </div>
    <div class="campo">
        <label for="nombre">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Apellido"
            value="<?php echo s($paciente->apellido); ?>"
        />
    </div>
    <div class="campo">
        <label for="nombre">Cobro</label>
        <input
            type="num"
            id="cobro"
            name="cobro"
            placeholder="Cobro"
            value=""
        />
    </div>
    
    <div class="campo">
        <label for="nombre">Total</label>
        <input
            readonly
            type="num"
            id="total"
            name="total"
            placeholder="total"
            value="<?php echo s($paciente->total); ?>"
        />
    </div>

    <input type="submit" value="Agregar" class="boton">
    <a href="/deudores" ><b>Regresar</a>
</form>