<?php

require_once(dirname(__FILE__) . '/layout.php');
require_once(dirname(__FILE__) . '/proc/classes/auth.php');

if (Auth::access_level() < 0) {
    ?>
    <script type="text/javascript">
        Toolbox.GoToLogin();
    </script>
<?php } else { ?>

    <head>
        <script src="scripts1.0/socio.js"></script>
    </head>

    <body>
    <div class="container">
        <div class="socioHeader">
            <h2 id="socioNombreTitulo"></h2>
            <span id="socioLabelEstado" class="badge"></span>

            <div id=feedbackContainer></div>
        </div>

        <div class="box">
            <table class="form_table">
            <tr class="row_empresa">
                <td><div style="display:none;" id="socioDatosFieldNombre" class="socioDatosField">
                        <h4>Empresa</h4>

                        <div id="socioDatosValorNombre" class="socioDatosValor"></div>
                    </div></td>
                <td></td>
            </tr>
                <tr>
                    <td><div class="socioDatosField">
                            <h4>N&uacute;mero de socio</h4>

                            <div id="socioDatosValorNumero" class="socioDatosValor"></div>
                        </div></td>
                    <td><div class="span6">
                            <div class="socioDatosField">
                                <h4>Fecha Asociación</h4>

                                <div id="socioDatosValorFechaInicio" class="socioDatosValor"></div>
                            </div></td>
                </tr>
                <tr>
                    <td><div class="socioDatosField">
                            <h4>RUT</h4>

                            <div id="socioDatosValorDocumento" class="socioDatosValor"></div>
                        </div></td>
                    <td><div class="socioDatosField">
                            <h4>Balance de cuenta</h4>

                            <div id="socioDatosValorBalanceHoras" class="socioDatosValor"></div>
                        </div></td>
                </tr>
                <tr>
                    <td><div class="socioDatosField">
                            <h4>Email</h4>

                            <div id="socioDatosValorEmail" class="socioDatosValor"></div>
                        </div></td>
                    <td><div class="socioDatosField">
                            <h4>Dirección</h4>

                            <div id="socioDatosValorDireccion" class="socioDatosValor"></div>
                        </div></td>
                </tr>
                <tr>
                    <td><div class="socioDatosField">
                            <h4>Fecha Fundación</h4>

                            <div id="socioDatosValorFechaNacimiento" class="socioDatosValor"></div>
                        </div></td>
                    <td><div class="socioDatosField">
                            <h4>Observaciones</h4>

                            <div id="socioDatosValorObservaciones" class="socioDatosValor"></div>
                        </div></td>
                </tr>
                <tr>
                    <td><div class="socioDatosField">
                            <h4>Tel&eacute;fono</h4>

                            <div id="socioDatosValorTelefono" class="socioDatosValor"></div>
                        </div></td>
                    <td><div class="socioDatosField">
                            <h4>Tags</h4>

                            <div id="socioDatosValorTags" class="socioDatosValor"></div>
                        </div></td>
                </tr>
                <tr>
                    <td><div class="socioDatosField">
                            <h4>Tamaño</h4>

                            <div id="socioDatosValorTamanio" class="socioDatosValor"></div>
                        </div></td>
                    <td></td>
                </tr>
            </table>
            <div style="display:none;" class="span12" id="socioBtnSalvarContainer">
                <div class="btn btn-primary" id="socioBtnSalvar">Salvar</div>
            </div>
        </div>

<!--        Pagos-->
        <h3 id="socioPagoseTitulo">Pagos</h3>

        <div class="botoneraTopContainer">
            <div class="btn btn-success" title="Ingresar nuevo pago" onclick="Socio.OpenModalNuevoPago();">Agregar
                Pago
            </div>
            <div class="btn btn-danger" title="Nuevo recordatorio de deuda" onclick="Socio.OpenModalNuevaDeuda();">
                Agregar Deuda
            </div>
            <div class="btn" style="
background: #ff670f; /* Old browsers */
    color: #fff;" title="Nuevo talón CobrosYA" onclick="Socio.OpenModalNuevoTalonCobrosYA();">
                Nuevo talón CobrosYA
            </div>
        </div>

        <!-- Recordatorio Deuda -->
        <div class="socioRecordatorioDeudaContainer"></div>

        <div class="box row-fluid">
            <div class="span12 socioListaContenedor">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor $</th>
                        <th>Fecha Pago</th>
                        <th>Raz&oacute;n</th>
                        <th>Descuento $</th>
                        <th>Notas</th>
                        <th>Modo</th>
                    </tr>
                    </thead>
                    <tbody id="listaPagosSocioTabla"></tbody>
                </table>
            </div>
        </div>

        <!--        Facturas pendientes-->
        <h3 id="socioPagoseTitulo">Pagos Pendientes</h3>

        <div class="box row-fluid">
            <div class="span12 socioListaContenedor">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Monto $</th>
                        <th>Detalle</th>
                        <th>Fecha Vencimiento</th>
                        <th>Descargar Factura</th>
                    </tr>
                    </thead>
                    <tbody id="listaFacturasPendientesSocioTabla"></tbody>
                </table>
            </div>
        </div>

        <!--Pagos por mes-->
<!--        <h3 class="socioPagoseTitulo">Pagos ordenados por mes</h3>-->
<!---->
<!--        <div class="box row-fluid">-->
<!--            <div class="span12 socioListaContenedor">-->
<!--                <table class="table table-hover table-striped">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th>Mes</th>-->
<!--                        <th>Total Pago $</th>-->
<!--                        <th>Total Descuento $</th>-->
<!--                        <th>Total Mes $</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody id="listaPagosPorMesSocioTabla"></tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->


    <!--Horas-->
    <h3 id="socioEntregasTitulo">Trabajo por descuento</h3>

        <div class="botoneraTopContainer">
            <div class="btn btn-success" title="Ingresar horas de trabajo" onclick="Socio.OpenModalIngresarHoras();">Agregar
                Horas
            </div>
        </div>

    <div class="box row-fluid">
        <div class="span12 socioListaContenedor">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Rubro</th>
                    <th>Horas</th>
                    <th>Costo/Hora ($)</th>
                    <th>Borrar</th>
                </tr>
                </thead>
                <tbody id="listaHorasSocioTabla"></tbody>
            </table>
        </div>
    </div>

    </div>

    <!-- Modal nuevo talon CobrosYA -->
    <div id="socioNuevoTalonCobrosYAModal" class="modal hide fade" tabindex="-1" role="dialog"
         aria-labelledby="socioNuevoTalonCobrosYAModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="socioNuevoTalonCobrosYAModalLabel">Nuevo talon CobrosYA</h3>
        </div>
        <div class="modal-body">
            <div id="feedbackContainerModalNuevoTalonCobrosYA" class="feedbackContainerModal"></div>
            <div class="modalListaRow">
                <h4>Mes</h4>
                <select id="socioNuevoTalonCobrosYAMonth">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
            <div class="modalListaRow">
                <h4>A&ntilde;o</h4>
                <select id="socioNuevoTalonCobrosYAYear">
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <img src="images/loaderModal.gif" class="loaderModal">
            <button id="socioNuevoTalonCobrosYABtnEnviar" class="btn btn-primary" onclick="Socio.NuevoTalonCobrosYA();">Enviar</button>
        </div>
    </div>

    <div id="socioIngresarHorasModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar horas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="feedbackContainerModalIngresarHoras" class="feedbackContainerModal"></div>
                    <div class="modalListaRow">
                        <h4>Rubro</h4>
                        <select id="socioIngresarHorasRazon">
                            <option value="Administracion">Administración</option>
                            <option value="Comunicacion">Comunicación</option>
                            <option value="Soporte">Soporte</option>
                            <option value="Eventos">Eventos</option>
                            <option value="Relaciones Publicas">Relaciones Publicas</option>
                        </select>
                    </div>
                    <div class="modalListaRow">
                        <div>
                            <h4>Detalle</h4>
                            <input type="text" placeholder="" id="socioIngresarHorasDetalle" style="width:230px;">
                        </div>
                    </div>
                    <div class="modalListaRow">
                        <div>
                            <h4>Fecha</h4>
                            <input type="text" placeholder="" id="socioIngresarHorasFecha" style="width:130px;">
                        </div>
                    </div>
                    <div class="modalListaRow">
                        <h4>Horas</h4>
                        <input style="width: 110px;" type="text" placeholder="0.0" id="socioIngresarHorasHoras">
                    </div>
                    <div class="modalListaRow">
                        <h4>Costo/Hora</h4>
                        <input style="width: 110px;" type="text" placeholder="0.0" id="socioIngresarHorasCosto">
                    </div>
                </div>
                <div class="modal-footer">
                    <img src="images/loaderModal.gif" class="loaderModal">
                    <button type="button" class="btn btn-primary" onclick="Socio.IngresarHoras()">Ingresar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ingresar pago -->
    <div id="socioIngresarPagoModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="feedbackContainerModalIngresarPago" class="feedbackContainerModal"></div>
                    <div class="modalListaRow">
                        <h4>Raz&oacute;n</h4>
                        <select id="socioIngresarPagoRazon" onchange="Socio.TogglePagoRazon();">
                            <option value="medioanio">Semestre</option>
                            <option value="anio">Año</option>
                            <option value="mensualidad">Mensualidad</option>
                        </select>
                        <select id="socioIngresarPagoRazonMensualidadMes" style="display: none;">
                            <option value="Enero">Enero</option>
                            <option value="Febrero">Febrero</option>
                            <option value="Marzo">Marzo</option>
                            <option value="Abril">Abril</option>
                            <option value="Mayo">Mayo</option>
                            <option value="Junio">Junio</option>
                            <option value="Julio">Julio</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Setiembre">Setiembre</option>
                            <option value="Octubre">Octubre</option>
                            <option value="Noviembre">Noviembre</option>
                            <option value="Diciembre">Diciembre</option>
                        </select>
                        <select id="socioIngresarPagoRazonMensualidadParte">
                            <option value="primer">Primer semestre</option>
                            <option value="segundo">Segundo semestre</option>
                        </select>
                        <select id="socioIngresarPagoRazonMensualidadAnio">
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
                    </div>
                    <div class="modalListaRow rowFechaNuevoPago">
                        <div class="caja">
                            <h4>Fecha</h4>
                            <input type="text" placeholder="" id="socioIngresarPagoFecha" style="margin-left: 43px;width:130px;">
                        </div>
                        <div class="caja">
                            <h4>Via</h4>
                            <select style="margin-top: 7px;" id="socioIngresarPagoTipo" placeholder="01/12/2013">
                                <option value="">Sin especificar</option>
                                <option value="transferencia_brou">Transferencia BROU</option>
                                <option value="personalmente">Personalmente</option>
                                <option value="otra">Otra</option>
                            </select>
                        </div>
                    </div>
                    <div class="modalListaRow" style="width: 100%;">
                        <h4>Monto $</h4>
                        <input style="width: 110px;" type="text" placeholder="0.00" id="socioIngresarPagoValor" onchange="Socio.OnChangeMonto();">
                    </div>
                    <div class="modalListaRow rowFechaNuevoPago">
                        <div class="caja">
                            <h4>Descuento $</h4>
                            <input type="text" placeholder="0.00" id="socioIngresarPagoDescuento" style="margin-left: 23px;width:100px;">
                        </div>
                        <div class="caja">
                            <h4>Raz&oacute;n desc.</h4>
                            <select style="margin: 0 0 0 20px;margin-top: 7px;" id="socioIngresarPagoRazonDescuento" onchange="Socio.OnChangeRazonDescuentoPago();">
                                <option value="">Sin especificar</option>
                                <option value="Resolucion directiva">Resoluci&oacute;n directiva</option>
                                <option value="Balance">Balance</option>
                            </select>
                        </div>
                    </div>
                    <div class="modalListaRow">
                        <h4>Notas</h4>
                        <textarea style="width: 400px; height: 50px; max-width: 400px;"
                                  id="socioIngresarPagoNotas"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <img src="images/loaderModal.gif" class="loaderModal">
                    <button type="button" class="btn btn-primary" onclick="Socio.IngresarPago();">Ingresar pago</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ingresar deuda -->
    <div id="socioIngresarDeudaModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar Deuda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="feedbacksocioIngresarDeudaModal" class="feedbackContainerModal"></div>
                    <div class="modalListaRow">
                        <h4>Monto $</h4>
                        <input style="width: 110px;" type="text" placeholder="0.00" id="socioIngresarDeudaMonto">
                    </div>
                    <div class="modalListaRow">
                        <h4>Raz&oacute;n</h4>
                        <textarea id="socioIngresarDeudaRazon"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <img src="images/loaderModal.gif" class="loaderModal">
                    <button type="button" class="btn btn-primary" onclick="Socio.IngresarDeuda();">Ingresar deuda</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambiar estado -->
    <div id="socioCambiarEstadoModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar estado de socio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="feedbackContainerModalCambiarEstado" class="feedbackContainerModal"></div>
                    <div class="modalListaRow">
                        <h4>Estado</h4>
                        <select id="socioEditarEstado">
                            <option value="activo">Activo</option>
                            <option value="suspendido">Suspendido</option>
                            <option value="eliminar">Eliminar Socio</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <img src="images/loaderModal.gif" class="loaderModal">
                    <button type="button" class="btn btn-primary" onclick="Socio.CambiarEstadoSocio();">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    </body>

<?php }

require_once(dirname(__FILE__) . '/footer.php');

?>
