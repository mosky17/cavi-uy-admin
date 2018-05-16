<?php

require_once(dirname(__FILE__) . '/classes/socio.php');
require_once(dirname(__FILE__) . '/classes/cobrosya.php');

$socios = Socio::get_socios_activos();

$current_month = (int) date('m');
$current_year = (int) date('Y');

foreach($socios as $socio) {

if($socio->has_tag("13")) {

    if ($socio->email == "martin.gaibisso@gmail.com") {

        $response = Cobrosya::generate_talon($socio->id, $current_month, $current_year);

        //var_dump($response);

        if($response === true){
            echo "Se generó un talón para " . $socio->nombre . "\r\n";
        }else{
            echo $response["error"] . "\r\n";
        }
    }
}

}