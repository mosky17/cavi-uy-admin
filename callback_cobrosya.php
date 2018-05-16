<?php

require_once(dirname(__FILE__) . '/proc/classes/auth.php');
require_once(dirname(__FILE__) . '/proc/classes/pago.php');
require_once(dirname(__FILE__) . '/proc/classes/socio.php');
require_once(dirname(__FILE__) . '/proc/classes/cobrosya.php');

date_default_timezone_set('America/Montevideo');
$MONTH_NAMES = array("01"=>'Enero',
    "02"=>'Febrero',
    "03"=>'Marzo',
    "04"=>'Abril',
    "05"=>'Mayo',
    "06"=>'Junio',
    "07"=>'Julio',
    "08"=>'Agosto',
    "09"=>'Setiembre',
    "10"=>'Octubre',
    "11"=>'Noviembre',
    "12"=>'Diciembre');


if (isset($_POST["id_secreto"])) {

    Auth::connect();

    $sql = 'SELECT * FROM transacciones_cobrosya WHERE id_secreto = "'.$_POST["id_secreto"].'" AND cancelado = 0 AND id_medio_pago = ""';
    $result = mysql_query($sql) or die(mysql_error());
    $transaccion = mysql_fetch_array($result, MYSQL_ASSOC);
    mysql_free_result($result);

    if ($transaccion) {

        if ($_POST["accion"] == "cobro") {

            //crear pago
            $month_string = strlen((string)$transaccion["month"]) == 2 ? (string)$transaccion["month"] : "0" . (string)$transaccion["month"];

            $ingresarPago = Pago::ingresar_pago(
                $transaccion["id_socio"],
                $_POST["monto"],
                explode(" ", $_POST["fecha_hora_pago"])[0],
                "mensualidad (" . $MONTH_NAMES[$month_string] . "/" . $transaccion["year"] . ")",
                "CobrosYA",
                "",
                0,
                "");

            if($ingresarPago){
                $sql = 'UPDATE transacciones_cobrosya SET
                    id_medio_pago = '.$_POST["id_medio_pago"].',
                    medio_pago = "'.$_POST["medio_pago"].'",
                    monto = "'.$_POST["monto"].'",
                    fecha_hora_pago = "'.$_POST["fecha_hora_pago"].'"
                WHERE id = "'.$transaccion["id"].'"'
                ;
                mysql_query($sql) or die(mysql_error());

                echo "1";

                $socio = Socio::get_socio($transaccion["id_socio"]);
                $nombre_array = explode(" ", $socio->nombre);

                Cobrosya::enviar_pago_recibido_a_socio(
                    $socio->email,
                    $nombre_array[0],
                    $transaccion["month"],
                    $transaccion["year"],
                    $socio->hash,
                    $_POST["monto"]
                );

            }else{

                $post_data = "";
                try {
                    $post_data = json_encode($_POST);
                } catch(Exception $e){

                }

                $sql = 'UPDATE transacciones_cobrosya SET
                    error   = "Error al ingresar pago en el sistema: " . $post_data;
                WHERE id = "'.$transaccion["id"].'"'
                ;
                mysql_query($sql) or die(mysql_error());

                echo "payment not saved";
            }
        }else{
            echo "wrong action";
        }
    }else{
        echo "wrong transaction";
    }
}else{
    echo "no secret";
}