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
            <th><font color=black>Pago</th>
            <th><font color=black>Cobro</th>
            <th><font color=black>Total</th>
        </tr>
    </thead>
    <tbody>
        
        <tr>
            <th><font color=black>1</th>
            <th><font color=black>Roberto</th>
            <th><font color=black>Castro</th>
            <th><font color=black><input type="num" id ="pago" name="pago"></th>
            <th><font color=black><input type="num" id ="cobro" name="cobro"></th>
            <th><font color=black>1000</th>

        </tr>
    </tbody>
</table>
<input type="submit" value="Actualizar" class="boton">