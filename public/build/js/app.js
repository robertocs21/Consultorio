// Comportamientos de la interfaz del consultorio
document.addEventListener('DOMContentLoaded', () => {
    iniciarFirma();
    iniciarConfirmaciones();
    iniciarImpresion();
    iniciarCalculoSaldo();
    iniciarNombreConsentimiento();
    iniciarOdontograma();
    iniciarAvisoCambios();
});

// Firma del paciente sobre el <canvas> (mouse, dedo o lápiz)
function iniciarFirma() {
    const lienzo = document.querySelector('#pizarra');
    if (!lienzo) return;

    const contexto = lienzo.getContext('2d');
    let dibujando = false;

    // Ajusta la resolución del canvas a su tamaño real para que el trazo no se vea borroso
    const escala = window.devicePixelRatio || 1;
    const { width, height } = lienzo.getBoundingClientRect();
    lienzo.width = width * escala;
    lienzo.height = height * escala;
    contexto.scale(escala, escala);
    contexto.lineWidth = 2;
    contexto.lineCap = 'round';
    contexto.lineJoin = 'round';
    contexto.strokeStyle = '#102033';

    const punto = evento => {
        const rect = lienzo.getBoundingClientRect();
        return { x: evento.clientX - rect.left, y: evento.clientY - rect.top };
    };

    lienzo.addEventListener('pointerdown', evento => {
        dibujando = true;
        lienzo.setPointerCapture(evento.pointerId);
        const { x, y } = punto(evento);
        contexto.beginPath();
        contexto.moveTo(x, y);
    });

    lienzo.addEventListener('pointermove', evento => {
        if (!dibujando) return;
        const { x, y } = punto(evento);
        contexto.lineTo(x, y);
        contexto.stroke();
    });

    ['pointerup', 'pointercancel'].forEach(tipo => {
        lienzo.addEventListener(tipo, () => dibujando = false);
    });

    document.querySelector('[data-limpiar-firma]')?.addEventListener('click', () => {
        contexto.clearRect(0, 0, lienzo.width, lienzo.height);
    });
}

// Pide confirmación antes de enviar formularios destructivos (p. ej. eliminar un adeudo)
function iniciarConfirmaciones() {
    document.querySelectorAll('form[data-confirmar]').forEach(formulario => {
        formulario.addEventListener('submit', evento => {
            if (!confirm(formulario.dataset.confirmar)) {
                evento.preventDefault();
            }
        });
    });
}

function iniciarImpresion() {
    document.querySelectorAll('[data-imprimir]').forEach(boton => {
        boton.addEventListener('click', () => window.print());
    });
}

// Muestra cómo quedará el saldo antes de guardar un cargo o abono
function iniciarCalculoSaldo() {
    const saldo = document.querySelector('[data-saldo]');
    if (!saldo) return;

    const cobro = document.querySelector('#cobro');
    const abono = document.querySelector('#abono');
    const salida = document.querySelector('#saldo-nuevo');

    const actualizar = () => {
        const cargo = parseFloat(cobro.value) || 0;
        const pago = parseFloat(abono.value) || 0;
        const nuevo = parseFloat(saldo.dataset.saldo) + cargo - pago;

        salida.closest('.saldo-nuevo').hidden = !cargo && !pago;
        salida.textContent = '$' + nuevo.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    cobro.addEventListener('input', actualizar);
    abono.addEventListener('input', actualizar);
}

// Mantiene el nombre del consentimiento igual al capturado en la ficha
function iniciarNombreConsentimiento() {
    const destino = document.querySelector('[data-nombre-paciente]');
    if (!destino) return;

    const nombre = document.querySelector('#nombre');
    const apellido = document.querySelector('#apellido');

    const actualizar = () => {
        const completo = `${nombre.value} ${apellido.value}`.trim();
        destino.textContent = completo || '________________________';
    };

    nombre.addEventListener('input', actualizar);
    apellido.addEventListener('input', actualizar);
}

// Odontograma: las marcas se guardan como trazos (JSON) en coordenadas de la imagen base de 1024×787,
// así se ven igual en cualquier tamaño de pantalla y se pueden deshacer o borrar una por una
function iniciarOdontograma() {
    const contenedor = document.querySelector('[data-odontograma]');
    if (!contenedor) return;

    const ANCHO = 1024;
    const ALTO = 787;
    const GROSOR = 3;
    const RADIO_BORRADOR = 10;

    const lienzo = contenedor.querySelector('canvas');
    const campo = contenedor.querySelector('[data-odontograma-datos]');
    const botonDeshacer = contenedor.querySelector('[data-deshacer]');
    const herramientas = contenedor.querySelectorAll('.herramienta');
    const contexto = lienzo.getContext('2d');
    // El canvas mide el doble que la imagen base para que las marcas se vean nítidas (también al imprimir)
    const escala = lienzo.width / ANCHO;

    let trazos = [];
    try {
        trazos = JSON.parse(campo.value).trazos || [];
    } catch {
        trazos = [];
    }
    const historial = [];
    let color = herramientas[0].dataset.color;
    let borrando = false;
    let actual = null;

    const guardar = () => {
        campo.value = trazos.length ? JSON.stringify({ v: 1, trazos }) : '';
        botonDeshacer.disabled = historial.length === 0;
        contenedor.dispatchEvent(new Event('odontograma-cambio', { bubbles: true }));
    };

    const recordar = () => {
        historial.push(JSON.stringify(trazos));
        if (historial.length > 50) historial.shift();
    };

    const prepararPincel = colorTrazo => {
        contexto.strokeStyle = colorTrazo;
        contexto.fillStyle = colorTrazo;
        contexto.lineWidth = GROSOR * escala;
        contexto.lineCap = 'round';
        contexto.lineJoin = 'round';
    };

    const dibujarTrazo = trazo => {
        prepararPincel(trazo.c);
        const [x0, y0] = trazo.p[0];
        contexto.beginPath();
        if (trazo.p.length === 1) {
            contexto.arc(x0 * escala, y0 * escala, GROSOR / 2 * escala, 0, Math.PI * 2);
            contexto.fill();
            return;
        }
        contexto.moveTo(x0 * escala, y0 * escala);
        trazo.p.slice(1).forEach(([x, y]) => contexto.lineTo(x * escala, y * escala));
        contexto.stroke();
    };

    const redibujar = () => {
        contexto.clearRect(0, 0, lienzo.width, lienzo.height);
        trazos.forEach(dibujarTrazo);
    };

    // Posición del puntero en coordenadas de la imagen base, con un decimal
    const punto = evento => {
        const rect = lienzo.getBoundingClientRect();
        return [
            Math.round((evento.clientX - rect.left) / rect.width * ANCHO * 10) / 10,
            Math.round((evento.clientY - rect.top) / rect.height * ALTO * 10) / 10,
        ];
    };

    const distanciaASegmento = ([x, y], [x1, y1], [x2, y2]) => {
        const dx = x2 - x1;
        const dy = y2 - y1;
        const largo = dx * dx + dy * dy;
        const t = largo ? Math.max(0, Math.min(1, ((x - x1) * dx + (y - y1) * dy) / largo)) : 0;
        return Math.hypot(x - (x1 + t * dx), y - (y1 + t * dy));
    };

    // El borrador quita completa cualquier marca que toque
    const borrarCerca = p => {
        const antes = trazos.length;
        trazos = trazos.filter(trazo => !trazo.p.some((q, i) =>
            distanciaASegmento(p, i ? trazo.p[i - 1] : q, q) < RADIO_BORRADOR
        ));
        if (trazos.length !== antes) redibujar();
    };

    lienzo.addEventListener('pointerdown', evento => {
        lienzo.setPointerCapture(evento.pointerId);
        recordar();
        const p = punto(evento);
        if (borrando) {
            actual = 'borrador';
            borrarCerca(p);
            return;
        }
        actual = { c: color, p: [p] };
        trazos.push(actual);
        dibujarTrazo(actual);
    });

    lienzo.addEventListener('pointermove', evento => {
        if (!actual) return;
        const p = punto(evento);
        if (actual === 'borrador') {
            borrarCerca(p);
            return;
        }
        const [ux, uy] = actual.p[actual.p.length - 1];
        // Ignora movimientos mínimos para no guardar puntos repetidos
        if (Math.hypot(p[0] - ux, p[1] - uy) < 1.5) return;
        actual.p.push(p);
        prepararPincel(actual.c);
        contexto.beginPath();
        contexto.moveTo(ux * escala, uy * escala);
        contexto.lineTo(p[0] * escala, p[1] * escala);
        contexto.stroke();
    });

    ['pointerup', 'pointercancel'].forEach(tipo => {
        lienzo.addEventListener(tipo, () => {
            if (!actual) return;
            actual = null;
            // Un toque del borrador que no quitó nada no cuenta como cambio
            if (historial[historial.length - 1] === JSON.stringify(trazos)) {
                historial.pop();
                return;
            }
            guardar();
        });
    });

    herramientas.forEach(boton => {
        boton.addEventListener('click', () => {
            herramientas.forEach(otro => {
                otro.classList.toggle('activa', otro === boton);
                otro.setAttribute('aria-pressed', otro === boton ? 'true' : 'false');
            });
            borrando = boton.hasAttribute('data-borrador');
            if (!borrando) color = boton.dataset.color;
            lienzo.parentElement.classList.toggle('borrando', borrando);
        });
    });

    botonDeshacer.addEventListener('click', () => {
        if (!historial.length) return;
        trazos = JSON.parse(historial.pop());
        redibujar();
        guardar();
    });

    contenedor.querySelector('[data-borrar-todo]').addEventListener('click', () => {
        if (!trazos.length || !confirm('¿Borrar todas las marcas del odontograma?')) return;
        recordar();
        trazos = [];
        redibujar();
        guardar();
    });

    redibujar();
}

// Avisa antes de salir de la ficha si hay cambios sin guardar (incluido lo dibujado en el odontograma)
function iniciarAvisoCambios() {
    const ficha = document.querySelector('form.ficha');
    if (!ficha) return;

    let hayCambios = false;
    ficha.addEventListener('input', () => hayCambios = true);
    ficha.addEventListener('odontograma-cambio', () => hayCambios = true);
    ficha.addEventListener('submit', () => hayCambios = false);

    window.addEventListener('beforeunload', evento => {
        if (!hayCambios) return;
        evento.preventDefault();
        evento.returnValue = '';
    });
}
