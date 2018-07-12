var VistaSocio = {
    IdSocio: null,
    Hash:null,
    SocioData: {},
    BalanceHoras:0,
    DescuentoBalanceHoras:0,
    LoadSocio: function () {

        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/public_controller.php",
            data: { func: "get_socio", hash: VistaSocio.Hash }
        }).done(function (data) {
            if (data && !data.error) {
                VistaSocio.SocioData = data;
                VistaSocio.IdSocio = data.id;

                $('#socioLabelEstado').removeClass('badge-success');
                $('#socioLabelEstado').removeClass('badge-danger');
                if (data.activo == true) {
                    $('#socioLabelEstado').addClass('badge-success');
                    $('#socioLabelEstado').html("Activo");
                } else {
                    $('#socioLabelEstado').addClass('badge-danger');
                    $('#socioLabelEstado').html("Suspendido");
                }

                $("#socioNombreTitulo").html(data.nombre);
                $("#socioDatosValorNumero").html('<p>' + data.numero + "</p>");
                $("#socioDatosValorDocumento").html('<p>' + data.documento + "</p>");
                $("#socioDatosValorDireccion").html('<p>' + data.direccion + "</p>");
                $("#socioDatosValorEmail").html('<p>' + data.email + "</p>");
                $("#socioDatosValorFechaInicio").html('<p>' + Toolbox.MysqlDateToDate(data.fecha_inicio) + "</p>");
                $("#socioDatosValorFechaNacimiento").html('<p>' + Toolbox.MysqlDateToDate(data.fecha_nacimiento) + "</p>");
                $("#socioDatosValorTelefono").html('<p>' + data.telefono + "</p>");
                $("#socioDatosValorTamanio").html('<p>' + data.tamanio + "</p>");

                VistaSocio.LoadPagos();
                VistaSocio.GetDeudas();

            } else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', 'Unexpected error');
                }
            }
            Toolbox.StopLoader();
        });
    },
    LoadPagos: function () {
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/public_controller.php",
            data: { func: "get_pagos_socio", id_socio: VistaSocio.IdSocio }
        }).done(function (data) {
            if (data && !data.error) {

                $('#listaPagosSocioTabla').html("");
                for (var i = 0; i < data.length; i++) {

                    var descuento = "";
                    if(data[i].descuento != "" && data[i].descuento != "0.00"){
                        descuento = data[i].descuento + ' ' + Toolbox.TransformSpecialTag(data[i].descuento_json)

                        if(data[i].descuento_json == "BalanceVoluntariado") {
                            VistaSocio.DescuentoBalanceHoras += Number(data[i].descuento);
                        }
                    }

                    $('#listaPagosSocioTabla').append('<tr><td>' + data[i].id + '</td>' +
                        '<td>' + data[i].valor + '</td>' +
                        '<td>' + Toolbox.MysqlDateToDate(data[i].fecha_pago) + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].razon) + '</td>' +
                        '<td>' + descuento + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].tipo) + '</td></tr>');
                }

                VistaSocio.GetHorasVoluntariado();

            } else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', 'Unexpected error');
                }
            }
            Toolbox.StopLoader();
        });
    },
    GetDeudas: function(){
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/public_controller.php",
            data: { func: "get_deudas_socio", id_socio: VistaSocio.IdSocio }
        }).done(function (data) {
            if (data && !data.error) {
                $('.socioRecordatorioDeudaContainer').html('');
                if(data.length > 0){
                    $('.deudas').css("display","block");
                }
                for(var i=0;i<data.length;i++){
                    $('.socioRecordatorioDeudaContainer').append('<span class="alert alert-danger socio-deuda"><strong>$' + data[i].monto + "</strong>  " + data[i].razon + '</span>');
                }
            }
            Toolbox.StopLoader();
        });
    },
    GetHorasVoluntariado: function(){
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_horas_socio", id_socio: VistaSocio.IdSocio}
        }).done(function (data) {
            if (data && !data.error) {

                $('#listaHorasSocioTabla').html("");
                var balance = 0;

                for (var i = 0; i < data.length; i++) {

                    balance += Number(data[i].horas * data[i].costo);

                    $('#listaHorasSocioTabla').append('<tr><td>' + Toolbox.MysqlDateToDate(data[i].created_at) + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].rubro) + '</td>' +
                        '<td>' + data[i].horas + '</td>' +
                        '<td>' + data[i].costo + '</td></tr>');
                }

                $('#socioDatosValorBalanceHoras').html("<p>$" + Number(balance - VistaSocio.DescuentoBalanceHoras) + "</p>");
                VistaSocio.BalanceHoras = balance;

            } else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', 'Error al cargar horas de voluntariado');
                }
            }
            Toolbox.StopLoader();
        });
    },
}

$(document).ready(function () {

    var params = Toolbox.GetUrlVars();

    if (params['h']) {
        VistaSocio.Hash = params['h'];
    }
    VistaSocio.LoadSocio();
});
