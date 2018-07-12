<?php

require_once(dirname(__FILE__) . '/vista_layout.php');

?>

    <head>
        <script src="scripts1.0/vista_socio.js"></script>
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
                            <h4>Tamaño</h4>

                            <div id="socioDatosValorTamanio" class="socioDatosValor"></div>
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
                            <h4>Balance de cuenta</h4>

                            <div id="socioDatosValorBalanceHoras" class="socioDatosValor"></div>
                        </div></td>
                    <td></td>
                </tr>
                <tr>
                    <td><div class="socioDatosField">
                            <h4>Tel&eacute;fono</h4>

                            <div id="socioDatosValorTelefono" class="socioDatosValor"></div>
                        </div></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </div>

        <!-- Recordatorio Deuda -->
        <div class="deudas" style="display:none;">
        <h3>Pagos Adeudados</h3>
        <div class="socioRecordatorioDeudaContainer"></div>
        </div>

        <!--Pagos-->
        <h3 id="socioPagoseTitulo">Pagos</h3>

        <div class="box row-fluid">
            <div class="span12 socioListaContenedor">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor $</th>
                        <th>Fecha Pago</th>
                        <th>Raz&oacute;n</th>
                        <th>Descuento $</th>
                        <th>Modo</th>
                    </tr>
                    </thead>
                    <tbody id="listaPagosSocioTabla"></tbody>
                </table>
            </div>
        </div>

        <!--Horas-->
        <h3>Trabajo por descuento</h3>

        <div class="box row-fluid">
            <div class="span12 socioListaContenedor">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Rubro</th>
                        <th>Horas</th>
                        <th>Costo/Hora ($)</th>
                    </tr>
                    </thead>
                    <tbody id="listaHorasSocioTabla"></tbody>
                </table>
            </div>
        </div>

    </div>

    </body>

<?
require_once(dirname(__FILE__) . '/footer.php');

?>
