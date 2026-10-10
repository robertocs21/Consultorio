<?php
    $titulo = 'Adeudos';
    $porCobrar = array_sum(array_map(fn($deuda) => (float) $deuda->total, $lista));
?>
<div class="encabezado">
    <div>
        <h1>Adeudos</h1>
        <p>Saldos pendientes de tus pacientes.</p>
    </div>
    <div class="encabezado__acciones">
        <a href="/agregar" class="boton"><?php echo icono('agregar', 18); ?> Agregar adeudo</a>
    </div>
</div>

<div class="estadisticas estadisticas--fila">
    <div class="estadistica">
        <span class="estadistica__etiqueta">Saldo total por cobrar</span>
        <strong class="estadistica__valor"><?php echo dinero($porCobrar); ?></strong>
    </div>
    <div class="estadistica">
        <span class="estadistica__etiqueta">Registros</span>
        <strong class="estadistica__valor"><?php echo count($lista); ?></strong>
    </div>
</div>

<?php if (empty($lista)): ?>
    <div class="tarjeta vacio">
        <?php echo icono('adeudos', 40); ?>
        <h2>No hay adeudos registrados</h2>
        <p>Cuando un paciente quede a deber, regístralo aquí para darle seguimiento.</p>
        <div class="vacio__acciones">
            <a href="/agregar" class="boton"><?php echo icono('agregar', 18); ?> Agregar adeudo</a>
        </div>
    </div>
<?php else: ?>
    <div class="tarjeta tarjeta--tabla">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Paciente</th>
                    <th class="tabla__numero">Saldo</th>
                    <th class="tabla__acciones"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($lista as $res): ?>
                <tr>
                    <td data-etiqueta="Folio"><span class="folio">#<?php echo s($res->id); ?></span></td>
                    <td data-etiqueta="Paciente" class="tabla__principal"><?php echo s($res->nombre . ' ' . $res->apellido); ?></td>
                    <td data-etiqueta="Saldo" class="tabla__numero">
                        <span class="saldo <?php echo (float) $res->total > 0 ? 'saldo--pendiente' : 'saldo--pagado'; ?>">
                            <?php echo dinero($res->total); ?>
                        </span>
                    </td>
                    <td class="tabla__acciones">
                        <a href="/modificar?id=<?php echo s($res->id); ?>" class="boton boton--secundario boton--chico">
                            <?php echo icono('editar', 18); ?> Cargo / abono
                        </a>
                        <form method="POST" action="/deudores" data-confirmar="¿Eliminar el adeudo de <?php echo s($res->nombre . ' ' . $res->apellido); ?>? Esta acción no se puede deshacer.">
                            <input type="hidden" name="id" value="<?php echo s($res->id); ?>">
                            <button type="submit" class="boton boton--peligro boton--chico boton--icono" title="Eliminar adeudo" aria-label="Eliminar adeudo de <?php echo s($res->nombre . ' ' . $res->apellido); ?>">
                                <?php echo icono('eliminar', 18); ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
