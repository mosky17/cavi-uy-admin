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
        <script src="scripts1.0/lista_gastos.js"></script>
    </head>

    <body>
    <div class="container">
        <h2>Caja</h2>

        <div class="totales">
        </div>

        <div class="controlesLista btn-toolbar" role="toolbar">
            <div id="crearGasto" class="btn btn-danger" onclick="ListaGastos.OpenModalNuevoGasto();">+ Gasto</div>
            <div id="crearHaber" class="btn btn-success" onclick="ListaGastos.OpenModalNuevoHaber();">+ Ingreso</div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" onClick="ListaGastos.ExportarCaja();">Caja</a>
                                </div>
                            </div>
        </div>
        <div id=feedbackContainer></div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Valor $</th>
                <th></th>
                <th>Fecha Pago</th>
                <th>Raz&oacute;n</th>
                <th>Rubro</th>
                <th>Notas</th>
            </tr>
            </thead>
            <tbody id="listaGastosTabla"></tbody>
        </table>
    </div>

    <iframe id="exportIframe" src="" style="height:0px;border:0 none;"></iframe>

    <!-- Modal ingresar gasto -->
    <div id="listaIngresarGastoModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="listaIngresarGastoModalLabel class="modal-title">Ingresar Gasto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="feedbackContainerModalIngresarGasto" class="feedbackContainerModal"></div>
                    <div class="modalListaRow">
                        <h4>Valor $</h4>
                        <input style="width: 110px;" type="text" placeholder="0.00" id="listaIngresarGastoValor">
                    </div>
                    <div class="modalListaRow">
                        <h4>Fecha</h4>
                        <input type="text" placeholder="" id="listaIngresarGastoFecha">
                    </div>
                    <div class="modalListaRow">
                        <h4>Rubro</h4>
                        <select id="listaIngresarGastoGrupo">
                            <option value="">- seleccionar rubro -</option>
                            <option value="Soporte">Soporte</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Administracion">Administración</option>
                            <option value="Viaticos">Viáticos</option>
                            <option value="Eventos">Eventos</option>
                            <option value="Transporte">Transporte</option>
                            <option value="Devoluciones">Devoluciones</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="modalListaRow">
                        <h4>Raz&oacute;n</h4>
                        <textarea style="width: 400px; height: 50px; max-width: 400px; max-height: 100px;"
                                  id="listaIngresarGastoRazon"></textarea>
                    </div>
                    <div class="modalListaRow">
                        <h4>Notas</h4>
                        <textarea style="width: 400px; height: 50px; max-width: 400px; max-height: 100px;"
                                  id="listaIngresarGastoNotas"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <img src="images/loaderModal.gif" class="loaderModal">
                    <button type="button" class="btn btn-primary" id="listaIngresarGastoModalBtnIngresar" onclick="ListaGastos.IngresarGasto();">Ingresar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    </body>

<?php }

require_once(dirname(__FILE__) . '/footer.php');

?>