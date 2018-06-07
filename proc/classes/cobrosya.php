<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

// Aca va el token de COBROSYA que esta en su cuenta en Configuracion / Opciones de Configuracion / API para desarrolladores
//define('TOKEN', 'eb4a02e591caf3f2c38f0ca22946c2b2'); //sandbox
define('TOKEN', '6955ac79593ec8c4927f89952a01d15b');


// url de la API (sandbox o produccion)
//define('URL_API_CREAR' , 'http://api-sandbox.cobrosya.com/v4/crear'); //sandbox
//define('URL_API_COBRAR', 'http://api-sandbox.cobrosya.com/v4/cobrar'); //sandbox
define('URL_API_CREAR' , 'http://api.cobrosya.com/v4/crear'); //live
define('URL_API_COBRAR', 'http://api.cobrosya.com/v4/cobrar'); //live

require_once(dirname(__FILE__) . '/auth.php');
require_once(dirname(__FILE__) . '/socio.php');
require_once(dirname(__FILE__) . '/pago.php');

date_default_timezone_set('America/Montevideo');

Auth::connect();

class Cobrosya
{
    static public function generate_talon($socio_id,$month,$year)
    {
        $MONTH_NAMES = array(
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        );

        $socio = Socio::get_socio($socio_id);

        $nombre_array = explode(" ", $socio->nombre);
        $apellido = $nombre_array[1];
        $apellido .= count($nombre_array) > 2 ? " " . $nombre_array[2] : "";
        $apellido .= count($nombre_array) > 3 ? " " . $nombre_array[3] : "";

        $month_string = strlen((string)$month) == 2 ? (string)$month : "0" . (string)$month;
        $concepto = "Mensualidad CC El Piso: " . $MONTH_NAMES[$month-1];

        $cuota_costos = Pago::get_cuota_costos();
        $cuota = 0;
        for ($i = 0; $i < count($cuota_costos); $i++) {

            $mesInicio = (int)explode("-", $cuota_costos[$i]["fecha_inicio"])[1];
            $mesFin = (int)explode("-", $cuota_costos[$i]["fecha_fin"])[1];
            $yearInicio = (int)explode("-", $cuota_costos[$i]["fecha_inicio"])[0];
            $yearFin = (int)explode("-", $cuota_costos[$i]["fecha_fin"])[0];

            if ((($yearInicio == $year && $mesInicio <= $month) || $yearInicio < $year) &&
                (($yearFin == $year && $mesFin >= $month) || $yearFin > $year)
            ) {

                $cuota = (int)$cuota_costos[$i]["valor"];
            }
        }

        $fecha_vencimiento = $year . "-" . $month_string . "-" . 15;

        if ($cuota <= 0) {
            return array("error" => "No se puede generar un talon por monto 0 o negativo");
        }

        //check already generated
        $sql = 'SELECT * FROM transacciones_cobrosya WHERE id_socio = '.$socio_id.' AND month = '.$month.' AND year = '.$year.' AND cancelado=0';
        $result = mysql_query($sql) or die(mysql_error());

        if(mysql_num_rows($result) > 0){
            return array("error" => "Ya se generó un talon para este mes");
        }

        //create registro transaccion
        $sql = 'INSERT INTO transacciones_cobrosya (id_socio, month, year, monto) VALUES (' . $socio_id . ', "' . $month_string . '", "' . $year . '", "' . number_format($cuota, 1, '.', '') . '")';
        mysql_query($sql) or die(mysql_error());
        $transaccion_id = mysql_insert_id();

        $post = array(
            "token" => TOKEN,
            "id_transaccion" => $transaccion_id,
            "nombre" => $nombre_array[0],
            "apellido" => $apellido,
            "email" => $socio->email,
            "celular" => $socio->telefono,
            "concepto" => $concepto,
            "moneda" => 858,
            "monto" => number_format($cuota, 1, '.', ''),
            "monto_vencido" => number_format($cuota * 1.1, 1, '.', ''),
            "fecha_vencimiento" => $fecha_vencimiento,
            "url_respuesta" => $GLOBALS['domain'],
        );

        $ch = curl_init(URL_API_CREAR);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $res = curl_exec($ch);

        curl_close($ch);

        $xml = simplexml_load_string($res);

        if ($xml->error == 0) {

            $sql = 'UPDATE transacciones_cobrosya SET talon = ' . $xml->nro_talon . ', id_secreto = "' . $xml->id_secreto . '", talon_url = "' . $xml->url_pdf . '" WHERE id = ' . $transaccion_id;
            mysql_query($sql) or die(mysql_error());

            Cobrosya::enviar_talon_a_socio($socio->email,$nombre_array[0],$xml->url_pdf,$month);

            return true;

        } else {

            $sql = 'UPDATE transacciones_cobrosya SET cancelado = 1, error = "' . $xml->error . '" WHERE id = ' . $transaccion_id;
            mysql_query($sql) or die(mysql_error());

            return array("error" => $xml->error);
        }

    }

    static public function enviar_talon_a_socio($email,$nombre,$url_pdf,$month){

        $MONTH_NAMES = array(
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        );

        $html_link = "<a ".
            "style=\"".
            "background: #7ed934;".
            "background-image: -webkit-linear-gradient(top, #7ed934, #67b023);".
            "background-image: -moz-linear-gradient(top, #7ed934, #67b023);".
            "background-image: -ms-linear-gradient(top, #7ed934, #67b023);".
            "background-image: -o-linear-gradient(top, #7ed934, #67b023);".
            "background-image: linear-gradient(to bottom, #7ed934, #67b023);".
            "font-family: Arial;".
            "color: #ffffff;".
            "font-size: 20px;".
            "padding: 10px 20px 10px 20px;".
            "text-decoration: none;\"".
            "href=\"" . $url_pdf .
            "\">Descargar factura</a><br><br>";

        $email_html = '<b>Estimado ' . $nombre . ',</b><br><br>' .
            'Le notificamos que tiene una nueva factura correspondiente al mes de ' . $MONTH_NAMES[$month-1] . '.<br><br>'.
//            'A partir del mes de Setiembre del 2017 la cuota tendrá un valor de $4000. Recordamos que dedicando horas de trabajo tendras un descuento de $200/hr para tu próxima mensualidad.<br><br>'.
//            '<span style="text-decoration:underline">Formas de Pago:</span><br><br>' .
//            '<strong>BROU</strong><br>'.
//            'Puedes hacer una transferencia o deposito a la caja de ahorro numero <b>188-0504831</b> del BROU, en tal caso envianos un email con el detalle del pago, ya sea n&uacute;mero de transferencia o referencia.<br><br>'.
//            '<strong>Personalmente</strong><br>'.
//            'Puedes hacer el pago personalmente en nuestra sede solo con previo aviso a la administración.<br><br><br>'.
            $html_link.
            'Atte,<br>'.
            'La Administraci&oacute;n.<br>'.
            'Club Cann&aacute;bico El Piso';
        $email_subject = "Notificación de factura";

        Mandrill::SendDefault("",$email_html,$email_subject,$email,array("CCEP"));
    }

    static public function enviar_pago_recibido_a_socio($email,$nombre,$month,$year,$hash,$monto){

        $MONTH_NAMES = array(
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        );


                    $html_link = "<a ".
                        "style=\"".
                        "background: #7ed934;".
                        "background-image: -webkit-linear-gradient(top, #7ed934, #67b023);".
                        "background-image: -moz-linear-gradient(top, #7ed934, #67b023);".
                        "background-image: -ms-linear-gradient(top, #7ed934, #67b023);".
                        "background-image: -o-linear-gradient(top, #7ed934, #67b023);".
                        "background-image: linear-gradient(to bottom, #7ed934, #67b023);".
                        "font-family: Arial;".
                        "color: #ffffff;".
                        "font-size: 20px;".
                        "padding: 10px 20px 10px 20px;".
                        "text-decoration: none;\"".
                        "href=\"" . $GLOBALS['domain'] . "/vista_socio.php?h=" . $hash .
                        "\">Portal de socio</a><br><br>";

                    //send recordatorio
                    $email_text = "";
                    $email_html = '<b>Estimado '.$nombre.',</b><br><br>' .
                        'Esta es una notificaci&oacute;n de que hemos recibido tu pago por $' . $monto . ' correspondiente al mes de ' . $MONTH_NAMES[$month-1] . '/' . $year.'.<br><br>'.
                        'Puedes visitar tu portal de socio haciendo click en el siguiente boton:<br><br>'.
                        $html_link.
                        '<br>Atte,<br>'.
                        'La Administraci&oacute;n.<br>'.
                        'Club Cann&aacute;bico El Piso';

                    $email_subject = "Pago recibido";

                    $email_tags = array('CCEP');

                    Mandrill::SendDefault($email_text,$email_html,$email_subject,$email,$email_tags);
    }
}