<?php
/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

require_once(dirname(__FILE__) . '/layout.php');
require_once(dirname(__FILE__) . '/proc/classes/auth.php');

if (Auth::access_level() < 0) {
    ?>
    <script type="text/javascript">
        Toolbox.GoToLogin();
    </script>
<?php } else { ?>

    <head>
        <script src="scripts1.0/lista_pagos.js"></script>
    </head>

    <body>
    <div class="container">

        <div id=feedbackContainer></div>

        <h2>Costos</h2>
        <div class="controlesLista">
            <div class="btn btn-primary" onclick="ListaPagos.OpenModalNuevoCostoCuota();">Nuevo registro</div>
        </div>
        <div class="box">
            <div class="socioListaContenedor">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Valor $</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Borrar registro</th>
                    </tr>
                    </thead>
                    <tbody id="listaCostoCuotasTabla"></tbody>
                </table>
            </div>
        </div>

<!--        <h2>Lista de Pagos</h2>-->
<!--        <div class="controlesLista">-->
<!--            <div class="btn btn-primary" onclick="ListaPagos.OpenModalMacroPago();">Macro Pago</div>-->
<!--            <div id="exportarListaDropdown" class="btn-group">-->
<!--                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">-->
<!--                    Exportar-->
<!--                    <span class="caret"></span>-->
<!--                </a>-->
<!--                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">-->
<!--                    <li><a tabindex="-1" href="#" onClick="ListaPagos.ExportarComoListaPagosPorSocio();">Como lista de pagos-->
<!--                            por socio</a></li>-->
<!--                    <li><a tabindex="0" href="#" onClick="ListaPagos.ExportarComoListaTotalPagoPorSocio();">Como total pago por socio</a></li>-->
<!--                    <li><a tabindex="1" href="#" onClick="ListaPagos.ExportarComoListaPagosPorMes();">Como lista de pagos-->
<!--                            por mes</a></li>-->
<!--                    <li><a tabindex="2" href="#" onClick="ListaPagos.ExportarDeudas();">Deudas</a></li>-->
<!--                    <li><a tabindex="3" href="#" onClick="ListaPagos.ExportarDescuentosPorSocio();">Descuentos por socio</a></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div id=feedbackContainer></div>-->
<!--        <div class="box">-->
<!--            <div class="socioListaContenedor">-->
<!--                <table class="table table-hover">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th>#</th>-->
<!--                        <th>Valor $</th>-->
<!--                        <th>Fecha Pago</th>-->
<!--                        <th>Raz&oacute;n</th>-->
<!--                        <th>Descuento</th>-->
<!--                        <th>Notas</th>-->
<!--                        <th>Tipo</th>-->
<!--                        <th>Socio</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody id="listaPagosTabla"></tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->


        <h2>Lista de Deudas</h2>
        <div class="box">
            <div class="socioListaContenedor">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Monto $</th>
                        <th>Raz&oacute;n</th>
                        <th>Socio</th>
                        <th>Cancelar</th>
                    </tr>
                    </thead>
                    <tbody id="listaDeudasTabla"></tbody>
                </table>
            </div>
        </div>

<!--        <h2>Meses Inpagos</h2>-->
<!--        <div class="box">-->
<!--            <div class="socioListaContenedor">-->
<!--                <table class="table table-hover">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th>Mes</th>-->
<!--                        <th>Socio</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody id="listaMesesInpagosTabla"></tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->

    </div>

    <!-- Modal cuota costo -->
    <div id="nuevaCuotaCostoModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo registro de costo de cuota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="nuevaCuotaCostoModalFeedback" class="feedbackContainerModal"></div>
                    <table class="macroTabla">
                        <tr>
                            <td class="fieldname">Valor base</td>
                            <td>
                                <input type="text" class="nuevaCuotaCosto_valor" placeholder="0.00">
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldname">Fecha desde</td>
                            <td><input type="text" class="nuevaCuotaCosto_fecha_inicio" placeholder="01/01/2015"></td>
                        </tr>
                        <tr>
                            <td class="fieldname">Fecha hasta</td>
                            <td><input type="text" class="nuevaCuotaCosto_fecha_fin" placeholder="01/01/2015"></td>
                        </tr>
                        <tr>
                            <td class="fieldname">Descuento pago anual</td>
                            <td><select class="nuevaCuotaCosto_descuento_anio">
                                    <option value="1_mes">1 mes de descuento</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="fieldname">Descuentos por tamaño</td>
                            <td><select class="nuevaCuotaCosto_tiers_discounts">
                                    <option value="3">1/3 cuota 9 o menos, 2/3 19 o menos</option>
                                </select></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="ListaPagos.SalvarCostoCuota();">Agregar Registro</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <iframe id="exportIframe" src="" style="height:0px;border:0 none;"></iframe>

    </body>

<?php }

require_once(dirname(__FILE__) . '/footer.php');

?>