<?php
    foreach ($alertas as $key => $mensajes):
        foreach($mensajes as $mensaje):
?>
    <div class="alerta alerta--<?php echo s($key); ?>" role="<?php echo $key === 'error' ? 'alert' : 'status'; ?>">
        <?php echo icono($key === 'error' ? 'error' : 'exito'); ?>
        <span><?php echo s($mensaje); ?></span>
    </div>
<?php
        endforeach;
    endforeach;
?>
