/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

var ListaPagos = {
    ListaSocios: {},
    LoadSocios: function () {
        Toolbox.ShowLoader();

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_lista_socios"}
        }).done(function (data) {
            if (data && !data.error) {

                ListaPagos.ListaSocios = {};
                for (var i = 0; i < data.length; i++) {
                    ListaPagos.ListaSocios[data[i].id] = data[i];
                }

                ListaPagos.LoadListaPagos();
                ListaPagos.LoadListaDeudas();
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
    LoadListaPagos: function () {

        Toolbox.ShowLoader();

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_lista_pagos"}
        }).done(function (data) {
            if (data && !data.error) {
                $('#listaPagosTabla').html("");

                for (var i = 0; i < data.length; i++) {

                    if(data[i].id_socio == 0) {
                    continue;
                    }

                    var tagCancelado = "";
                    if (data[i].cancelado == true) {
                        tagCancelado = '<span class="label labelCancelado">PAGO CANCELADO</span> ';
                    }

                    var descuento = "";
                    if(data[i].descuento != "" && data[i].descuento != "0.00"){
                        descuento = data[i].descuento + ' ' + Toolbox.TransformSpecialTag(data[i].descuento_json)
                    }

                    $('#listaPagosTabla').append('<tr onClick="document.location.href = \'/pago.php?id=' + data[i].id + '\'"><td>' + data[i].id + '</td>' +
                        '<td>' + data[i].valor + '</td>' +
                        '<td>' + Toolbox.MysqlDateToDate(data[i].fecha_pago) + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].razon) + '</td>' +
                        '<td>' + descuento + '</td>' +
                        '<td>' + tagCancelado + data[i].notas + '</td>' +
                        '<td>' + Toolbox.TransformSpecialTag(data[i].tipo) + '</td>' +
                        '<td><a href="/socio.php?id=' + data[i].id_socio + '" class="label" style="background-color:#AF002A;">#' + ListaPagos.ListaSocios[data[i].id_socio].numero + ' ' + ListaPagos.ListaSocios[data[i].id_socio].nombre + '</a></td></tr>');

                }

                //lista meses inpagos
                var inpagosData = [];
                var fromYear = 2018;
                var today = new Date();

                        for (var year = fromYear; year <= today.getFullYear(); year++) {
                            for (var month = 1; month <= 12; month++) {

                                Object.keys(ListaPagos.ListaSocios).forEach(function(key) {

                                    if(ListaPagos.ListaSocios[key].activo == "1") {

                                if (year == today.getFullYear() && month > today.getMonth() + 1) {

                                } else {
                                    var foundPayment = false;

                                    for (var i = 0; i < data.length; i++) {
                                        if (data[i].razon == "mensualidad (" + Toolbox.NombreMesesEsp[month] + "/" + year + ")" &&
                                            data[i].id_socio == key) {
                                            foundPayment = true;
                                        }
                                    }

                                    if (!foundPayment) {
                                        inpagosData.push({
                                            nombre: '<a href="' + GLOBAL_domain + '/socio.php?id=' + ListaPagos.ListaSocios[key].id + '" class="badge badge-primary">#' + ListaPagos.ListaSocios[key].numero + ' ' + ListaPagos.ListaSocios[key].nombre + '</a>',
                                            mes: Toolbox.NombreMesesEsp[month] + "/" + year
                                        })
                                    }
                                }
                            }
                                });
                        }
                    }

                // $('#listaMesesInpagosTabla').html("");
                // for (var i = 0; i < inpagosData.length; i++) {
                //     $('#listaMesesInpagosTabla').append('<tr><td>' + inpagosData[i].mes + '</td>' +
                //         '<td>' + inpagosData[i].nombre + '</td></tr>');
                // }

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
    ExportarComoListaPagosPorSocio: function () {
        $("#exportIframe").attr("src", "proc/controller.php?exportar=exportar_pagos_por_socio");
    },
    ExportarComoListaTotalPagoPorSocio: function () {
        $("#exportIframe").attr("src", "proc/controller.php?exportar=exportar_pago_total_por_socio");
    },
    ExportarComoListaPagosPorMes: function () {
        $("#exportIframe").attr("src", "proc/controller.php?exportar=exportar_pagos_por_mes");
    },
    ExportarDeudas: function () {
        $("#exportIframe").attr("src", "proc/controller.php?exportar=exportar_deudas");
    },
    ExportarDescuentosPorSocio: function () {
        $("#exportIframe").attr("src", "proc/controller.php?exportar=exportar_descuentos_por_socio");
    },
    LoadListaDeudas: function () {
        Toolbox.ShowLoader();

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_all_deudas"}
        }).done(function (data) {
            if (data && !data.error) {
                $('#listaDeudasTabla').html("");
                for (var i = 0; i < data.length; i++) {

                    $('#listaDeudasTabla').append('<tr>' +
                        '<td>' + data[i].monto + '</td>' +
                        '<td>' + data[i].razon + '</td>' +
                        '<td><a href="/socio.php?id=' + data[i].id_socio + '" class="badge badge-danger">#' + ListaPagos.ListaSocios[data[i].id_socio].numero + ' ' + ListaPagos.ListaSocios[data[i].id_socio].nombre + '</a></td>' +
                        '<td><a href="#" onclick="ListaPagos.CancelarDeuda(\'' + data[i].id + '\');return false;">cancelar</a></td></tr>');
                }
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

                    ListaPagos.LoadListaDeudas();

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
    VerificarNuevaCuotaCosto: function () {
        var error = undefined;

        if (!error && $('.nuevaCuotaCosto_fecha_fin').val() == '') {
            error = 'Falt&oacute; especificar el valor del pago';
        } else if (!error && $('.nuevaCuotaCosto_fecha_inicio').val() == '') {
            error = 'Falto especificar fecha de pago';
        } else if (!error && isNaN($('.nuevaCuotaCosto_valor').val())) {
            error = 'Valor invalido';
        }

        if (error == undefined) {
            Toolbox.ShowFeedback('nuevaCuotaCostoModalFeedback', '', '');
        }
        else {
            Toolbox.ShowFeedback('nuevaCuotaCostoModalFeedback', 'error', error);
        }

        return error == undefined;
    },
    SalvarCostoCuota: function () {
        if (ListaPagos.VerificarNuevaCuotaCosto()) {
            Toolbox.ShowLoaderModal();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: {
                    func: "ingresar_costo",
                    fecha_inicio: Toolbox.DataToMysqlDate($('.nuevaCuotaCosto_fecha_inicio').val()),
                    fecha_fin: Toolbox.DataToMysqlDate($('.nuevaCuotaCosto_fecha_fin').val()),
                    valor: $(".nuevaCuotaCosto_valor").val(),
                    descuento_anio: $(".nuevaCuotaCosto_descuento_anio").val(),
                    tiers_discounts: $(".nuevaCuotaCosto_tiers_discounts").val()
                }
            }).done(function (data) {
                if (data && !data.error) {
                    ListaPagos.GetCuotaCostos();
                    $('#nuevaCuotaCostoModal').modal('hide');
                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('nuevaCuotaCostoModalFeedback', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('nuevaCuotaCostoModalFeedback', 'error', 'Error al ingresar registro.');
                    }
                }
                Toolbox.StopLoaderModal();
            });
        }
    }
    ,
    OpenModalNuevoCostoCuota: function () {
        $('#nuevaCuotaCostoModal').modal('show');
    }
    ,
    BorrarCuotaCosto: function (id) {
        if (confirm("Eliminar registro de costo de cuota?")) {
            Toolbox.ShowLoader();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: "proc/controller.php",
                data: {func: "borrar_costo", id: id}
            }).done(function (data) {
                if (data && !data.error) {

                    ListaPagos.GetCuotaCostos();

                } else {
                    if (data && data.error) {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', data.error);
                    } else {
                        Toolbox.ShowFeedback('feedbackContainer', 'error', 'Error al eliminar registro de costo de cuota.');
                    }
                }
                Toolbox.StopLoader();
            });
        }
    }
    ,
    GetCuotaCostos: function () {
        Toolbox.ShowLoader();

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: {func: "get_lista_costos"}
        }).done(function (data) {
            if (data && !data.error) {
                $('#listaCostoCuotasTabla').html("");
                for (var i = 0; i < data.length; i++) {

                    $('#listaCostoCuotasTabla').append('<tr>' +
                        '<td>' + data[i].valor + '</td>' +
                        '<td>' + data[i].fecha_inicio + '</td>' +
                        '<td>' + data[i].fecha_fin + '</td>' +
                        '<td><a href="#" onclick="ListaPagos.BorrarCuotaCosto(\'' + data[i].id + '\');return false;">borrar</a></td></tr>');
                }
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
}

$(document).ready(function () {

    Toolbox.UpdateActiveNavbar('nav_lista_pagos');
    $(".macropago_fecha").mask("99/99/9999");
    $(".nuevaCuotaCosto_fecha_inicio").mask("99/99/9999");
    $(".nuevaCuotaCosto_fecha_fin").mask("99/99/9999");
    ListaPagos.LoadSocios();
    ListaPagos.GetCuotaCostos();

});
