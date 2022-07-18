
<style>
.contenedor{
    background-color: #ccffff;
    border-radius: 10rem;
    min-height: 245vh;
    padding: 0.5rem;
}
.contenedor-app{ 
    display: contents;
    
    }
 
@media (min-width:768px) {
    .formulario {
        max-width: 800px;
        margin: 0 auto;
    }
}

.campo {
    margin-bottom: 1rem;
    width: 100%;
}

.campo label {
    
    font-weight: 700;
    margin-bottom: .5rem;
    display: block;
}
.campo input[type="text"],
.campo input[type="tel"],
.campo input[type="mail"],
.campo textarea {
    width: 100%;
    padding: .5rem;
    
    border-radius: .5rem;
}
@media (min-width: 768px) {
    :is(.campo) :is( 
        input[type="text"], 
        input[type="text"],  
        input[type="tel"],  
        input[type="mail"] , 
        textarea ) {
        flex: 1;
    }
}

.w-100{
    flex: 0 0 100%;
}
.campo textarea {
    height: 30rem;
    width: 20rem;
}
.folio{
    margin-left:990px;
}
</style>
<?php 

?>

<div class="contenedor">
    <br>
<label class="folio"><font color="black"><b> Folio: <?php echo s($resultado->id); ?> </b></label>
<h1 class="nombre-pagina">Ficha del paciente</h1>
<form class="formulario" method="POST" action="/busqueda-registro?id=<?php echo s($resultado->id);?>" enctype="multipart/form-data">
<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
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
        <label for="apellido">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Apellido(s)"
            value="<?php echo s($resultado->apellido); ?>"
        />
    </div>
    <div class="campo">
        <label for="edad">Edad</label>
        <input
            type="num"
            id="edad"
            name="edad"
            placeholder="Edad del paciente"
            value="<?php echo s($resultado->edad); ?>"
        />
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Número de teléfono"
            value="<?php echo s($resultado->telefono); ?>"
        />
    </div>
    <div class="campo">
        <label for="estado">Estado cívil</label>
        <input
            type="texto"
            id="estado"
            name="estado"
            placeholder="Estado cívil"
            value="<?php echo s($resultado->estado); ?>"
        />
    </div>
    <div class="campo">
        <label for="ocupacion">Ocupación</label>
        <input
            type="text"
            id="ocupacion"
            name="ocupacion"
            placeholder="Ocupación del paciente"
            value="<?php echo s($resultado->ocupacion); ?>"
        />
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="E-mail"
            value="<?php echo s($resultado->email); ?>"
        />
    </div>
    <p></p>
    <center>
    <label><font size=4 color="black"><b>Antecedentes Familiares y personales</b></font></label>
    </center>
    <p></p>
    <div class="form">
        <style>
        .form{
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        }
        </style>
    <ul>
    <label><b><font color="black">Paciente</b></label>
        <font color="black"><b>
        <li for="diabetes" >Diabetes <input type="checkbox" name="diabetes" value="1" ></li>
        <li for="cardio" >Problemas Cardiovasculares <input type="checkbox" name="cardio" value="1"></li>
        <li for="cancer" >Cáncer <input type="checkbox" name="cancer" value="1"></li>
        <li for="epilepsia" >Ataques de epilepsia <input type="checkbox" name="epilepsia" value="1"></li>
        <li for="hipertension" >Hipertensión <input type="checkbox" name="hipertension" value="1"></li>
        <li for="asma" >Asma <input type="checkbox" name="asma" value="1"></li>
        <li for="convulsiones" >Convulsiones <input type="checkbox" name="convulsiones" value="1"></li>
        <li for="vih" >VIH/SIDA <input type="checkbox" name="vih" value="1"></li>
        <li for="bebe" >¿Usted bebe? <input type="checkbox" name="bebe" value="1"></li>
        <li for="fuma" >¿Usted fuma? <input type="checkbox" name="fuma" value="1"></li>
        <li for="embarazada" >En caso de ser mujer, ¿Está usted embarazada? <input type="checkbox" name="embarazada" value="1"></li>
        </b>   
        </font>
    </ul>
    <ul>
    <label><b><font color="black">Familiares</b></label>
        <font color="black">
        <li for="diabetesf" >
        <input
            type="text"
            id="diabetesf"
            name="diabetesf"
            placeholder="¿Quién con diabetes?"
            value="<?php echo s($resultado->diabetesf); ?>"
           
        /><label> Con Diabetes</label></li>
        <li for="cardiof" > <input
            type="text"
            id="cardiof"
            name="cardiof"
            placeholder="¿Quién con cardiovasculares?"
            value="<?php echo s($resultado->cardiof); ?>"
        /><label> Con CVD</label></li>
        <li for="cancerf" > <input
            type="text"
            id="cancerf"
            name="cancerf"
            placeholder="¿Quién con cáncer?"
            value="<?php echo s($resultado->cancerf); ?>"
        /><label> Con Cancer</label></li>
        <li for="epilepsiaf" > <input
            type="text"
            id="epilepsiaf"
            name="epilepsiaf"
            placeholder="¿Quién con epilepsias?"
            value="<?php echo s($resultado->epilepsiaf); ?>"
        /><label> Con Epilepsias</label></li>
        <li for="hipertensionf" > <input
            type="text"
            id="hipertensionf"
            name="hipertensionf"
            placeholder="¿Quién con hipertensión?"
            value="<?php echo s($resultado->hipertensionf); ?>"
        /><label> Con Hipertensión</label></li>
        <li for="asmaf" ><input
            type="text"
            id="asmaf"
            name="asmaf"
            placeholder="¿Quién con asma?"
            value="<?php echo s($resultado->asmaf); ?>"
        /><label> Con Asma</label></li>
        <li for="convulsionesf" ><input
            type="text"
            id="convulcionesf"
            name="convulsionesf"
            placeholder="¿Quién con colvulsiones?"
            value="<?php echo s($resultado->convulsionesf); ?>"
        /><label> Con Convulsiones</label></li>
        <li for="vihf" ><input
            type="text"
            id="vihf"
            name="vihf"
            placeholder="¿Quién VIH/SIDA?"
            value="<?php echo s($resultado->vihf); ?>"
        /><label> Con Diabetes</label></li>
        </font>
    </ul>
    </div>
   
    <div class="campo"> 
    <label for="accidente">Accidentes</label>  
        <input
            type="text"
            id="accidente"
            name="accidente"
            placeholder="¿Ha tenido algún accidente?"
            value="<?php echo s($resultado->accidente); ?>"
        />
    </div>
    <div class="campo">
    <label for="operacion">Operación</label>
        <input
            type="text"
            id="operacion"
            name="operacion"
            placeholder="¿Ha tenido alguna operación?"
            value="<?php echo s($resultado->operacion); ?>"
        />
    </div>
    <div class="campo">
    <label for="tratamiento">Tratamiento</label>
        <input
            type="text"
            id="tratamiento"
            name="tratamiento"
            placeholder="¿Está bajo tratamiento médico?"
            value="<?php echo s($resultado->tratamiento); ?>"
        />
    </div>
    <div class="campo">
        <label for="enfermedades">Otras</label>
        <input
            type="text"
            id="enfermedades"
            name="enfermedades"
            placeholder="Especificar enfermedad"
            value="<?php echo s($resultado->enfermedades); ?>"
        />
    </div>
    <div class="campo">
        <label for="alergias">Alergias</label>
        <input
            type="text"
            id="alergias"
            name="alergias"
            placeholder="¿Tiene alergias a algún medicamento?"
            value="<?php echo s($resultado->alergias); ?>"
        />
    </div>
    <div class="campo">
        <label for="cepillado">Cepillado</label>
        <input
            type="number"
            id="cepillado"
            name="cepillado"
            placeholder="¿Cuantas veces al día se cepilla los dientes?"
            value="<?php echo s($resultado->cepillado); ?>"
        />
    </div>
    <div class="campo">
        <label for="radio">Radio</label>
        <input
            type="number"
            id="radio"
            name="radio"
            placeholder="Número de radiografía"
            value="<?php echo s($resultado->radio); ?>"
        />
    </div>
    <div class="campo">
        <label for="visita">Última visita</label>
        <input
            type="date"
            id="visita"
            name="visita"
            value="<?php echo s($resultado->visita); ?>"
        />
    </div>
    <div class="campo">
        <label for="imagen">Odontograma</label>
        <input
            type="file"
            id="imagen"
            name="imagen"
            placeholder="Odontograma"
        />
    </div>
    <div class="campo w-100">
        <label>Anotaciones:</label>

        <textarea id="anotaciones" name ="anotaciones"><?php echo s($resultado->anotaciones); ?></textarea>
        
     </div>
     <p>Yo <?php echo ($resultado->nombre); ?> <?php echo s($resultado->apellido); ?>, después de haber sido informado(a) de mi estado de salud bucal y de conocer las posibles consecuencias de mi tratamiento, autorizo al cirujano dentista para que lleve a cabo los tratamientos odontológicos, médicos y quirúrgicos que sean necesarios para resolver mis padecimientos odontólogicos. Así mismo doy fe en que he sido informado (a) de manera clara cada uno de los conceptos aquí expuestos.</p>
     <style>
         .firma {
    width: 300px;
    height: 100px;
    background-color: white;
    border-radius: 1rem;
}
     </style>
     <div class="firma">
     <canvas id="pizarra"></canvas>
     </div>
     <p></p>
<label><b>Firma del paciente</b></label>
    <input type="submit" value="Actualizar" class="boton">
</div>
</div>


</form>
