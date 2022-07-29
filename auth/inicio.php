<style>
.contenedor-app{ 
    display:contents;
        }
.contenedor{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
        }
.margen{
    background-color: #ccffff;
    border-radius: 5rem;
    margin-top: 8rem;
    padding: 0.5rem;
}
.botones{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}
    
</style>

<?php 
$nombre = $_SESSION['nombre'];
?>
<form class="margen" action="/" method="POST">
<h1 class="nombre-pagina">Bienvenido <?php echo($nombre) ?>, ¿Qué quieres hacer hoy?</h1>
<div class="contenedor">
<div class="opciones">
    <h3>¿Quieres registrar a un paciente?</h3>
    <div class="icono"><center>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-list" width="100" height="100" viewBox="0 0 24 24" stroke-width="1" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
  <rect x="9" y="3" width="6" height="4" rx="2" />
  <line x1="9" y1="12" x2="9.01" y2="12" />
  <line x1="13" y1="12" x2="15" y2="12" />
  <line x1="9" y1="16" x2="9.01" y2="16" />
  <line x1="13" y1="16" x2="15" y2="16" />
</svg>
    </div>
    <a href="/crear-paciente"><b><center>Registra a un paciente</b></a>
</div>
<div class="opcion2">
<h3>¿Quieres buscar a un paciente anterior?</h3>
<div class="icono"><center>
  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-search" width="100" height="100" viewBox="0 0 24 24" stroke-width="1" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <circle cx="15" cy="15" r="4" />
  <path d="M18.5 18.5l2.5 2.5" />
  <path d="M4 6h16" />
  <path d="M4 12h4" />
  <path d="M4 18h4" />
</svg>
</div>
<a href="/busqueda"><b><center>Busca el historial de un paciente</b></a>
</div>
<div class="opcion3">
<h3>¿Quieres ver la lista de adeudos?</h3>
<div class="icono"><center>
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report-money" width="100" height="100" viewBox="0 0 24 24" stroke-width="1" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
  <rect x="9" y="3" width="6" height="4" rx="2" />
  <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
  <path d="M12 17v1m0 -8v1" />
</svg>
</div>
<a href="/deudores"><b><center>Ve la lista de adeudos</b></a>
</div>
</div>
<div class="botones">

<center>
<input type="submit" value="Cerrar sesión" class="boton">

<div>
</div>
</div>
</div>