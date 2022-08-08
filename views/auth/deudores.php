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
input{
        flex: 1;
        padding: 0.5rem;
        border-radius: 1rem;
        color:v.$negro;
        width: 50%;
    }
</style>

<?php 

?>
<h1 class="nombre-pagina">Lista de Adeudos</h1>


<table class="Lista">
    <thead>
        <tr>
            <th><font color=black>Folio</th>
            <th><font color=black>Nombre</th>
            <th><font color=black>Apellido</th>
            <th><font color=black>Total</th>
            <th><font color=black>Modificar Adeudo</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($lista as $res):?>
        <tr>
            <th><font color=black><?php echo $res->id?></th>
            <th><font color=black><?php echo $res->nombre?></th>
            <th><font color=black><?php echo $res->apellido?></th>
            <th><font color=black><?php echo $res->total; ?></th>
            <th><font color=black>
            <a href="/modificar?id=<?php echo $res->id?>" class="boton-verde">Modificar</a>
            <form method = "POST" >
                <input type="hidden" name="id" value="<?php echo $res->id?>" >
                <input type="submit" value="         Eliminar        " class="boton-rojo">
            </form>
            </th>

        </tr>
        <?php endforeach;  ?>
    </tbody>
</table>
<a href="/agregar" class="boton"><b>Agrega un adeudo</a>
<a href="/Inicio" ><b>Regresar</a>