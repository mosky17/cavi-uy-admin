<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

require_once(dirname(__FILE__) . '/auth.php');
require_once(dirname(__FILE__) . '/dato.php');

Auth::connect();

class Costos
{

    public $id;
    public $valor;
    public $fecha_inicio;
    public $fecha_fin;
    public $descuento_anio;
    public $tiers_discounts;

    function __construct(
        $id,
        $valor,
        $fecha_inicio,
        $fecha_fin,
        $descuento_anio,
        $tiers_discounts
    ){
        $this->id = $id;
        $this->valor = $valor;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->descuento_anio = $descuento_anio;
        $this->tiers_discounts = $tiers_discounts;
    }

    static private function mysql_to_instances($result)
    {
        $return = array();
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $instance = new Costos(
                    $row['id'],
                    $row['valor'],
                    $row['fecha_inicio'],
                    $row['fecha_fin'],
                    $row['descuento_anio'],
                    $row['tiers_discounts']
                );
                $return[] = $instance;
            }
        }
        return $return;
    }

    static public function get_costo($id)
    {
        $q=Auth::$mysqli->query("SELECT * FROM cuota_costo WHERE id=" . $id);
        $result = Costos::mysql_to_instances($q);
        if (count($result) == 1) {
            return $result[0];
        } else {
            return array("error" => "Costo no encontrado");
        }
    }

    static public function salvar_costos_modificar($id,
                                                   $valor,
                                                   $fecha_inicio,
                                                   $fecha_fin,
                                                   $descuento_anio,
                                                   $tiers_discounts
    ){
        $costo = Costos::get_costo($id);
        if (Dato::verificar_movimiento_caja($costo->fecha_fin) !== true) {
            return array("error" => "Caja cerrada! No se pueden alterar movimientos de esta fecha.");
        }

        $q=Auth::$mysqli->query("UPDATE cuota_costo SET valor='".$valor."', fecha_inicio='".$fecha_inicio."', fecha_fin='".$fecha_fin."', descuento_anio='".$descuento_anio."', tiers_discounts='".$tiers_discounts."' WHERE id=" . $id);
        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            return true;
        } else {
            return array("error" => "Costo no modificado");
        }
    }

    static public function get_lista_costos()
    {
        $q=Auth::$mysqli->query("SELECT * FROM cuota_costo ORDER BY fecha_inicio DESC;");
        return Costos::mysql_to_instances($q);
    }

    static public function delete_costo($id)
    {
        $q=Auth::$mysqli->query("DELETE FROM cuota_costo WHERE id=" . $id);
        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            return true;
        } else {
            return array("error" => "Registro no borrado");
        }
    }

    static public function ingresar_costo($valor,
                                          $fecha_inicio,
                                          $fecha_fin,
                                          $descuento_anio,
                                          $tiers_discounts
    ){

        if (Dato::verificar_movimiento_caja($fecha_fin) !== true) {
            return array("error" => "Caja cerrada! No se pueden ingresar movimientos en esta fecha.");
        }

        $q=Auth::$mysqli->query("INSERT INTO cuota_costo (valor, fecha_inicio, fecha_fin, descuento_anio, tiers_discounts) VALUES (" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$valor)) . ", '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_inicio)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$fecha_fin)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$descuento_anio)) . "', '" .
            htmlspecialchars(mysqli_real_escape_string(Auth::$mysqli,$tiers_discounts)) . "');");

        if (mysqli_affected_rows(Auth::$mysqli) == 1) {
            return true;
        } else {
            return array("error" => "Error al ingresar registro");
        }
    }

}