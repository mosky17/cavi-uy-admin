/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

var Socio = {
    Editing: false,
    New: false,
    IdSocio: null,
    Tags: {},
    SocioData: {},
    Geneticas: null,
    CuotaCostos: null,
    CurrentCostoCuota: 0,
    BalanceHoras:0,
    DescuentoBalanceHoras:0,
    GetTags: function () {
        Toolbox.ShowLoader();

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_tags"}
        }).done(function (data) {
            if (data && !data.error) {

                for (var i = 0; i < data.length; i++) {
                    Socio.Tags[data[i].id] = data[i];
                }

                if (Socio.New) {
                    Socio.LoadNewForm();
                } else if (Socio.IdSocio) {
                    Socio.LoadSocio();
                }

            } else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', 'Error al cargar Tags');
                }
            }
            Toolbox.StopLoader();
        });
    },
    LoadNewForm: function () {

        $('#socioNombreTitulo').html('Nuevo Socio');
        $("#socioBtnSalvarContainer").css('display', 'block');
        $('#socioDatosValorNumero').html('<input id="socioNuevoNumero" type="text">');
        $('#socioDatosValorTamanio').html('<input id="socioNuevoTamanio" type="text">');
        $('#socioDatosValorEmail').html('<input id="socioNuevoEmail" type="text">');
        $('#socioDatosValorDireccion').html('<input id="socioNuevoDireccion" type="text">');
        $('#socioDatosValorDocumento').html('<input id="socioNuevoDocumento" type="text">');
        $('#socioDatosValorNombre').html('<input id="socioNuevoNombre" type="text">');
        $('#socioDatosValorTelefono').html('<input id="socioNuevoTelefono" type="text">');
        $('#socioDatosValorFechaInicio').html('<input id="socioNuevoFechaInicio"  placeholder="01/12/2013" type="text">');
        $('#socioDatosValorFechaNacimiento').html('<input id="socioNuevoFechaNacimiento"  placeholder="01/12/2013" type="text">');
        $('#socioDatosValorTags').html('');
        $.each(Socio.Tags, function (index, value) {
            $('#socioDatosValorTags').append('<label><input type="checkbox" id="socioNuevoTagChk_' + value.id + '" class="socioNuevoTagChk" name="' + value.id + '"/>' + value.nombre + '</label>');
        });
        $('#socioDatosValorObservaciones').html('<textarea id="socioNuevoObservaciones"></textarea>');
        $('#socioDatosFieldNombre').css('display', 'block');
        $("#socioNuevoFechaInicio").mask("99/99/9999");
        $("#socioNuevoFechaNacimiento").mask("99/99/9999");
    },
    SalvarSocio: function () {

        if (Socio.VerificarDatosSocio()) {

            var tags = new Array();
            $(".socioNuevoTagChk:checked").each(function () {
                tags.push($(this).attr('name'));
            });

            var postData;
            if (Socio.Editing) {
                postData = {
                    func: "update_socio",
                    id: Socio.IdSocio,
                    numero: $('#socioNuevoNumero').val(),
                    nombre: $('#socioNuevoNombre').val(),
                    documento: $('#socioNuevoDocumento').val(),
                    direccion: $('#socioNuevoDireccion').val(),
                    email: $('#socioNuevoEmail').val(),
                    tamanio: $('#socioNuevoTamanio').val(),
                    telefono: $('#socioNuevoTelefono').val(),
                    fecha_inicio: Toolbox.DataToMysqlDate($('#socioNuevoFechaInicio').val()),
                    tags: tags,
                    observaciones: $('#socioNuevoObservaciones').val(),
                    fecha_nacimiento: Toolbox.DataToMysqlDate($('#socioNuevoFechaNacimiento').val())
                };
            } else {
                postData = {
                    func: "create_socio",
                    numero: $('#socioNuevoNumero').val(),
                    nombre: $('#socioNuevoNombre').val(),
                    documento: $('#socioNuevoDocumento').val(),
                    direccion: $('#socioNuevoDireccion').val(),
                    email: $('#socioNuevoEmail').val(),
                    tamanio: $('#socioNuevoTamanio').val(),
                    telefono: $('#socioNuevoTelefono').val(),
                    fecha_inicio: Toolbox.DataToMysqlDate($('#socioNuevoFechaInicio').val()),
                    tags: tags,
                    observaciones: $('#socioNuevoObservaciones').val(),
                    fecha_nacimiento: Toolbox.DataToMysqlDate($('#socioNuevoFechaNacimiento').val())
                };
            }

            Toolbox.ShowLoader();

            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: postData
            }).done(function (data) {
                if (data && !data.error) {
                    //console.log(data);
                    document.location.href = "socio.php?id=" + data;
                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', 'Unexpected error');
                    }
                }
                Toolbox.StopLoader();
            });
        }
    },
    VerificarDatosSocio: function () {

        var error = undefined;

        if (Socio.New) {
            if (!error && $('#socioNuevoNombre').val() == '') {
                error = 'Falt&oacute; especificar nombre de socio';
            } else if (!error && $('#socioNuevoNumero').val() == '') {
                error = 'Falt&oacute; especificar numero de socio';
            } else if (!error && isNaN($('#socioNuevoNumero').val())) {
                error = 'N&uacute;mero de socio invalido';
            }
            if (!error && $('#socioNuevoEmail').val() == '') {
                error = 'Falt&oacute; especificar un email';
            }
            if (!error && $('#socioNuevoNombre').val() == '') {
                error = 'Falt&oacute; especificar el nombre del socio';
            }
            if (!error && $('#socioNuevoFechaInicio').val() == '') {
                error = 'Falt&oacute; especificar fecha de inicio';
            }
            if (!error && $('#socioNuevoFechaNacimiento').val() == '') {
                error = 'Falt&oacute; especificar fecha de nacimiento';
            }
            if (!error && $('#socioNuevoTamanio').val() == '') {
                error = 'Falt&oacute; especificar el tamaño de la empresa';
            }
        }

        if (error == undefined) {
            Toolbox.ShowFeedback('feedbackContainer', '', '');
        } else {
            Toolbox.ShowFeedback('feedbackContainer', 'error', error);
        }

        return error == undefined;
    },
    LoadSocio: function () {

        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_socio", id: Socio.IdSocio}
        }).done(function (data) {
            if (data && !data.error) {
                Socio.SocioData = data;

                $('#socioLabelEstado').removeClass('badge-success');
                $('#socioLabelEstado').removeClass('badge-danger');
                if (data.activo == true) {
                    $('#socioLabelEstado').addClass('badge-success');
                    $('#socioLabelEstado').html("Activo");
                } else {
                    $('#socioLabelEstado').addClass('badge-danger');
                    $('#socioLabelEstado').html("Suspendido");
                }

                $("#socioDatosFieldNombre").css('display', 'none');
                $("#socioBtnSalvarContainer").css('display', 'none');
                $("#socioNombreTitulo").html(data.nombre + '<i class="fas fa-pencil-alt socioIconBtnTitle" onClick="Socio.EditSocio();" title="Editar socio"></i><i class="fas fa-user-circle socioIconBtnTitle" onClick="Socio.OpenSocioView();" title="Vista de socio"></i>');
                $("#socioDatosValorNumero").html('<p>' + data.numero + "</p>");
                $("#socioDatosValorDocumento").html('<p>' + data.documento + "</p>");
                $("#socioDatosValorDireccion").html('<p>' + data.direccion + "</p>");
                $("#socioDatosValorEmail").html('<p>' + data.email + "</p>");
                $("#socioDatosValorFechaInicio").html('<p>' + Toolbox.MysqlDateToDate(data.fecha_inicio) + "</p>");
                $("#socioDatosValorFechaNacimiento").html('<p>' + Toolbox.MysqlDateToDate(data.fecha_nacimiento) + "</p>");
                $("#socioDatosValorTelefono").html('<p>' + data.telefono + "</p>");
                $("#socioDatosValorTamanio").html('<p>' + data.tamanio + "</p>");
                if (data.observaciones) {
                    $("#socioDatosValorObservaciones").html('<p>' + data.observaciones + "</p>");
                }
                //tags
                var tagsHtml = "<div style='padding: 10px 0 0;'>";
                for (var j = 0; j < data.tags.length; j++) {
                    if (data.tags[j] && data.tags[j] != '' && Socio.Tags[data.tags[j]]) {
                        tagsHtml += '<span class="label socioTag" style="background-color:' + Socio.Tags[data.tags[j]].color + '">' + Socio.Tags[data.tags[j]].nombre + '</span>';
                    }
                }
                $("#socioDatosValorTags").html(tagsHtml + "</div>");
                $('.row_empresa').css("display",'none');

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
    EditSocio: function () {
        Socio.Editing = true;
        $('#socioNombreTitulo').html(Socio.SocioData.nombre);
        $('.row_empresa').css("display",'table-row');
        $("#socioDatosFieldNombre").css('display', 'block');
        $("#socioBtnSalvarContainer").css('display', 'block');
        $('#socioDatosValorNumero').html('<input id="socioNuevoNumero" type="text" value="' + Socio.SocioData.numero + '">');
        $('#socioDatosValorEmail').html('<input id="socioNuevoEmail" type="text" value="' + Socio.SocioData.email + '">');
        $('#socioDatosValorDocumento').html('<input id="socioNuevoDocumento" type="text" value="' + Socio.SocioData.documento + '">');
        $('#socioDatosValorDireccion').html('<input id="socioNuevoDireccion" type="text" value="' + Socio.SocioData.direccion + '">');
        $('#socioDatosValorNombre').html('<input id="socioNuevoNombre" type="text" value="' + Socio.SocioData.nombre + '">');
        $('#socioDatosValorTelefono').html('<input id="socioNuevoTelefono" type="text" value="' + Socio.SocioData.telefono + '">');
        $('#socioDatosValorFechaInicio').html('<input id="socioNuevoFechaInicio" type="text"  placeholder="01/12/2013" value="' + Toolbox.MysqlDateToDate(Socio.SocioData.fecha_inicio) + '">');
        $('#socioDatosValorFechaNacimiento').html('<input id="socioNuevoFechaNacimiento" type="text"  placeholder="01/12/2013" value="' + Toolbox.MysqlDateToDate(Socio.SocioData.fecha_nacimiento) + '">');
        $('#socioDatosValorTags').html('');
        $('#socioDatosValorTamanio').html('<input id="socioNuevoTamanio" type="text" value="' + Socio.SocioData.tamanio + '">');
        if(Socio.Tags) {
            $.each(Socio.Tags, function (index, value) {
                $('#socioDatosValorTags').append('<label><input type="checkbox" id="socioNuevoTagChk_' + value.id + '" class="socioNuevoTagChk" name="' + value.id + '"/>' + value.nombre + '</label>');
            });
            $.each(Socio.SocioData.tags, function (index, value) {
                $('#socioNuevoTagChk_' + value).attr('checked', 'checked');
            });
        }
        $('#socioDatosValorObservaciones').html('<textarea id="socioNuevoObservaciones">' + Socio.SocioData.observaciones + '</textarea>');
        $("#socioNuevoFechaInicio").mask("99/99/9999");
        $("#socioNuevoFechaNacimiento").mask("99/99/9999");

    },
    OpenModalNuevoPago: function () {

        $('.feedbackContainerModal').css('display', 'none');

        Socio.calcularValorCuotaNuevoPago();

        //calcualte balance horas
        var balance = Number(Socio.BalanceHoras - Socio.DescuentoBalanceHoras);
        if(balance > 0){
            $('#socioIngresarPagoRazonDescuento').val("Balance");
            var aDescountar = balance;
            if(aDescountar > Socio.CurrentCostoCuota){
                aDescountar = Socio.CurrentCostoCuota;
            }
            $('#socioIngresarPagoDescuento').val(aDescountar);
            $('#socioIngresarPagoValor').val(Number($('#socioIngresarPagoValor').val())-aDescountar);
        }

        $('#socioIngresarPagoNotas').val('');
        $('#socioIngresarPagoFecha').val(Toolbox.GetFechaHoyLocal());
        $('#socioIngresarPagoModal').modal("show");
    },
    calcularValorCuotaNuevoPago: function(){
        var year = $('#socioIngresarPagoRazonMensualidadAnio').val();
        var mes = Toolbox.NombreMesesEspIndex[$('#socioIngresarPagoRazonMensualidadMes').val().toLowerCase()];

        for(var i=0;i<Socio.CuotaCostos.length;i++){
            var mesInicio = Socio.CuotaCostos[i].fecha_inicio.split("-")[1];
            var mesFin = Socio.CuotaCostos[i].fecha_fin.split("-")[1];
            var yearInicio = Socio.CuotaCostos[i].fecha_inicio.split("-")[0];
            var yearFin = Socio.CuotaCostos[i].fecha_fin.split("-")[0];

            if(((yearInicio == year && mesInicio <= mes) || yearInicio < year) &&
                ((yearFin == year && mesFin >= mes) || yearFin > year)){
                //$('#socioIngresarPagoValor').val(Socio.CuotaCostos[i].valor);
                Socio.CurrentCostoCuota = Socio.CuotaCostos[i].valor;
            }
        }
    },
    calcularValorCuota: function(mes,year){

        for(var i=0;i<Socio.CuotaCostos.length;i++){
            var mesInicio = Socio.CuotaCostos[i].fecha_inicio.split("-")[1];
            var mesFin = Socio.CuotaCostos[i].fecha_fin.split("-")[1];
            var yearInicio = Socio.CuotaCostos[i].fecha_inicio.split("-")[0];
            var yearFin = Socio.CuotaCostos[i].fecha_fin.split("-")[0];

            if(((yearInicio == year && mesInicio <= mes) || yearInicio < year) &&
                ((yearFin == year && mesFin >= mes) || yearFin > year)){
                 return Socio.CuotaCostos[i].valor;
            }
        }
    },
    OnChangeMonto: function(){
        //$('#socioIngresarPagoDescuento').val(Socio.CurrentCostoCuota - $('#socioIngresarPagoValor').val());
    },
    IngresarPago: function () {
        if (Socio.VerificarDatosPago()) {

            var razonPago = $("#socioIngresarPagoRazon").val();
            if ($("#socioIngresarPagoRazon").val() == "mensualidad") {
                razonPago = "mensualidad (" + $('#socioIngresarPagoRazonMensualidadMes').val() + "/" + $('#socioIngresarPagoRazonMensualidadAnio').val() + ")";
            }else if ($("#socioIngresarPagoRazon").val() == "anio") {
                razonPago = "anio (" + $('#socioIngresarPagoRazonMensualidadAnio').val() + ")";
            }else if ($("#socioIngresarPagoRazon").val() == "medioanio") {
                razonPago = "medioanio (" + $('#socioIngresarPagoRazonMensualidadParte').val() + ")";
            }

            Toolbox.ShowLoaderModal();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: {
                    func: "ingresar_pago",
                    id_socio: Socio.IdSocio,
                    valor: $("#socioIngresarPagoValor").val(),
                    fecha_pago: Toolbox.DataToMysqlDate($("#socioIngresarPagoFecha").val()),
                    razon: razonPago, notas: $("#socioIngresarPagoNotas").val(),
                    tipo: $("#socioIngresarPagoTipo").val(),
                    descuento: $("#socioIngresarPagoDescuento").val(),
                    descuento_json: $("#socioIngresarPagoRazonDescuento").val(),
                    rubro: "Socio"
                }
            }).done(function (data) {
                if (data && !data.error) {
                    Socio.LoadPagos();
                    $('#socioIngresarPagoModal').modal('hide');
                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('feedbackContainerModalIngresarPago', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('feedbackContainerModalIngresarPago', 'error', 'Unexpected error');
                    }
                }
                Toolbox.StopLoaderModal();
            });
        }
    },
    VerificarDatosPago: function () {
        var error = undefined;

        if (!error && $('#socioIngresarPagoValor').val() == '') {
            error = 'Falt&oacute; especificar el valor del pago';
        } else if (!error && $('#socioIngresarPagoFecha').val() == '') {
            error = 'Falto especificar fecha de pago';
        } else if (!error && !$('#socioIngresarPagoVia').val()) {
            error = 'Falto especificar el modo de pago';
        }else if (!error && isNaN($('#socioIngresarPagoValor').val())) {
            error = 'Valor invalido';
        }
        //else if (!error && $('#socioIngresarPagoRazon').val() == "mensualidad" &&
        //    Socio.CurrentCostoCuota > 0 &&
        //    $('#socioIngresarPagoValor').val() + $('#socioIngresarPagoDescuento').val() > Socio.CurrentCostoCuota){
        //
        //    error = 'El monto y el descuento exceden el costo de la cuota mensual establecida de $' + Socio.CurrentCostoCuota;
        //}

        if (error == undefined) {
            Toolbox.ShowFeedback('feedbackContainerModalIngresarPago', '', '');
        }
        else {
            Toolbox.ShowFeedback('feedbackContainerModalIngresarPago', 'error', error);
        }

        return error == undefined;
    },
    LoadPagos: function () {
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_pagos_socio", id_socio: Socio.IdSocio}
        }).done(function (data) {
            if (data && !data.error) {

                $('#listaPagosSocioTabla').html("");
                $('#listaPagosPorMesSocioTabla').html("");
                Socio.DescuentoBalanceHoras = 0;

                //pagos por mes data
                var pagosPorMes = {};
                var descuentosPorMes = {};

                for (var i = 0; i < data.length; i++) {

                    var descuento = "";
                    if(data[i].descuento != "" && data[i].descuento != "0.00"){
                        descuento = data[i].descuento + ' ' + Toolbox.TransformSpecialTag(data[i].descuento_json)

                        if(data[i].descuento_json == "Balance") {
                            Socio.DescuentoBalanceHoras += Number(data[i].descuento);
                        }
                    }

                    $('#listaPagosSocioTabla').append('<tr onClick="document.location.href = \'pago.php?id=' + data[i].id + '\'"><td>' + data[i].id + '</td>' +
                        '<td>' + data[i].valor + '</td>' +
                        '<td>' + Toolbox.MysqlDateToDate(data[i].fecha_pago) + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].razon) + '</td>' +
                        '<td>' + descuento + '</td>' +
                        '<td>' + data[i].notas + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].tipo) + '</td></tr>');

                    if(!(data[i].razon in pagosPorMes)){
                        pagosPorMes[data[i].razon] = Number(data[i].valor);
                    }else{
                        pagosPorMes[data[i].razon] += Number(data[i].valor);
                    }
                    if(data[i].descuento != "" && data[i].descuento != "0.00") {
                        if (!(data[i].razon in descuentosPorMes)) {
                            descuentosPorMes[data[i].razon] = Number(data[i].descuento);
                        } else {
                            descuentosPorMes[data[i].razon] += Number(data[i].descuento);
                        }
                    }
                }

                var today = new Date();
                var startYear = 2016;
                var startMonth = today.getMonth()+1;
                var pagosPorMesSortedData = [];

                for(var i=today.getFullYear();i>=startYear;i--){

                    for(var j=startMonth;j>=1;j--){

                        var rowString = "";
                        var mesString = "mensualidad (" + Toolbox.NombreMesesEsp[j] + "/" + i + ")";
                        if(mesString in pagosPorMes){

                            var rowStyle = "";
                            descuento = "";
                            if(mesString in descuentosPorMes && descuentosPorMes[mesString] != 'undefined'){
                                descuento = descuentosPorMes[mesString];
                            }

                            if(Number(descuento + pagosPorMes[mesString]) < Socio.calcularValorCuota(j,i)){
                                rowStyle = ' style="background-color:yellow;"';
                            }

                            rowString = '<tr>' +
                                '<td'+ rowStyle + '>' + Toolbox.TransformSpecialTag(mesString) + '</td>' +
                                '<td'+ rowStyle + '>' + pagosPorMes[mesString] + '</td>' +
                                '<td'+ rowStyle + '>' + descuento + '</td>' +
                                '<td'+ rowStyle + '>' + Number(descuento + pagosPorMes[mesString]) + '</td></tr>';

                        }else{
                            rowString = '<tr>' +
                                '<td style="background-color: #ca5757">' + Toolbox.TransformSpecialTag(mesString) + '</td>' +
                                '<td style="background-color: #ca5757">-</td>' +
                                '<td style="background-color: #ca5757">-</td>' +
                                '<td style="background-color: #ca5757">-</td></tr>';
                        }

                        pagosPorMesSortedData.push(rowString);
                    }

                    startMonth = 12;
                }

                for(var i=0;i<pagosPorMesSortedData.length;i++){
                    $('#listaPagosPorMesSocioTabla').append(pagosPorMesSortedData[i]);
                }

                Socio.GetHorasVoluntariado();
            }
            else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', 'Unexpected error');
                }
            }
            Toolbox.StopLoader();
        });
    },
    CambiarEstadoSocio: function () {

        var nuevoEstado;
        var confirmacion = false;
        if ($('#socioEditarEstado').val() == 'activo') {
            if (Socio.SocioData.activo == true) {
                $('#socioCambiarEstadoModal').modal('hide');
                return;
            } else {
                nuevoEstado = true;
            }
        } else if ($('#socioEditarEstado').val() == 'suspendido') {
            if (Socio.SocioData.activo != true) {
                $('#socioCambiarEstadoModal').modal('hide');
                return;
            } else {
                nuevoEstado = false;
            }
        } else if ($('#socioEditarEstado').val() == 'eliminar') {
            confirmacion = confirm('Eliminar socio permanentemente?');
        }

        if ($('#socioEditarEstado').val() == 'eliminar') {
            if (confirmacion) {
                Toolbox.ShowLoader();
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: "proc/controller.php",
                    data: {func: "eliminar_socio", id_socio: Socio.IdSocio}
                }).done(function (data) {
                    if (data && !data.error) {
                        document.location.href = GLOBAL_domain + "/index.php";
                    } else {
                        if (data && data.error) {
                            Toolbox.ShowFeedback('feedbackContainerModalCambiarEstado', 'error', data.error);
                        } else {
                            Toolbox.ShowFeedback('feedbackContainerModalCambiarEstado', 'error', 'Unexpected error');
                        }
                    }
                    Toolbox.StopLoader();
                });
            }
        } else {
            Toolbox.ShowLoader();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: {func: "update_estado_socio", id_socio: Socio.IdSocio, activo: nuevoEstado}
            }).done(function (data) {
                if (data && !data.error) {
                    Socio.LoadSocio();
                    $('#socioCambiarEstadoModal').modal('hide');
                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('feedbackContainerModalCambiarEstado', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('feedbackContainerModalCambiarEstado', 'error', 'Unexpected error');
                    }
                }
                Toolbox.StopLoader();
            });
        }
    },
    TogglePagoRazon: function () {
        if ($('#socioIngresarPagoRazon').val() == "mensualidad") {
            $('#socioIngresarPagoRazonMensualidadMes').css('display', 'block');
            $('#socioIngresarPagoRazonMensualidadParte').css('display', 'none');
            $('#socioIngresarPagoRazonMensualidadAnio').css('display', 'block');
        } else if ($('#socioIngresarPagoRazon').val() == "medioanio") {
            $('#socioIngresarPagoRazonMensualidadMes').css('display', 'none');
            $('#socioIngresarPagoRazonMensualidadAnio').css('display', 'block');
            $('#socioIngresarPagoRazonMensualidadParte').css('display', 'block');
        } else if ($('#socioIngresarPagoRazon').val() == "anio") {
            $('#socioIngresarPagoRazonMensualidadMes').css('display', 'none');
            $('#socioIngresarPagoRazonMensualidadAnio').css('display', 'block');
            $('#socioIngresarPagoRazonMensualidadParte').css('display', 'none');
        }else {
            $('#socioIngresarPagoRazonMensualidadMes').css('display', 'none');
            $('#socioIngresarPagoRazonMensualidadAnio').css('display', 'none');
            $('#socioIngresarPagoRazonMensualidadParte').css('display', 'none');
        }
    },
    GetDeudas: function () {
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_deudas_socio", id_socio: Socio.IdSocio}
        }).done(function (data) {
            if (data && !data.error) {
                $('.socioRecordatorioDeudaContainer').html('');
                for (var i = 0; i < data.length; i++) {
                    $('.socioRecordatorioDeudaContainer').append('<span class="alert alert-danger socio-deuda"><strong>$' + data[i].monto + "</strong>  " + data[i].razon +
                        '<button type="button" class="close" aria-label="Close" onclick="Socio.CancelarDeuda(\'' + data[i].id + '\');"><span aria-hidden="true">&times;</span></button></span>');
                }
            }
            Toolbox.StopLoader();
        });
    },
    OpenModalNuevaDeuda: function () {
        $('.feedbackContainerModal').css('display', 'none');
        $('#socioIngresarDeudaMonto').val('');
        $('#socioIngresarDeudaRazon').val('');
        $('#socioIngresarDeudaModal').modal("show");
    },
    IngresarDeuda: function () {
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {
                func: "ingresar_deuda", id_socio: Socio.IdSocio,
                monto: $('#socioIngresarDeudaMonto').val(),
                razon: $('#socioIngresarDeudaRazon').val()
            }
        }).done(function (data) {
            if (data && !data.error) {

                $('#socioIngresarDeudaModal').modal("hide");
                Socio.GetDeudas();

            } else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainer', 'error', 'Error al cancelar deuda.');
                }
            }
            Toolbox.StopLoader();
        });
    },
    CancelarDeuda: function (id) {
        if (confirm("Cancelar deuda?")) {
            Toolbox.ShowLoader();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: {func: "cancelar_deuda", id: id}
            }).done(function (data) {
                if (data && !data.error) {

                    Socio.GetDeudas();

                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', 'Error al cancelar deuda.');
                    }
                }
                Toolbox.StopLoader();
            });
        }
    },
    OpenSocioView: function () {
        if (!Socio.SocioData.hash) {
            Toolbox.ShowLoader();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: {func: "generar_hash", id: Socio.IdSocio}
            }).done(function (data) {
                if (data && !data.error) {

                    window.open(GLOBAL_domain + '/vista_socio.php?h=' + data,
                        '_blank'
                    );

                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', 'Error al cancelar deuda.');
                    }
                }
                Toolbox.StopLoader();
            });
        } else {
            window.open(GLOBAL_domain + '/vista_socio.php?h=' + Socio.SocioData.hash,
                '_blank'
            );
        }
    },
    GetCuotaCostos: function(){
        Toolbox.ShowLoader();

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_lista_costos"}
        }).done(function (data) {
            if (data && !data.error) {
                Socio.CuotaCostos = data;
            }

            Socio.LoadPagos();

            Toolbox.StopLoader();
        });
    },
    GetHorasVoluntariado: function(){
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_horas_socio", id_socio: Socio.IdSocio}
        }).done(function (data) {
            if (data && !data.error) {

                $('#listaHorasSocioTabla').html("");
                var balance = 0;

                for (var i = 0; i < data.length; i++) {

                    balance += Number(data[i].horas * data[i].costo);

                    $('#listaHorasSocioTabla').append('<tr><td>' + Toolbox.MysqlDateToDate(data[i].created_at) + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].rubro) + '</td>' +
                        '<td>' + data[i].horas + '</td>' +
                        '<td>' + data[i].costo + '</td>' +
                        '<td><a href="#" onclick="Socio.BorrarHorasVoluntariado(\'' + data[i].id + '\');return false;">borrar</a></td></tr>');
                }

                $('#socioDatosValorBalanceHoras').html("<p>$" + Number(balance - Socio.DescuentoBalanceHoras) + "</p>");
                Socio.BalanceHoras = balance;

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
    OpenModalIngresarHoras: function(){
        $('.feedbackContainerModal').css('display', 'none');
        $('#socioIngresarHorasFecha').val(Toolbox.GetFechaHoyLocal());
        $('#socioIngresarHorasModal').modal("show");
    },
    IngresarHoras: function(){

        Toolbox.ShowLoaderModal();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {
                func: "ingresar_horas",
                id_socio: Socio.IdSocio,
                horas: $("#socioIngresarHorasHoras").val(),
                created_at: Toolbox.DataToMysqlDate($("#socioIngresarHorasFecha").val()),
                rubro: $("#socioIngresarHorasRazon").val(),
                costo: $("#socioIngresarHorasCosto").val(),
                notas: $("#socioIngresarHorasDetalle").val()
            }
        }).done(function (data) {
            if (data && !data.error) {
                Socio.LoadPagos();
                $('#socioIngresarHorasModal').modal('hide');
            } else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainerModalIngresarHoras', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainerModalIngresarHoras', 'error', 'Error al ingresar horas');
                }
            }
            Toolbox.StopLoaderModal();
        });
    },
    BorrarHorasVoluntariado: function(id){
        if (confirm("Cancelar horas?")) {
            Toolbox.ShowLoader();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: {func: "borrar_horas", id: id}
            }).done(function (data) {
                if (data && !data.error) {

                    Socio.GetHorasVoluntariado();

                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', 'Error al borrar horas de voluntariado.');
                    }
                }
                Toolbox.StopLoader();
            });
        }
    },
    OpenModalNuevoTalonCobrosYA: function(){
        $('.feedbackContainerModal').css('display', 'none');
        //$('#socioIngresarHorasFecha').val(Toolbox.GetFechaHoyLocal());
        $('#socioNuevoTalonCobrosYAModal').modal("show");
        document.getElementById("socioNuevoTalonCobrosYABtnEnviar").disabled = false;
    },
    NuevoTalonCobrosYA: function(){
        document.getElementById("socioNuevoTalonCobrosYABtnEnviar").disabled = true;

        Toolbox.ShowLoaderModal();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {
                func: "enviar_talon_cobrosya",
                id_socio: Socio.IdSocio,
                month: $("#socioNuevoTalonCobrosYAMonth").val(),
                year: $("#socioNuevoTalonCobrosYAYear").val()
            }
        }).done(function (data) {
            if (data && !data.error) {
                Socio.GetHorasVoluntariado();
                $('#socioNuevoTalonCobrosYAModal').modal('hide');
                Toolbox.ShowFeedback('feedbackContainer', 'success', "Talon enviado con exito");
                Socio.GetFacturasPendientes();
            } else {
                if (data && data.error) {
                    Toolbox.ShowFeedback('feedbackContainerModalNuevoTalonCobrosYA', 'error', data.error);
                } else {
                    Toolbox.ShowFeedback('feedbackContainerModalNuevoTalonCobrosYA', 'error', 'Error al enviar talon de CobrosYA');
                }
            }
            Toolbox.StopLoaderModal();
            document.getElementById("socioNuevoTalonCobrosYABtnEnviar").disabled = false;
        });
    },
    GetFacturasPendientes: function(){
        Toolbox.ShowLoader();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_facturas_pendientes_cobrosya", id_socio: Socio.IdSocio}
        }).done(function (data) {
            if (data && !data.error) {

                $('#listaFacturasPendientesSocioTabla').html("");

                for (var i = 0; i < data.length; i++) {

                    $('#listaFacturasPendientesSocioTabla').append('<tr><td>' + data[i].talon + '</td>' +
                        '<td>' + data[i].monto + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag("mensualidad (" + Toolbox.NombreMesesEsp[data[i].month] + "/" + data[i].year + ")") + '</td>' +
                        '<td>15/' + data[i].month + "/" + data[i].year + '</td>' +
                        '<td><a href="' + data[i].talon_url  + '">descargar</a></td></tr>');
                }

            }
            Toolbox.StopLoader();
        });
    },
    OnChangeRazonDescuentoPago: function(){
        if($('#socioIngresarPagoRazonDescuento').val() == "Balance"){
            var aDescountar = Number(Socio.BalanceHoras - Socio.DescuentoBalanceHoras);
            if(aDescountar > Socio.CurrentCostoCuota){
                aDescountar = Socio.CurrentCostoCuota;
            }

            $('#socioIngresarPagoDescuento').val(aDescountar);
        }
    }
}

$(document).ready(function () {

    $('#socioBtnSalvar').on('click', Socio.SalvarSocio);

    Toolbox.UpdateActiveNavbar('');
    var params = Toolbox.GetUrlVars();

    if (params['new'] && params['new'] == 'true') {
        Socio.New = true;
    } else if (params['id']) {
        Socio.IdSocio = params['id'];
    }
    Socio.GetTags();

    $("#socioIngresarPagoFecha").mask("99/99/9999");
    $('#socioLabelEstado').on('click', function () {
        $('.feedbackContainerModal').css('display', 'none');
        $('#socioIngresarPagoValor').val('');
        $('#socioIngresarPagoFecha').val(Toolbox.GetFechaHoyLocal());
        $('#socioIngresarPagoTipo').val('');
        $('#socioIngresarPagoRazon').val('');
        $('#socioIngresarPagoNotas').val('');
        $('.loaderModal').css('display', 'none');
        $('#socioCambiarEstadoModal').modal({
            show: true
        });
    });
    $('#socioCambiarEstadoModalBtnCambiar').on('click', function () {
        Socio.CambiarEstadoSocio();
    });

    var today = new Date();
    $('#socioIngresarPagoRazonMensualidadAnio').val(today.getFullYear());
    $('#socioIngresarPagoRazonMensualidadMes').val(Toolbox.NombreMesesEsp[today.getMonth()+1]);

    $('#socioIngresarHorasModalBtnIngresar').on('click', Socio.IngresarHoras);
    $("#socioIngresarHorasFecha").mask("99/99/9999");
    $('#socioIngresarHorasFecha').val(Toolbox.GetFechaHoyLocal());

    $('#socioNuevoTalonCobrosYAMonth').val(today.getMonth()+1);
    $('#socioNuevoTalonCobrosYAYear').val(today.getFullYear());

    Socio.GetCuotaCostos();
    //Socio.GetDeudas();
    //Socio.GetFacturasPendientes();
});
