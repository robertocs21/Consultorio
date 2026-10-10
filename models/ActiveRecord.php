<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Columnas que nunca se toman de un formulario (ver sincronizar)
    protected static $noAsignables = ['id'];

    // Tamaño máximo de las columnas VARCHAR de cada tabla (cada modelo define las suyas)
    const LONGITUDES = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // MySQL en modo estricto rechaza (con error fatal) un texto más largo que su columna, así que se avisa antes de guardar
    protected function validarLongitudes() {
        foreach(static::LONGITUDES as $campo => $maximo) {
            if(mb_strlen((string) $this->$campo) > $maximo) {
                self::$alertas['error'][] = 'El campo «' . ucfirst($campo) . "» admite máximo {$maximo} caracteres";
            }
        }
    }

    // Ejecuta una consulta preparada: los valores viajan separados del SQL,
    // así un texto como ' OR '1'='1 nunca se interpreta como código SQL
    protected static function ejecutar($query, $params = []) {
        $stmt = self::$db->prepare($query);
        if($params) {
            $params = array_map(fn($valor) => (string) ($valor ?? ''), $params);
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        return $stmt;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query, $params = []) {
        // Consultar la base de datos
        $stmt = self::ejecutar($query, $params);
        $resultado = $stmt->get_result();

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();
        $stmt->close();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sincroniza BD con Objetos en memoria
    // Ignora las columnas no asignables: si se aceptara un "id" enviado en el formulario,
    // guardar() actualizaría ese registro ajeno en lugar de crear uno nuevo
    public function sincronizar($args=[]) {
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value) && !in_array($key, static::$noAsignables, true)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ? LIMIT 1";
        $resultado = self::consultarSQL($query, [(int) $id]);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . (int) $limite;
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Busca un registro por el valor de una columna
    public static function where($columna, $valor) {
        // El nombre de una columna no puede ir como parámetro, por eso solo se aceptan columnas conocidas
        if(!in_array($columna, static::$columnasDB, true)) {
            throw new \InvalidArgumentException("Columna no válida: {$columna}");
        }
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = ? LIMIT 1";
        $resultado = self::consultarSQL($query, [$valor]);
        return array_shift( $resultado ) ;
    }

    // Busca pacientes por nombre o por apellido
    public static function buscar($nombre) {
        $query = "SELECT * FROM pacientes WHERE nombre LIKE ?";
        return self::consultarSQL($query, ['%' . $nombre . '%']);
    }
    public static function buscarap($apellido) {
        $query = "SELECT * FROM pacientes WHERE apellido LIKE ?";
        return self::consultarSQL($query, ['%' . $apellido . '%']);
    }

    // Adeudos de un doctor (antes con LIKE '%id%' el doctor 1 también veía los del 10, 11, 21...)
    public static function buscardoc($id) {
        $query = "SELECT * FROM deuda WHERE doctor = ?";
        return self::consultarSQL($query, [$id]);
    }

    // crea un nuevo registro
    public function crear() {
        $atributos = $this->atributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ( ";
        $query .= join(', ', array_fill(0, count($atributos), '?'));
        $query .= " ) ";

        // Resultado de la consulta
        $stmt = self::ejecutar($query, array_values($atributos));
        $resultado = $stmt->affected_rows > 0;
        $stmt->close();
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        $atributos = $this->atributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach(array_keys($atributos) as $key) {
            $valores[] = "{$key} = ?";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = ? ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $stmt = self::ejecutar($query, [...array_values($atributos), $this->id]);
        $resultado = $stmt->errno === 0;
        $stmt->close();
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = ? LIMIT 1";
        $stmt = self::ejecutar($query, [$this->id]);
        $resultado = $stmt->errno === 0;
        $stmt->close();
        return $resultado;
    }
     // Subida de archivos
     public function setImagen($imagen) {
        // Elimina la imagen previa
        if( !is_null($this->id) ) {
            $this->borrarImagen();
        }
        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Elimina el archivo
    public function borrarImagen() {
        // Comprobar si existe el archivo
        $carpetaImagenes = '../views/auth/imagenes/';
        $existeArchivo = file_exists($carpetaImagenes . $this->imagen);
        if($existeArchivo) {
            unlink($carpetaImagenes . $this->imagen);
        }
    }

}
