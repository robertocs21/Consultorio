<?php
    $titulo = 'Resultados de búsqueda';
?>
<div class="encabezado">
    <div>
        <h1>Resultados de búsqueda</h1>
        <p>
            <?php if ($termino !== ''): ?>
                <?php echo count($resultado); ?> paciente(s) coinciden con «<?php echo s($termino); ?>».
            <?php else: ?>
                Mostrando todos los pacientes registrados (<?php echo count($resultado); ?>).
            <?php endif; ?>
        </p>
    </div>
    <div class="encabezado__acciones">
        <a href="/busqueda" class="boton boton--secundario"><?php echo icono('buscar', 18); ?> Nueva búsqueda</a>
    </div>
</div>

<?php if (empty($resultado)): ?>
    <div class="tarjeta vacio">
        <?php echo icono('pacientes', 40); ?>
        <h2>No encontramos pacientes</h2>
        <p>Revisa la ortografía o intenta solo con el apellido.</p>
        <div class="vacio__acciones">
            <a href="/busqueda" class="boton boton--secundario">Buscar de nuevo</a>
            <a href="/crear-paciente" class="boton"><?php echo icono('paciente-nuevo', 18); ?> Registrar paciente</a>
        </div>
    </div>
<?php else: ?>
    <div class="tarjeta tarjeta--tabla">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th class="tabla__acciones"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultado as $res): ?>
                <tr>
                    <td data-etiqueta="Folio"><span class="folio">#<?php echo s($res->id); ?></span></td>
                    <td data-etiqueta="Nombre" class="tabla__principal"><?php echo s($res->nombre . ' ' . $res->apellido); ?></td>
                    <td data-etiqueta="Teléfono"><?php echo s($res->telefono ?? '') ?: '—'; ?></td>
                    <td class="tabla__acciones">
                        <a href="/busqueda-registro?id=<?php echo s($res->id); ?>" class="boton boton--secundario boton--chico">
                            <?php echo icono('expediente', 18); ?> Ver ficha
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
