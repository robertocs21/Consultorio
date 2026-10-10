-- Agrega el odontograma a la ficha del paciente.
-- Guarda los trazos dibujados como JSON (no como imagen en disco: Heroku borra los archivos subidos al reiniciar).
-- Correr ANTES de desplegar el código que usa la columna.
ALTER TABLE pacientes ADD COLUMN odontograma MEDIUMTEXT NULL;
