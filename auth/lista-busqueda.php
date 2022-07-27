<style>

table.Lista{
    font color:black;
    background-color: #ccffff;
    border-radius: 1rem;
    margin-top: 4rem;
    padding: 0.5rem;
    width: 100%;
    
}
thead{
    background-color: #7AFF33;
    padding: 2rem;
    border-radius: 5rem;
    }
</style>

<?php 

?>
<h1 class="nombre-pagina">Lista de pacientes con ese nombre o folio</h1>

<table class="Lista">
    <thead>
        <tr>
            <th><font color=black>Folio</th>
            <th><font color=black>Nombre</th>
            <th><font color=black>Apellido</th>
            <th><font color=black>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($resultado as $res):?>
        <tr>
            <th><font color=black><?php echo $res->id?></th>
            <th><font color=black><?php echo $res->nombre?></th>
            <th><font color=black><?php echo $res->apellido?></th>
            <th><font color=black><a href="/busqueda-registro?id=<?php echo $res->id?>" class="boton-verde">Actualizar</a></th>

        </tr>
        <?php endforeach;  ?>
        
    </tbody>

</table>