<?php

require_once(dirname(__FILE__) . '/auth.php');

Auth::connect();

class HorasTrabajo {

    public $id;
    public $created_at;
    public $notas;
    public $id_socio;
    public $horas;
    public $rubro;
    public $costo;

    function __construct($id, $created_at, $notas, $id_socio, $horas, $rubro, $costo) {

        $this->id = $id;
        $this->created_at = $created_at;
        $this->notas = $notas;
        $this->id_socio = $id_socio;
        $this->horas = $horas;
        $this->rubro = $rubro;
        $this->costo = $costo;

    }

    static private function mysql_to_instances($result)
    {
        $return = array();
        if($result){
            while ($row = mysql_fetch_array($result)) {
                $instance = new HorasTrabajo($row['id'], $row['created_at'], $row['notas'], $row['id_socio'], $row['cantidad_horas'], $row['rubro'], $row['costo_hora']);
                $return[] = $instance;
            }
        }
        return $return;
    }

    static public function borrar_horas($id)
    {
        $q = mysql_query("DELETE FROM horas_trabajadas WHERE id=".$id);
        if (mysql_affected_rows() == 1) {
            return true;
        } else {
            return array("error" => "Horas no borradas");
        }
    }

    static public function get_horas_socio($id_socio)
    {
        $q = mysql_query("SELECT * FROM horas_trabajadas WHERE id_socio=".$id_socio." ORDER BY created_at ASC;");
        return HorasTrabajo::mysql_to_instances($q);
    }

    static public function get_horas_all()
    {
        $q = mysql_query("SELECT * FROM horas_trabajadas ORDER BY created_at ASC;");
        return HorasTrabajo::mysql_to_instances($q);
    }

    static public function ingresar_horas($created_at, $notas, $id_socio, $horas, $rubro, $costo){

        $q = mysql_query("INSERT INTO horas_trabajadas (created_at, notas, id_socio, cantidad_horas, rubro, costo_hora) VALUES ('" . htmlspecialchars(mysql_real_escape_string($created_at)) . "', '" .
            htmlspecialchars(mysql_real_escape_string($notas)) . "', " . htmlspecialchars(mysql_real_escape_string($id_socio)) . ", '" .
            $horas . "', '" . htmlspecialchars(mysql_real_escape_string($rubro)) . "', " . htmlspecialchars(mysql_real_escape_string($costo)) . ");");

        if (mysql_affected_rows() == 1) {
            return true;
        } else {
            return array("error" => "Error al ingresar horas");
        }
    }

}