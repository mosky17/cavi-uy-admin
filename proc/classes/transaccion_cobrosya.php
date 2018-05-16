<?php

require_once(dirname(__FILE__) . '/auth.php');

Auth::connect();

class TransaccionCobrosYa {

    public $id;
    public $id_socio;
    public $month;
    public $year;
    public $monto;
    public $talon_url;
    public $talon;
    public $medio_pago;

    function __construct($id, $id_socio, $month, $year, $monto, $talon_url,$talon,$medio_pago) {

        $this->id = $id;
        $this->id_socio = $id_socio;
        $this->month = $month;
        $this->year = $year;
        $this->monto = $monto;
        $this->talon_url = $talon_url;
        $this->talon = $talon;
        $this->medio_pago = $medio_pago;

    }

    static private function mysql_to_instances($result)
    {
        $return = array();
        if($result){
            while ($row = mysql_fetch_array($result)) {
                $instance = new TransaccionCobrosYa($row['id'], $row['id_socio'], $row['month'], $row['year'],
                    $row['monto'], $row['talon_url'], $row['talon'], $row['medio_pago']);
                $return[] = $instance;
            }
        }
        return $return;
    }

    static public function get_facturas_pendientes_cobrosya($id_socio)
    {
        $q = mysql_query("SELECT * FROM transacciones_cobrosya WHERE id_socio=".$id_socio);
        return TransaccionCobrosYa::mysql_to_instances($q);
    }

}