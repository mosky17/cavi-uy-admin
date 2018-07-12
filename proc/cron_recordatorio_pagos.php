<?php

require_once(dirname(__FILE__) . '/classes/mail.php');
require_once(dirname(__FILE__) . '/classes/socio.php');
require_once(dirname(__FILE__) . '/classes/pago.php');
require_once(dirname(__FILE__).'/../config.php');

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
$current_month = date('m');
$current_year = date('Y');
$current_month_name = $MONTH_NAMES[$current_month];

$socios = Socio::get_socios_activos();

echo "START\n";

foreach($socios as $socio){

    if($socio->email != null && $socio->email != "" && strpos($socio->email,'@') > 0){

        $hash = $socio->hash;
        if($hash == null || $hash == ""){
            $hash = $socio->generate_hash();
        }

        if($hash != null && $hash != ""){

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
                "\">Estado de tu membres&iacute;a</a><br><br>";

            //send recordatorio
            $email_html = '<b>Estimado Socio,</b><br><br>' .
                $html_link.
                'Atte,<br>'.
                'CAVI';
            $email_subject = "Estado de su membresía";
            $email_to = $socio->email;
            //if($socio->email == 'martin.gaibisso@gmail.com'){
                //echo "\nSENDING EMAIL TO: " . $socio->email;

            echo "sending to: ".$socio->email."\n";

            Mail::SendDefault($email_html,$email_subject,$email_to);
            //}
        }
    }
    usleep(200000);
}
