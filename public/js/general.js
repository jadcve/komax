$(document).ready(function () {

    $("#bodega").keyup(function (e) { 
        $("#bodega").val($("#bodega").val().trim());
    });

    $('#a').keyup(function (e) { 
        $("#a").val($("#a").val().trim());
    });
    
    $('#b').keyup(function (e) { 
        $("#b").val($("#b").val().trim());
    });

    // validacion formulario abc
    $("#abc-calculo").submit(function (e) {
        if ($("#fechaInicial").val().trim() == '' && $("#fechaFinal").val().trim() == '' && $("#a").val().trim() == '' && $("#b").val().trim() == ''){
            validadoVacio = false;
        }
        else{
            validadoVacio = true;
        }
        var fechaInicial = new Date($("#fechaInicial").val());
        var fechaFinal = new Date($("#fechaFinal").val());
        if (fechaInicial.getTime() < fechaFinal.getTime()){
            $("#msj-fecha").remove();
            validadoFecha = true;
        }
        else{
            $("#msj-fecha").remove();
            $(".msj-abc").append('<div id="msj-fecha">La <strong>Fecha Inicial</strong> debe ser menor que la <strong>Fecha Final</strong></div>');
            validadoFecha = false;
        }
        if ($("#a").val() < $("#b").val()){
            $("#msj-ab").remove();
            validadoAb = true;
        }
        else{
            $("#msj-ab").remove();
            $(".msj-abc").append('<div id="msj-ab">El valor de <strong>B</strong> debe ser mayor que <strong>A</strong></div>');
            validadoAb = false;
        }

            validado = validadoAb && validadoFecha;
            validado = validado && validadoVacio;

            validado ? $("#loading_abc").fadeIn() : '';
            validado ? $(".msj-abc").fadeOut() : $(".msj-abc").fadeIn();

        return validado;
    });
});