<?php
    $titulo = 'Cargo o abono';
?>
<div class="encabezado">
    <div>
        <a href="/deudores" class="enlace-regreso"><?php echo icono('regresar', 16); ?> Adeudos</a>
        <h1><?php echo s($resultado->nombre . ' ' . $resultado->apellido); ?></h1>
        <p>Registra un nuevo cargo o un abono a su cuenta.</p>
    </div>
</div>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="tarjeta formulario formulario--angosto" method="POST" action="/modificar?id=<?php echo s($resultado->id); ?>">
    <div class="saldo-actual" data-saldo="<?php echo s((float) $resultado->total); ?>">
        <span>Saldo actual</span>
        <strong><?php echo dinero($resultado->total); ?></strong>
    </div>

    <div class="grid-campos grid-campos--2">
        <div class="campo">
            <label for="cobro">Nuevo cargo</label>
            <div class="campo__moneda">
                <input
                    type="number"
                    id="cobro"
                    name="cobro"
                    placeholder="0.00"
                    min="0"
                    step="0.01"
                    inputmode="decimal"
                />
            </div>
            <small class="campo__ayuda">Se suma al saldo.</small>
        </div>
        <div class="campo">
            <label for="abono">Abono</label>
            <div class="campo__moneda">
                <input
                    type="number"
                    id="abono"
                    name="abono"
                    placeholder="0.00"
                    min="0"
                    step="0.01"
                    inputmode="decimal"
                />
            </div>
            <small class="campo__ayuda">Se resta del saldo.</small>
        </div>
    </div>

    <p class="saldo-nuevo" hidden>Nuevo saldo: <strong id="saldo-nuevo"></strong></p>

    <details class="detalles">
        <summary>Corregir nombre del paciente</summary>
        <div class="grid-campos grid-campos--2">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    maxlength="<?php echo Model\Deudores::LONGITUDES['nombre']; ?>"
                    value="<?php echo s($resultado->nombre); ?>"
                />
            </div>
            <div class="campo">
                <label for="apellido">Apellido</label>
                <input
                    type="text"
                    id="apellido"
                    name="apellido"
                    maxlength="<?php echo Model\Deudores::LONGITUDES['apellido']; ?>"
                    value="<?php echo s($resultado->apellido); ?>"
                />
            </div>
        </div>
    </details>

    <div class="formulario__acciones">
        <a href="/deudores" class="boton boton--secundario">Regresar</a>
        <button type="submit" class="boton"><?php echo icono('guardar', 18); ?> Guardar movimiento</button>
    </div>
</form>
