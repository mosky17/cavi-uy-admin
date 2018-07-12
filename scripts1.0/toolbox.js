/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

var Toolbox = {
    NombreMesesEsp:{1:"Enero",2:"Febrero",3:"Marzo",4:"Abril",5:"Mayo",6:"Junio",7:"Julio",8:"Agosto",9:"Setiembre",10:"Octubre",11:"Noviembre",12:"Diciembre"},
    NombreMesesEspIndex:{"enero":1,"febrero":2,"marzo":3,"abril":4,"mayo":5,"junio":6,"julio":7,
        "agosto":8,"setiembre":9,"octubre":10,"noviembre":11,"diciembre":12},
    LoaderQueue: 0,
    LoaderQueueModal: 0,
    GetUrlVars: function () {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    },
    UpdateActiveNavbar: function (active) {
            $('#headerNavigation').css('display', 'block');
            $('.nav-link').removeClass('active');
        if(active && active != "") {
            $('#' + active).addClass('active');
        }
    },
    ShowLoader: function () {
        Toolbox.LoaderQueue += 1;
        $('#nav_loader').css('display', 'block');
    },
    StopLoader: function () {
        Toolbox.LoaderQueue -= 1;
        if (Toolbox.LoaderQueue == 0) {
            $('#nav_loader').css('display', 'none');
        }

    },
    ShowLoaderModal: function () {
        Toolbox.LoaderQueueModal += 1;
        $('.loaderModal').css('display', 'block');
    },
    StopLoaderModal: function () {
        Toolbox.LoaderQueueModal -= 1;
        if (Toolbox.LoaderQueueModal == 0) {
            $('.loaderModal').css('display', 'none');
        }

    },
    DataToMysqlDate: function (date) {
        var parts = date.split('/');
        return parts[2] + "-" + parts[1] + "-" + parts[0];
    },
    MysqlDateToDate: function (date) {
        var parts = date.split('-');
        return parts[2] + "/" + parts[1] + "/" + parts[0];
    },
    ShowFeedback: function (container, type, message, noAutoTop) {

        if (!message || message == "") {
            $('#' + container).css('display', 'none');
        } else {

            var typeClass = "";
            var prefix = "";

            if (type == 'error') {

                typeClass = " alert-danger";
                prefix = '<i class="fas fa-exclamation-circle"></i>';


            } else if (type == 'success') {

                typeClass = " alert-success";
                //prefix = '<img class="feedbackIcon" src="../images/ok1.png">';

            } else if (type == 'warning') {

                //prefix = '<img class="feedbackIcon" src="../images/warning2.png">';

            }

            var html = '<div class="alert alert-block' + typeClass + '">'
                + prefix + '<p>' + message + '</p></div>';

            $('#' + container).html(html);
            $('#' + container).css('display', 'block');
            if (!noAutoTop) {
                $(window).scrollTop(0);
            }
        }
    },
    GoToLogin: function () {
        window.location.href = GLOBAL_domain + "/login.php";
    },
    Logout: function () {
        Toolbox.ShowLoader();

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "proc/controller.php",
            data: { func: "logout" }
        }).done(function (data) {
                if (data && !data.error) {
                    Toolbox.GoToLogin();
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
    TransformSpecialTag: function (text) {

        var text2 = "";
        if(text.indexOf("mensualidad")==0){
            text2 = text.substring(13, text.length -1);
            text = "mensualidad";
        }

        if(text.indexOf("anio")==0){
            text2 = text.substring(6, text.length -1);
            text = "anio";
        }

        if(text.indexOf("medioanio")==0){
            text2 = text.substring(11, text.length -1);
            text = "medioanio";
        }

        switch (text) {
            case "matricula":
                return '<span class="badge" style="background-color:#A8BB19;">Matr&iacutecula</span>';
                break;
            case "anio":
                return '<span class="badge badge-success">Anualidad ' + text2 + '</span>';
                break;
            case "medioanio":
                return '<span class="badge badge-warning">Semestre ' + text2 + '</span>';
                break;
            case "mensualidad":
                return '<span class="badge" style="background-color:#2E5894;">' + text2 + '</span>';
                break;
            case "CobrosYA":
                return '<span class="badge" style="background-color:#FF5722;">CobrosYA</span>';
                break;
            case "personalmente":
                return '<span class="badge badge-danger">En Persona</span>';
                break;
            case "Socio":
                return '<span class="badge badge-success">Socio</span>';
                break;

            //descuentos
            case "Balance":
                return '<span class="badge badge-primary" style="">Balance</span>';
                break;

            //rubros pagos
            case "Administracion":
                return '<span class="badge badge-info">Administraci&oacute;n</span>';
                break;
            case "Administraci&oacute;n":
                return '<span class="badge badge-info">Administraci&oacute;n</span>';
                break;
            case "Soporte":
                return '<span class="badge badge-primary">Soporte</span>';
                break;
            case "Eventos":
                return '<span class="badge badge-warning">Eventos</span>';
                break;
            case "Edilicio":
                return '<span class="label label-primary" style="background-color:#004098;">Edilicio</span>';
                break;
            case "Transporte":
                return '<span class="badge badge-success" style="">Transporte</span>';
                break;
            case "Otro":
                return '<span class="badge badge-secondary">Otro</span>';
                break;
            case "Devoluciones":
                return '<span class="badge badge-secondary">Devoluciones</span>';
                break;
            //ELSE
            default:
                return text;
                break;
        }


    },
    GetFechaHoyLocal: function(){
        var date = new Date();
        var days = date.getDate()>9 ? date.getDate() : '0' + date.getDate();
        var month = date.getMonth() + 1;
        month = month>9 ? month : '0' + month;
        return days + '/' + month + '/' + date.getFullYear();
    }
}
