<h1 class="nombre-pagina">Lista de Adeudos</h1>

<form class="formulario" method="POST" action="/modificar?id=<?php echo s($resultado->id);?>">
<div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nombre"
            value="<?php echo s($resultado->nombre); ?>"
            
        />
    </div>
    <div class="campo">
        <label for="nombre">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Apellido"
            value="<?php echo s($resultado->apellido); ?>"
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
        <label for="nombre">Abono</label>
        <input
            type="num"
            id="abono"
            name="abono"
            placeholder="Abono"
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
            value="<?php echo s($resultado->total); ?>"
        />
    </div>

    <input type="submit" value="Actualizar" class="boton">
    <a href="/deudores" ><b>Regresar</a>
</form>