<?php
/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

class Log {

    public $created_at;
    public $id;
    public $id_admin;
    public $tag;
    public $mensaje;

    function __construct($id, $id_admin, $created_at, $tag, $mensaje)
    {

        $this->id = $id;
        $this->id_admin = $id_admin;
        $this->created_at = $created_at;
        $this->tag = $tag;
        $this->mensaje = $mensaje;
    }

    static private function mysql_to_instances($result)
    {
        $return = array();
        if($result){
            while ($row = mysqli_fetch_array($result)) {
                $instance = new Log($row['id'], $row['id_admin'], $row['created_at'], $row['tag'], $row['mensaje']);
                $return[] = $instance;
            }
        }
        return $return;
    }

    static public function get_lista_logs()
    {
        $q=Auth::$mysqli->query("SELECT * FROM logs ORDER BY created_at;");
        return Log::mysql_to_instances($q);
    }

    static public function log($tag, $mensaje)
    {


        $q=Auth::$mysqli->query("INSERT INTO logs (id_admin, tag, created_at, mensaje) VALUES (" .
        Auth::get_admin_id() . ", '" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$tag)) . "', '" .
        date('Y-m-d H:i:s') . "', '" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$mensaje)) . "')");

        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            return true;
        } else {
            return array("error" => "Error al guardar log");
        }
    }

}