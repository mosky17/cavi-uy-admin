<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

require_once(dirname(__FILE__) . '/auth.php');
require_once(dirname(__FILE__) . '/dato.php');

Auth::connect();

class Pago
{

    public $fecha_pago;
    public $id;
    public $id_socio;
    public $razon;
    public $valor;
    public $tipo;
    public $notas;
    public $cancelado;
    public $descuento;
    public $descuento_json;
    public $rubro;

    function __construct(
        $id, 
        $id_socio, 
        $fecha_pago, 
        $razon, 
        $valor, 
        $tipo, 
        $notas, 
        $cancelado, 
        $descuento, 
        $descuento_json,
        $rubro
    ){
        $this->id = $id;
        $this->id_socio = $id_socio;
        $this->fecha_pago = $fecha_pago;
        $this->razon = $razon;
        $this->valor = $valor;
        $this->tipo = $tipo;
        $this->notas = $notas;
        $this->cancelado = $cancelado;
        $this->descuento = $descuento;
        $this->descuento_json = $descuento_json;
        $this->rubro = $rubro;
    }

    static private function mysql_to_instances($result)
    {
        $return = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $instance = new Pago($row['id'], $row['id_socio'], $row['fecha_pago'], $row['razon'], $row['valor'], $row['modo'],
                    $row['notas'], $row['cancelado'], $row['descuento'], $row['descuento_json'], $row['rubro']);
                $return[] = $instance;
            }
        }
        return $return;
    }

    static public function get_pago($id)
    {
        $q=Auth::$mysqli->query("SELECT * FROM pagos WHERE id=" . $id);
        $result = Pago::mysql_to_instances($q);
        if (count($result) == 1) {
            return $result[0];
        } else {
            return array("error" => "Pago no encontrado");
        }
    }

    static public function cancelar_pago($id)
    {
        $pago = Pago::get_pago($id);
        if (Dato::verificar_movimiento_caja($pago->fecha_pago) !== true) {
            return array("error" => "Caja cerrada! No se pueden alterar movimientos de esta fecha.");
        }

        $q=Auth::$mysqli->query("UPDATE pagos SET cancelado=1 WHERE id=" . $id);
        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            return true;
        } else {
            return array("error" => "Pago no cancelado");
        }
    }

    static public function salvar_pago_modificar($id,$razon,$descuento,$descuento_json)
    {
        $pago = Pago::get_pago($id);
        if (Dato::verificar_movimiento_caja($pago->fecha_pago) !== true) {
            return array("error" => "Caja cerrada! No se pueden alterar movimientos de esta fecha.");
        }

        $q=Auth::$mysqli->query("UPDATE pagos SET razon='".$razon."', descuento='".$descuento."', descuento_json='".$descuento_json."' WHERE id=" . $id);
        //echo "UPDATE pagos SET razon='".$razon."', descuento='".$descuento."', descuento_json='".$descuento_json."' WHERE id=" . $id;
        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            return true;
        } else {
            return array("error" => "Pago no modificado");
        }
    }



    static public function get_pagos_socio($id_socio)
    {
        $q=Auth::$mysqli->query("SELECT * FROM pagos WHERE id_socio=" . $id_socio . " AND cancelado=0 ORDER BY fecha_pago DESC;");
        return Pago::mysql_to_instances($q);
    }

    static public function get_lista_pagos()
    {
        $q=Auth::$mysqli->query("SELECT * FROM pagos WHERE cancelado=0 ORDER BY fecha_pago DESC;");
        return Pago::mysql_to_instances($q);
    }

    static public function get_lista_pagos_con_cancelados()
    {
        $q=Auth::$mysqli->query("SELECT * FROM pagos ORDER BY fecha_pago;");
        return Pago::mysql_to_instances($q);
    }

    static public function ingresar_pago(
        $id_socio,
        $valor,
        $fecha_pago,
        $razon,
        $tipo,
        $notas,
        $descuento,
        $descuento_json,
        $rubro
    ){

        if (Dato::verificar_movimiento_caja($fecha_pago) !== true) {
            return array("error" => "Caja cerrada! No se pueden ingresar movimientos en esta fecha.");
        }

        $q=Auth::$mysqli->query("INSERT INTO pagos (id_socio, valor, fecha_pago, razon, descuento, descuento_json, modo, notas, rubro) VALUES (" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$id_socio)) . ", '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$valor)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_pago)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$razon)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$descuento)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$descuento_json)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$tipo)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$notas)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$rubro)) . "');");

//        echo "INSERT INTO pagos (id_socio, valor, fecha_pago, razon, descuento, descuento_json, modo, notas) VALUES (" .
//            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$id_socio)) . ", '" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$valor)) . "', '" .
//            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_pago)) . "', '" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$razon)) . "', '" .
//            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$descuento)) . "', '" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$descuento_json)) . "', '" .
//            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$tipo)) . "', '" . htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$notas)) . "');";

        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            return true;
        } else {
            return array("error" => "Error al ingresar pago");
        }
    }

    static public function get_totales(){

        $retorno = array("ingresos_socios"=>0,
            "otros_ingresos"=>0,
            "gastos"=>0);

        $pagos = Pago::get_lista_pagos();

        for($i=0;$i<count($pagos);$i++){
            if($pagos[$i]->valor < 0){
                $retorno["gastos"] += $pagos[$i]->valor * -1;
            }else{
                if($pagos[$i]->rubro == "Socio") {
                    $retorno["ingresos_socios"] += $pagos[$i]->valor;
                }else{
                    $retorno["otros_ingresos"] += $pagos[$i]->valor;
                }
            }
        }

        return $retorno;
    }


}
