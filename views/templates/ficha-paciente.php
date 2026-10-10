<?php
    // Ficha clínica compartida por crear-registro y busqueda-registro
    // Requiere: $paciente, $accion (URL a donde se envía) y $textoBoton

    $personales = [
        'diabetes' => 'Diabetes',
        'cardio' => 'Problemas cardiovasculares',
        'cancer' => 'Cáncer',
        'epilepsia' => 'Ataques de epilepsia',
        'hipertension' => 'Hipertensión',
        'asma' => 'Asma',
        'convulsiones' => 'Convulsiones',
        'vih' => 'VIH/SIDA',
        'sistema' => 'Sistema nervioso',
        'fiebre' => 'Fiebre reumática',
        'tubercolosis' => 'Tuberculosis',
    ];

    $familiares = [
        'diabetesf' => 'Diabetes',
        'cardiof' => 'Cardiovasculares',
        'cancerf' => 'Cáncer',
        'epilepsiaf' => 'Epilepsia',
        'hipertensionf' => 'Hipertensión',
        'asmaf' => 'Asma',
        'convulsionesf' => 'Convulsiones',
        'vihf' => 'VIH/SIDA',
    ];

    $habitos = [
        'bebe' => '¿Consume bebidas alcohólicas?',
        'fuma' => '¿Fuma?',
        'embarazo' => '¿Está embarazada? (si aplica)',
    ];

    $nombreCompleto = trim($paciente->nombre . ' ' . $paciente->apellido);

    // Límites de las columnas en la base de datos
    $max = Model\Pacientes::LONGITUDES;
?>
<form class="ficha" method="POST" action="<?php echo s($accion); ?>">

    <div class="membrete">
        <img src="/build/img/logo-completo.png" alt="Martín Peraza · Servicios Dentales" width="180">
        <div>
            <strong>Ficha clínica</strong>
            <?php if (isset($paciente->id)): ?>
                <span>Folio #<?php echo s($paciente->id); ?></span>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once __DIR__ . "/alertas.php"; ?>

    <section class="tarjeta seccion">
        <h2 class="seccion__titulo"><span class="seccion__numero">1</span> Datos generales</h2>
        <div class="grid-campos grid-campos--3">
            <div class="campo">
                <label for="nombre">Nombre <span class="obligatorio" title="Obligatorio">*</span></label>
                <input type="text" id="nombre" name="nombre" maxlength="<?php echo $max['nombre']; ?>" placeholder="Nombre(s)" value="<?php echo s($paciente->nombre); ?>" autocomplete="off" required>
            </div>
            <div class="campo">
                <label for="apellido">Apellido <span class="obligatorio" title="Obligatorio">*</span></label>
                <input type="text" id="apellido" name="apellido" maxlength="<?php echo $max['apellido']; ?>" placeholder="Apellido(s)" value="<?php echo s($paciente->apellido); ?>" autocomplete="off" required>
            </div>
            <div class="campo">
                <label for="telefono">Teléfono <span class="obligatorio" title="Obligatorio">*</span></label>
                <input type="tel" id="telefono" name="telefono" placeholder="10 dígitos" inputmode="tel" value="<?php echo s($paciente->telefono); ?>" required>
            </div>
            <div class="campo">
                <label for="edad">Edad</label>
                <input type="number" id="edad" name="edad" placeholder="Años" min="0" max="120" value="<?php echo s($paciente->edad); ?>">
            </div>
            <div class="campo">
                <label for="estado">Estado civil</label>
                <input type="text" id="estado" name="estado" maxlength="<?php echo $max['estado']; ?>" list="estados-civiles" placeholder="Estado civil" value="<?php echo s($paciente->estado); ?>">
                <datalist id="estados-civiles">
                    <option value="Soltero(a)">
                    <option value="Casado(a)">
                    <option value="Unión libre">
                    <option value="Divorciado(a)">
                    <option value="Viudo(a)">
                </datalist>
            </div>
            <div class="campo">
                <label for="ocupacion">Ocupación</label>
                <input type="text" id="ocupacion" name="ocupacion" maxlength="<?php echo $max['ocupacion']; ?>" placeholder="Ocupación" value="<?php echo s($paciente->ocupacion); ?>">
            </div>
            <div class="campo campo--doble">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" maxlength="<?php echo $max['email']; ?>" placeholder="correo@ejemplo.com" value="<?php echo s($paciente->email); ?>">
            </div>
        </div>
    </section>

    <section class="tarjeta seccion">
        <h2 class="seccion__titulo"><span class="seccion__numero">2</span> Antecedentes personales</h2>
        <p class="seccion__ayuda">Escribe «No» o los detalles de cada padecimiento.</p>
        <datalist id="si-no">
            <option value="No">
            <option value="Sí">
        </datalist>
        <div class="grid-campos grid-campos--3">
            <?php foreach ($personales as $campo => $etiqueta): ?>
                <div class="campo">
                    <label for="<?php echo $campo; ?>"><?php echo $etiqueta; ?></label>
                    <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>" maxlength="<?php echo $max[$campo]; ?>" list="si-no" value="<?php echo s($paciente->$campo); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="tarjeta seccion">
        <h2 class="seccion__titulo"><span class="seccion__numero">3</span> Antecedentes familiares</h2>
        <p class="seccion__ayuda">¿Quién de su familia lo padece? Ej. padre, abuela materna.</p>
        <div class="grid-campos grid-campos--4">
            <?php foreach ($familiares as $campo => $etiqueta): ?>
                <div class="campo">
                    <label for="<?php echo $campo; ?>"><?php echo $etiqueta; ?></label>
                    <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>" maxlength="<?php echo $max[$campo]; ?>" placeholder="¿Quién?" value="<?php echo s($paciente->$campo); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="tarjeta seccion">
        <h2 class="seccion__titulo"><span class="seccion__numero">4</span> Hábitos</h2>
        <div class="grid-campos grid-campos--3">
            <?php foreach ($habitos as $campo => $etiqueta): ?>
                <div class="campo">
                    <label for="<?php echo $campo; ?>"><?php echo $etiqueta; ?></label>
                    <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>" maxlength="<?php echo $max[$campo]; ?>" list="si-no" value="<?php echo s($paciente->$campo); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="tarjeta seccion">
        <h2 class="seccion__titulo"><span class="seccion__numero">5</span> Historia clínica</h2>
        <div class="grid-campos grid-campos--2">
            <div class="campo campo--alerta">
                <label for="alergias">Alergias a medicamentos</label>
                <input type="text" id="alergias" name="alergias" maxlength="<?php echo $max['alergias']; ?>" placeholder="¿Tiene alergia a algún medicamento?" value="<?php echo s($paciente->alergias); ?>">
            </div>
            <div class="campo">
                <label for="tratamiento">Tratamiento médico actual</label>
                <input type="text" id="tratamiento" name="tratamiento" maxlength="<?php echo $max['tratamiento']; ?>" placeholder="¿Está bajo tratamiento médico?" value="<?php echo s($paciente->tratamiento); ?>">
            </div>
            <div class="campo">
                <label for="accidente">Accidentes</label>
                <input type="text" id="accidente" name="accidente" maxlength="<?php echo $max['accidente']; ?>" placeholder="¿Ha tenido algún accidente?" value="<?php echo s($paciente->accidente); ?>">
            </div>
            <div class="campo">
                <label for="operacion">Cirugías</label>
                <input type="text" id="operacion" name="operacion" maxlength="<?php echo $max['operacion']; ?>" placeholder="¿Ha tenido alguna cirugía?" value="<?php echo s($paciente->operacion); ?>">
            </div>
            <div class="campo campo--doble">
                <label for="enfermedades">Otras enfermedades</label>
                <input type="text" id="enfermedades" name="enfermedades" maxlength="<?php echo $max['enfermedades']; ?>" placeholder="Especificar enfermedad" value="<?php echo s($paciente->enfermedades); ?>">
            </div>
        </div>
        <div class="grid-campos grid-campos--3">
            <div class="campo">
                <label for="cepillado">Cepillados al día</label>
                <input type="number" id="cepillado" name="cepillado" placeholder="Ej. 3" min="0" value="<?php echo s($paciente->cepillado); ?>">
            </div>
            <div class="campo">
                <label for="radio">N.º de radiografía</label>
                <input type="number" id="radio" name="radio" placeholder="Número" min="0" max="9999999999" value="<?php echo s($paciente->radio); ?>">
            </div>
            <div class="campo">
                <label for="visita">Última visita</label>
                <input type="date" id="visita" name="visita" value="<?php echo s($paciente->visita); ?>">
            </div>
        </div>
    </section>

    <section class="tarjeta seccion seccion--odontograma">
        <h2 class="seccion__titulo"><span class="seccion__numero">6</span> Odontograma</h2>
        <p class="seccion__ayuda">Marca directamente sobre los dientes. Los cambios se guardan junto con la ficha.</p>
        <div class="odontograma" data-odontograma>
            <div class="odontograma__herramientas no-imprimir">
                <div class="odontograma__grupo" role="group" aria-label="Herramienta">
                    <button type="button" class="herramienta activa" data-color="#d0342c" aria-pressed="true">
                        <span class="herramienta__muestra" style="background:#d0342c"></span> Por tratar
                    </button>
                    <button type="button" class="herramienta" data-color="#1a5fa8" aria-pressed="false">
                        <span class="herramienta__muestra" style="background:#1a5fa8"></span> Realizado
                    </button>
                    <button type="button" class="herramienta" data-color="#102033" aria-pressed="false">
                        <span class="herramienta__muestra" style="background:#102033"></span> Ausente / otro
                    </button>
                    <button type="button" class="herramienta" data-borrador aria-pressed="false">
                        <?php echo icono('borrar', 16); ?> Borrador
                    </button>
                </div>
                <div class="odontograma__grupo">
                    <button type="button" class="boton boton--fantasma boton--chico" data-deshacer disabled><?php echo icono('regresar', 16); ?> Deshacer</button>
                    <button type="button" class="boton boton--fantasma boton--chico" data-borrar-todo><?php echo icono('eliminar', 16); ?> Borrar todo</button>
                </div>
            </div>
            <div class="odontograma__lienzo">
                <img src="/build/img/odontograma.webp" alt="Odontograma de dentición permanente, piezas 11 a 48" width="1024" height="787">
                <canvas width="2048" height="1574" aria-label="Área para marcar el odontograma"></canvas>
            </div>
            <ul class="odontograma__leyenda">
                <li><span style="background:#d0342c"></span> Caries / por tratar</li>
                <li><span style="background:#1a5fa8"></span> Tratamiento realizado</li>
                <li><span style="background:#102033"></span> Ausente / otro</li>
            </ul>
            <input type="hidden" name="odontograma" value="<?php echo s($paciente->odontograma); ?>" data-odontograma-datos>
        </div>
    </section>

    <section class="tarjeta seccion">
        <h2 class="seccion__titulo"><span class="seccion__numero">7</span> Anotaciones</h2>
        <div class="campo">
            <label for="anotaciones" class="sr-only">Anotaciones</label>
            <textarea id="anotaciones" name="anotaciones" rows="8" maxlength="<?php echo $max['anotaciones']; ?>" placeholder="Diagnóstico, plan de tratamiento, observaciones…"><?php echo s($paciente->anotaciones); ?></textarea>
        </div>
    </section>

    <section class="tarjeta seccion">
        <h2 class="seccion__titulo"><span class="seccion__numero">8</span> Consentimiento informado</h2>
        <p class="consentimiento">
            Yo <strong data-nombre-paciente><?php echo $nombreCompleto !== '' ? s($nombreCompleto) : '________________________'; ?></strong>,
            después de haber sido informado(a) de mi estado de salud bucal y de conocer las posibles consecuencias de mi tratamiento,
            autorizo al cirujano dentista para que lleve a cabo los tratamientos odontológicos, médicos y quirúrgicos que sean necesarios
            para resolver mis padecimientos odontológicos. Asimismo, doy fe de que he sido informado(a) de manera clara de cada uno de los
            conceptos aquí expuestos.
        </p>
        <div class="firma">
            <canvas id="pizarra" class="firma__lienzo" aria-label="Área para la firma del paciente"></canvas>
            <div class="firma__pie">
                <span>Firma del paciente</span>
                <button type="button" class="boton boton--fantasma boton--chico" data-limpiar-firma><?php echo icono('borrar', 16); ?> Limpiar</button>
            </div>
        </div>
        <p class="seccion__ayuda no-imprimir">La firma no se guarda en el sistema: imprime la ficha después de que el paciente firme.</p>
    </section>

    <div class="barra-acciones">
        <a href="<?php echo isset($paciente->id) ? '/busqueda' : '/Inicio'; ?>" class="boton boton--secundario" aria-label="Regresar"><?php echo icono('regresar', 18); ?> <span class="ocultar-celular">Regresar</span></a>
        <div class="barra-acciones__derecha">
            <?php if (isset($paciente->id)): ?>
                <button type="button" class="boton boton--secundario" data-imprimir aria-label="Imprimir"><?php echo icono('imprimir', 18); ?> <span class="ocultar-celular">Imprimir</span></button>
            <?php endif; ?>
            <button type="submit" class="boton"><?php echo icono('guardar', 18); ?> <?php echo s($textoBoton); ?></button>
        </div>
    </div>
</form>
