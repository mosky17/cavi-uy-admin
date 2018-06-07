<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

require_once(dirname(__FILE__) . '/auth.php');
require_once(dirname(__FILE__) . '/log.php');

Auth::connect();

class Socio
{
    public $id;
    public $numero;
    public $nombre;
    public $documento;
    public $email;
    public $fecha_inicio;
    public $fecha_nacimiento;
    public $tags;
    public $telefono;
    public $observaciones;
    public $activo;
    public $hash;
    public $direccion;
    public $balance_efectivo;


    function __construct($_id,
                         $_numero,
                         $_nombre,
                         $_documento,
                         $_email,
                         $_fecha_inicio,
                         $_fecha_nacimiento,
                         $_tags,
                         $_telefono,
                         $_observaciones,
                         $_activo,
                         $_hash,
                         $_direccion,
                         $_balance_efectivo
    )
    {
        $this->id = $_id;
        $this->numero = $_numero;
        $this->nombre = $_nombre;
        $this->documento = $_documento;
        $this->email = $_email;
        $this->fecha_inicio = $_fecha_inicio;
        $this->fecha_nacimiento = $_fecha_nacimiento;
        $this->tags = $_tags;
        $this->telefono = $_telefono;
        $this->observaciones = $_observaciones;
        $this->activo = $_activo;
        $this->hash = $_hash;
        $this->direccion = $_direccion;
        $this->balance_efectivo = $_balance_efectivo;
    }

    static private function mysql_to_instances($result)
    {
        $return = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $tags = explode(",", $row['tags']);

                $instance = new Socio(
                    $row['id'],
                    $row['numero'],
                    $row['nombre'],
                    $row['documento'],
                    $row['email'],
                    $row['fecha_inicio'],
                    $row['fecha_nacimiento'],
                    $tags,
                    $row['telefono'],
                    $row['observaciones'],
                    $row['activo'],
                    $row['hash'],
                    $row['direccion'],
                    $row['balance_efectivo']
                );

                $return[] = $instance;
            }
        }
        return $return;
    }

    static public function get_lista_socios()
    {
        $q=Auth::$mysqli->query("SELECT * FROM socios ORDER BY numero;");
        return Socio::mysql_to_instances($q);
    }

    static public function get_socios_activos()
    {
        $q=Auth::$mysqli->query("SELECT * FROM socios WHERE activo=1 ORDER BY numero;");
        return Socio::mysql_to_instances($q);
    }

    static public function get_socios_suspendidos()
    {
        $q=Auth::$mysqli->query("SELECT * FROM socios WHERE activo=0 ORDER BY numero;");
        return Socio::mysql_to_instances($q);
    }

    static public function get_socio($id)
    {
        $q=Auth::$mysqli->query("SELECT * FROM socios WHERE id = " . $id . ";");
        $result = Socio::mysql_to_instances($q);
        if (count($result) == 1) {
            return $result[0];
        } else {
            return array("error" => "Socio no encontrado");
        }
    }

    static public function get_socio_hash($hash)
    {
        $q=Auth::$mysqli->query("SELECT * FROM socios WHERE hash = '" . $hash . "';");
        $result = Socio::mysql_to_instances($q);
        if (count($result) == 1) {
            return $result[0];
        } else {
            return array("error" => "Socio no encontrado");
        }
    }

    static public function get_tags()
    {
        $q=Auth::$mysqli->query("SELECT * FROM tags ORDER BY id;");
        $return = array();
        while ($row = mysqli_fetch_array($q)) {
            $return[] = array("id" => $row['id'], "nombre" => $row['nombre'], "color" => $row['color']);
        }
        return $return;
    }

    static public function create_socio(
        $numero,
        $nombre,
        $documento,
        $email,
        $fecha_inicio,
        $tags,
        $telefono,
        $observaciones,
        $fecha_nacimiento,
        $direccion
    )
    {

        //check number
        $q=Auth::$mysqli->query("SELECT * FROM socios WHERE numero=" . $numero);
        $sociosIgualNumero = Socio::mysql_to_instances($q);
        if ($sociosIgualNumero && count($sociosIgualNumero) > 0) {
            return array("error" => "Numero de socio ya existente");
        }

        $tagString = "";
        for ($i = 0; $i < count($tags); $i++) {
            $tagString .= $tags[$i] . ",";
        }
        $tagString = rtrim($tagString, ",");

        $q=Auth::$mysqli->query("INSERT INTO socios (id, numero, nombre, documento, email, fecha_inicio, tags, telefono, observaciones, fecha_nacimiento, direccion) VALUES (" .
            "null, " .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$numero)) . ", '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$nombre)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$documento)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$email)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_inicio)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$tagString)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$telefono)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$observaciones)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_nacimiento)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$direccion)) .
            "');");

        if (Auth::$mysqli->affected_rows == 1) {
            return Auth::$mysqli->insert_id;
        } else {
            return array("error" => "Error al crear socio");
        }
    }

    static public function update_socio($id, 
                                        $numero, 
                                        $nombre, 
                                        $documento, 
                                        $email, 
                                        $fecha_inicio, 
                                        $tags, 
                                        $telefono, 
                                        $observaciones, 
                                        $fecha_nacimiento,
                                        $direccion
    ){

        //check number
        $q=Auth::$mysqli->query("SELECT * FROM socios WHERE numero=" . $numero);
        $sociosIgualNumero = Socio::mysql_to_instances($q);
        if (count($sociosIgualNumero) > 1 || (count($sociosIgualNumero) == 1 && $sociosIgualNumero[0]->id != $id)) {
            return array("error" => "Numero de socio ya existente");
        }

        $tagString = "";
        for ($i = 0; $i < count($tags); $i++) {
            $tagString .= $tags[$i] . ",";
        }
        $tagString = rtrim($tagString, ",");

        $q=Auth::$mysqli->query("UPDATE socios SET numero=" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$numero)) .
            ", nombre='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$nombre)) .
            "', documento='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$documento)) .
            "', email='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$email)) .
            "', fecha_inicio='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_inicio)) .
            "', tags='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$tagString)) .
            "', telefono='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$telefono)) .
            "', fecha_nacimiento='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_nacimiento)) .
            "', direccion='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$direccion)) .
            "', observaciones='" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$observaciones)) . "' WHERE id=" . $id);

        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            Log::log("Editar Socio", "Socio #" . $id . " " . $nombre . " editado");
            return $id;
        } else {
            return array("error" => "Error al editar socio");
        }
    }

    static public function update_estado_socio($id, $estado)
    {
        $q=Auth::$mysqli->query("UPDATE socios SET activo=" . $estado . " WHERE id=" . $id);

        if (Auth::$mysqli->affected_rows == 1) {
            return true;
        } else {
            return array("error" => "Socio no actualizado");
        }
    }

    static public function eliminar_socio($id)
    {
        //check si no tiene pagos
        $q=Auth::$mysqli->query("SELECT * FROM pagos WHERE id_socio=" . $id . " AND cancelado=0");
        if ($q->num_rows > 0) {
            return array("error" => "Imposible eliminar, socio tiene pagos a su nombre");
        } else {
            $q=Auth::$mysqli->query("DELETE FROM socios WHERE id=" . $id);
        }

        if (Auth::$mysqli->affected_rows == 1) {
            return true;
        } else {
            return array("error" => "Socio no eliminado");
        }
    }

    static public function get_lista_mails($all, $tags)
    {
        if ($all == 'true') {
            $q=Auth::$mysqli->query("SELECT * FROM socios WHERE activo=1");
        } else {

            $and = "";
            if ($tags && count($tags) > 0) {
                $and .= " AND (";
                for ($i = 0; $i < count($tags); $i++) {
                    if ($i > 0) {
                        $and .= " OR ";
                    }
                    $and .= "tags like '" . $tags[$i] . ",%'";
                    $and .= " OR tags like '%," . $tags[$i] . ",%'";
                    $and .= " OR tags like '%," . $tags[$i] . "'";
                    $and .= " OR tags = '" . $tags[$i] . "'";
                }
                $and .= ")";
            }
            $q=Auth::$mysqli->query("SELECT * FROM socios WHERE activo=1" . $and);
        }

        //echo "SELECT * FROM socios WHERE cancelado=0" . $and;
        return Socio::mysql_to_instances($q);
    }

    public function generate_hash()
    {

        $q=Auth::$mysqli->query("UPDATE socios SET hash=CONCAT(MD5('" . $this->id . $this->numero . $this->documento . $this->telefono . "secreto'), UNIX_TIMESTAMP()) WHERE id=" . $this->id);

        if (Auth::$mysqli->affected_rows == 1) {
            $socioAgain = Socio::get_socio($this->id);
            return $socioAgain->hash;
        } else {
            return array("error" => "Error al generar hash.");
        }
    }

    public function has_tag($tag_id)
    {

        for ($i = 0; $i < count($this->tags); $i++) {

            if ((int)$this->tags[$i] == (int)$tag_id) {
                return true;
            }
        }

        return false;
    }
}
