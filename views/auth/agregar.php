<?php
    $titulo = 'Agregar adeudo';
?>
<div class="encabezado">
    <div>
        <a href="/deudores" class="enlace-regreso"><?php echo icono('regresar', 16); ?> Adeudos</a>
        <h1>Agregar adeudo</h1>
        <p>Registra a un paciente con un saldo pendiente.</p>
    </div>
</div>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="tarjeta formulario formulario--angosto" method="POST" action="/agregar">
    <div class="grid-campos grid-campos--2">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="<?php echo Model\Deudores::LONGITUDES['nombre']; ?>"
                placeholder="Nombre"
                value="<?php echo s($paciente->nombre); ?>"
                required
            />
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input
                type="text"
                id="apellido"
                name="apellido"
                maxlength="<?php echo Model\Deudores::LONGITUDES['apellido']; ?>"
                placeholder="Apellido(s)"
                value="<?php echo s($paciente->apellido); ?>"
                required
            />
        </div>
    </div>
    <div class="campo">
        <label for="cobro">Monto del adeudo</label>
        <div class="campo__moneda">
            <input
                type="number"
                id="cobro"
                name="cobro"
                placeholder="0.00"
                min="0"
                step="0.01"
                inputmode="decimal"
                required
            />
        </div>
    </div>

    <div class="formulario__acciones">
        <a href="/deudores" class="boton boton--secundario">Cancelar</a>
        <button type="submit" class="boton"><?php echo icono('guardar', 18); ?> Guardar adeudo</button>
    </div>
</form>
