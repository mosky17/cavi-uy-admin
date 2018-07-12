<?php

/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

//error_reporting(E_ALL);

require_once(dirname(__FILE__).'/classes/auth.php');
require_once(dirname(__FILE__).'/classes/socio.php');
require_once(dirname(__FILE__).'/classes/pago.php');
require_once(dirname(__FILE__).'/classes/exportar.php');
require_once(dirname(__FILE__).'/classes/admin.php');
require_once(dirname(__FILE__).'/classes/recordatorio_deuda.php');
require_once(dirname(__FILE__).'/classes/horas_trabajo.php');
require_once(dirname(__FILE__).'/classes/cobrosya.php');
require_once(dirname(__FILE__).'/classes/transaccion_cobrosya.php');
require_once(dirname(__FILE__).'/classes/costos.php');

//************** AUTH ********************

function login(){
	$username = htmlspecialchars(trim($_POST['email']));
	$passwd = htmlspecialchars(trim($_POST['passwd']));
	//$remember = htmlspecialchars(trim($_POST['remember']));
	echo json_encode(Auth::login($username,$passwd,false));
}
function logout(){
    $result = Auth::logout();
    echo json_encode($result);
}

//************** SOCIO ********************

function get_lista_socios(){
	$result = Socio::get_lista_socios();
	echo json_encode($result);
}
function get_socios_activos(){
    $result = Socio::get_socios_activos();
    echo json_encode($result);
}
function get_socios_suspendidos(){
    $result = Socio::get_socios_suspendidos();
    echo json_encode($result);
}
function get_tags(){
	$result = Socio::get_tags();
	echo json_encode($result);
}
function create_socio(){
	$result = Socio::create_socio($_POST['numero'],
        $_POST['nombre'],
        $_POST['documento'],
        $_POST['email'],
        $_POST['fecha_inicio'],
        $_POST['tags'],
        $_POST['telefono'],
        $_POST['observaciones'],
        $_POST['fecha_nacimiento'],
        $_POST['direccion'],
        $_POST['tamanio']);
	echo json_encode($result);
}
function update_socio(){
    $result = Socio::update_socio(
        $_POST['id'],
        $_POST['numero'],
        $_POST['nombre'],
        $_POST['documento'],
        $_POST['email'],
        $_POST['fecha_inicio'],
        isset($_POST["tags"]) ? $_POST['tags'] : "",
        $_POST['telefono'],
        $_POST['observaciones'],
        $_POST['fecha_nacimiento'],
        $_POST['direccion'],
        $_POST['tamanio']
    );
    echo json_encode($result);
}
function get_socio(){
	$result = Socio::get_socio($_POST['id']);
	echo json_encode($result);
}
function importar_socio_aecu(){
    $result = Socio::importar_socio_aecu($_POST['numero']);
    echo json_encode($result);
}
function eliminar_socio(){
    $result = Socio::eliminar_socio($_POST['id_socio']);
    echo json_encode($result);
}
function update_estado_socio(){
    $result = Socio::update_estado_socio($_POST['id_socio'],$_POST['activo']);
    echo json_encode($result);
}
function get_lista_mails(){
    $result = Socio::get_lista_mails($_POST['all'],$_POST['tags']);
    echo json_encode($result);
}
function send_estados_de_cuenta(){
    $result = Socio::send_estados_de_cuenta($_POST['total'],htmlspecialchars(trim($_POST['texto'])));
    echo json_encode($result);
}

//************** PAGO ********************

function ingresar_pago(){
    $result = Pago::ingresar_pago(
        $_POST['id_socio'],
        $_POST['valor'],
        $_POST['fecha_pago'],
        $_POST['razon'],
        $_POST['tipo'],
        $_POST['notas'],
        $_POST['descuento'],
        $_POST['descuento_json'],
        $_POST['rubro']
    );
    echo json_encode($result);
}
function salvar_pago_modificar(){
    $result = Pago::salvar_pago_modificar($_POST['id'],$_POST['razon'],$_POST['descuento'],$_POST['descuento_json']);
    echo json_encode($result);
}

function get_pagos_socio(){
    $result = Pago::get_pagos_socio($_POST['id_socio']);
    echo json_encode($result);
}
function get_lista_pagos(){
    $result = Pago::get_lista_pagos();
    echo json_encode($result);
}
function get_pago(){
    $result = Pago::get_pago($_POST['id']);
    echo json_encode($result);
}
function cancelar_pago(){
    $result = Pago::cancelar_pago($_POST['id']);
    echo json_encode($result);
}
function get_totales(){
    $result = Pago::get_totales();
    echo json_encode($result);
}

//************** LOG ********************

function get_lista_logs(){
    $result = Log::get_lista_logs();
    echo json_encode($result);
}

//************** ADMINS ********************

function get_lista_admins(){
    $result = Admin::get_lista_admins();
    echo json_encode($result);
}
function ingresar_admin(){
    $result = Admin::ingresar_admin($_POST['nombre'],$_POST['email'],$_POST['clave'],$_POST['permiso_pagos']);
    echo json_encode($result);
}
function update_admin(){
    $result = Admin::update_admin($_POST['id'],$_POST['nombre'],$_POST['email'],$_POST['clave'],$_POST['permiso_pagos']);
    echo json_encode($result);
}
function delete_admin(){
    $result = Admin::delete_admin($_POST['id']);
    echo json_encode($result);
}

//************** DATOS ********************

function update_dato(){
    $result = Dato::actualizar_dato($_POST['codigo'],$_POST['valor']);
    echo json_encode($result);
}

//************** DEUDA ********************

function get_all_deudas(){
    $result = RecordatorioDeuda::GetAllDeudas();
    echo json_encode($result);
}
function get_deudas_socio(){
    $result = RecordatorioDeuda::GetDeudasSocio($_POST['id_socio']);
    echo json_encode($result);
}
function ingresar_deuda(){
    $result = RecordatorioDeuda::IngresarDeuda($_POST['id_socio'],$_POST['monto'],$_POST['razon']);
    echo json_encode($result);
}
function cancelar_deuda(){
    $result = RecordatorioDeuda::CancelarDeuda($_POST['id']);
    echo json_encode($result);
}

function generar_hash(){
    $socio =Socio::get_socio($_POST['id']);
    $hash = $socio->generate_hash();
    echo $hash;
}

function ingresar_costo(){
    $cuotaCostos = Costos::ingresar_costo($_POST['valor'],$_POST['fecha_inicio'],$_POST['fecha_fin'],$_POST['descuento_anio'],$_POST['tiers_discounts']);
    echo json_encode($cuotaCostos);
}
function modificar_costo(){
    $cuotaCostos = Costos::salvar_costos_modificar($_POST['id'],$_POST['valor'],$_POST['fecha_inicio'],$_POST['fecha_fin'],$_POST['descuento_anio'],$_POST['tiers_discounts']);
    echo json_encode($cuotaCostos);
}
function borrar_costo(){
    $result = Costos::delete_costo($_POST['id']);
    echo json_encode($result);
}
function get_lista_costos(){
    $result = Costos::get_lista_costos();
    echo json_encode($result);
}

//************** COBROS YA ********************


function enviar_talon_cobrosya(){
    $result = Cobrosya::generate_talon(
        $_POST['id_socio'],
        $_POST['month'],
        $_POST['year']);
    echo json_encode($result);
}

function get_facturas_pendientes_cobrosya(){
    $result = TransaccionCobrosYa::get_facturas_pendientes_cobrosya($_POST['id_socio']);
    echo json_encode($result);
}


//************** HORAS ********************

function get_horas_socio(){
    $result = HorasTrabajo::get_horas_socio($_POST['id_socio']);
    echo json_encode($result);
}
function ingresar_horas(){
    $result = HorasTrabajo::ingresar_horas(
        $_POST['created_at'],
        $_POST['notas'],
        $_POST['id_socio'],
        $_POST['horas'],
        $_POST['rubro'],
        $_POST['costo']);
    echo json_encode($result);
}
function borrar_horas(){
    $result = HorasTrabajo::borrar_horas($_POST['id']);
    echo json_encode($result);
}
function get_horas_all(){
    $result = HorasTrabajo::get_horas_all();
    echo json_encode($result);
}

//************** EXPORTAR ********************

function exportar_pagos_por_socio(){
    Exportar::exportar_pagos_por_socio();
}
function exportar_caja(){
    Exportar::exportar_caja();
}
function exportar_pago_total_por_socio(){
    Exportar::exportar_pago_total_por_socio();
}
function exportar_pagos_por_mes(){
    Exportar::exportar_pagos_por_mes();
}
function exportar_socios_activos(){
    Exportar::exportar_socios_activos();
}
function exportar_deudas(){
    Exportar::exportar_deudas();
}

function exportar_descuentos_por_socio(){
    Exportar::exportar_descuentos_por_socio();
}

//************** PROC ********************

//auth
if(Auth::access_level()>=0){

	if($_POST["func"]){
		call_user_func($_POST["func"]);
	}else{
        if($_GET["exportar"]){
            call_user_func($_GET["exportar"]);
        }
    }
}else{
	if($_POST["func"]){
		if($_POST["func"] == 'login'){
			login();
		}
	}
}
