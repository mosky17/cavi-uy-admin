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
        <script src="scripts1.0.12/socio.js"></script>
    </head>

    <body>
    <div class="container">
        <div class="socioHeader">
            <h2 id="socioNombreTitulo"></h2>
            <span id="socioLabelEstado" class="label"></span>

            <div id=feedbackContainer></div>
        </div>

        <div class="box row-fluid">
            <div class="span6">

                <div style="display:none;" id="socioDatosFieldNombre" class="socioDatosField">
                    <h4>Nombre</h4>

                    <div id="socioDatosValorNombre" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>N&uacute;mero</h4>

                    <div id="socioDatosValorNumero" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>Documento</h4>

                    <div id="socioDatosValorDocumento" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>Email</h4>

                    <div id="socioDatosValorEmail" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>Fecha Nacimiento</h4>

                    <div id="socioDatosValorFechaNacimiento" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>Tel&eacute;fono</h4>

                    <div id="socioDatosValorTelefono" class="socioDatosValor"></div>
                </div>

            </div>
            <div class="span6">
                <div class="socioDatosField">
                    <h4>Fecha Inicio</h4>

                    <div id="socioDatosValorFechaInicio" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>Tags</h4>

                    <div id="socioDatosValorTags" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>Balance de Horas</h4>

                    <div id="socioDatosValorBalanceHoras" class="socioDatosValor"></div>
                </div>
                <div class="socioDatosField">
                    <h4>Observaciones</h4>

                    <div id="socioDatosValorObservaciones" class="socioDatosValor"></div>
                </div>
            </div>
            <div style="display:none;" class="span12" id="socioBtnSalvarContainer">
                <div class="btn btn-primary" id="socioBtnSalvar">Salvar</div>
            </div>
        </div>

        <!--Facturas pendientes-->
<!--        <h3 id="socioPagoseTitulo">Facturas Pendientes</h3>-->
<!---->
<!--        <div class="box row-fluid">-->
<!--            <div class="span12 socioListaContenedor">-->
<!--                <table class="table table-hover table-striped">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th>#</th>-->
<!--                        <th>Monto $</th>-->
<!--                        <th>Detalle</th>-->
<!--                        <th>Fecha Vencimiento</th>-->
<!--                        <th>Descargar Factura</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody id="listaFacturasPendientesSocioTabla"></tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->

        <!--Pagos-->
        <h3 id="socioPagoseTitulo">&Uacute;ltimos Pagos</h3>

        <div class="botoneraTopContainer">
            <div class="btn btn-success" title="Ingresar nuevo pago" onclick="Socio.OpenModalNuevoPago();">Agregar
                Pago
            </div>
            <div class="btn btn-danger" title="Nuevo recordatorio de deuda" onclick="Socio.OpenModalNuevaDeuda();">
                Agregar Deuda
            </div>
<!--            <div class="btn" style="-->
<!--            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ff670f+0,d8610d+100 */-->
<!--background: #ff670f; /* Old browsers */-->
<!--background: -moz-linear-gradient(top, #ff670f 0%, #d8610d 100%); /* FF3.6-15 */-->
<!--background: -webkit-linear-gradient(top, #ff670f 0%,#d8610d 100%); /* Chrome10-25,Safari5.1-6 */-->
<!--background: linear-gradient(to bottom, #ff670f 0%,#d8610d 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */-->
<!--filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff670f', endColorstr='#d8610d',GradientType=0 ); /* IE6-9 */-->
<!--    color: #fff;-->
<!--    border: 1px solid #ff670f;-->
<!--    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.75);-->
<!--            " title="Nuevo talon CobrosYA" onclick="Socio.OpenModalNuevoTalonCobrosYA();">-->
<!--                Nuevo talon CobrosYA-->
<!--            </div>-->
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
                        <th>Tipo</th>
                    </tr>
                    </thead>
                    <tbody id="listaPagosSocioTabla"></tbody>
                </table>
            </div>
        </div>

        <!--Pagos por mes-->
        <h3 class="socioPagoseTitulo">Pagos por Mes</h3>

        <div class="box row-fluid">
            <div class="span12 socioListaContenedor">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Total Pago $</th>
                        <th>Total Descuento $</th>
                        <th>Total Mes $</th>
                    </tr>
                    </thead>
                    <tbody id="listaPagosPorMesSocioTabla"></tbody>
                </table>
            </div>
        </div>

        <!--Entregas-->
        <h3 id="socioEntregasTitulo">Entregas <i id="socioBtnNuevaEntrega" class="icon-plus-sign-alt socioIconBtnTitle"
                                                 title="Registrar nueva entrega"
                                                 onclick="Socio.OpenModalNuevaEntrega();"></i></h3>

        <div class="box row-fluid">
            <div class="span12 socioListaContenedor">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Peso (gr)</th>
                        <th>Fecha Entregado</th>
<!--                        <th>Variedad</th>-->
                        <th>Notas</th>
                        <th>Borrar</th>
                    </tr>
                    </thead>
                    <tbody id="listaEntregasSocioTabla"></tbody>
                </table>
            </div>
        </div>

    <!--Horas-->
    <h3 id="socioEntregasTitulo">Horas Voluntariado</h3>

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
    <div class="botoneraBottomContainer">
        <div class="btn btn-success" title="Ingresar horas de coluntariado" onclick="Socio.OpenModalIngresarHoras();">Agregar
            Horas
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

    <!-- Modal ingresar horas -->
    <div id="socioIngresarHorasModal" class="modal hide fade" tabindex="-1" role="dialog"
         aria-labelledby="socioIngresarHorasModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="socioIngresarHorasModalLabel">Ingresar Horas</h3>
        </div>
        <div class="modal-body">
            <div id="feedbackContainerModalIngresarHoras" class="feedbackContainerModal"></div>
            <div class="modalListaRow">
                <h4>Rubro</h4>
                <select id="socioIngresarHorasRubro">
                    <option value="Manicura">Manicura</option>
                    <option value="Reparto">Reparto</option>
                    <option value="Embolsado">Embolsado</option>
                    <option value="Administracion">Administraci&oacute;n</option>
                    <option value="Edilicio">Edilicio</option>
                    <option value="Otro">Otro</option>
                </select>
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
                <select id="socioIngresarHorasCosto">
                    <option value="225">$225</option>
                    <option value="200">$200</option>
                    <option value="175">$175</option>
                    <option value="100">$100</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <img src="images/loaderModal.gif" class="loaderModal">
            <button id="socioIngresarHorasModalBtnIngresar" class="btn btn-primary">Ingresar</button>
        </div>
    </div>

    <!-- Modal ingresar pago -->
    <div id="socioIngresarPagoModal" class="modal hide fade" tabindex="-1" role="dialog"
         aria-labelledby="socioIngresarPagoModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="socioIngresarPagoModalLabel">Ingresar Pago</h3>
        </div>
        <div class="modal-body">
            <div id="feedbackContainerModalIngresarPago" class="feedbackContainerModal"></div>
            <div class="modalListaRow rowNuevoPagoRazon">
                <h4>Raz&oacute;n</h4>
                <select id="socioIngresarPagoRazon" onchange="Socio.TogglePagoRazon();">
                    <option value="mensualidad">Mensualidad</option>
                    <option value="matricula">Matr&iacute;cula</option>
                </select>
                <select id="socioIngresarPagoRazonMensualidadMes">
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
                    <select style="" id="socioIngresarPagoTipo" placeholder="01/12/2013">
                        <option value="transferencia_brou">Transferencia BROU</option>
                        <option value="personalmente">Personalmente</option>
                        <option value="otra">Otra</option>
                    </select>
                </div>
            </div>
            <div class="modalListaRow">
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
                    <select style="margin: 0 0 0 10px;" id="socioIngresarPagoRazonDescuento" onchange="Socio.OnChangeRazonDescuentoPago();">
                        <option value="Voluntariado">Voluntariado</option>
                        <option value="Resolucion directiva">Resoluci&oacute;n directiva</option>
                        <option value="BalanceVoluntariado">Balance Voluntariado</option>
                        <option value="Otra">Otra</option>
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
            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            <button id="socioIngresarPagoModalBtnIngresar" class="btn btn-primary">Ingresar</button>
        </div>
    </div>

    <!-- Modal ingresar deuda -->
    <div id="socioIngresarDeudaModal" class="modal hide fade" tabindex="-1" role="dialog"
         aria-labelledby="socioIngresarDeudaModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="socioIngresarDeudaModalLabel">Ingresar Deuda</h3>
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
            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            <button class="btn btn-primary" onclick="Socio.IngresarDeuda();">Ingresar</button>
        </div>
    </div>

    <!-- Modal cambiar estado -->
    <div id="socioCambiarEstadoModal" class="modal hide fade" tabindex="-1" role="dialog"
         aria-labelledby="socioCambiarEstadoModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="socioCambiarEstadoModalLabel">Editar Estado de Socio</h3>
        </div>
        <div class="modal-body">
            <div id="feedbackContainerModalCambiarEstado" class="feedbackContainerModal"></div>
            <div class="modalListaRow">
                <h4>Nuevo Estado</h4>
                <select id="socioEditarEstado">
                    <option value="activo">Activo</option>
                    <option value="suspendido">Suspendido</option>
                    <option value="eliminar">Eliminar Socio</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <img src="images/loaderModal.gif" class="loaderModal">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            <button id="socioCambiarEstadoModalBtnCambiar" class="btn btn-primary">Cambiar</button>
        </div>
    </div>

    <!-- Modal ingresar entrega -->
    <div id="socioIngresarEntregaModal" class="modal hide fade" tabindex="-1" role="dialog"
         aria-labelledby="socioIngresarEntregaModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="socioIngresarEntregaModalLabel">Ingresar Pago</h3>
        </div>
        <div class="modal-body">
            <div id="socioIngresarEntregaModalFeedback" class="feedbackContainerModal"></div>
            <div class="modalListaRow">
                <h4>Gramos</h4>
                <input type="text" placeholder="0.00" id="socioIngresarEntregaGramos">
            </div>
            <div class="modalListaRow">
                <h4>Fecha</h4>
                <input type="text" placeholder="" id="socioIngresarEntregaFecha">
            </div>
            <div class="modalListaRow">
                <h4>Variedad</h4>
                <select id="socioIngresarEntregaVariedad"></select>
            </div>
            <div class="modalListaRow">
                <h4>Notas</h4>
                <textarea style="width: 400px; height: 100px; max-width: 400px; max-height: 100px;"
                          id="socioIngresarEntregaNotas"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <img src="images/loaderModal.gif" class="loaderModal">
            <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            <button id="socioIngresarEntrega" class="btn btn-primary" onclick="Socio.IngresarEntrega();">Ingresar
            </button>
        </div>
    </div>

    </body>

<?php }

require_once(dirname(__FILE__) . '/footer.php');

?>
