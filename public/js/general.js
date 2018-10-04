$(document).ready(function () {

    $("#bodega").keyup(function (e) { 
        $("#bodega").val($("#bodega").val().trim());
    });

    $('#a').keyup(function (e) {
        $("#a").val($("#a").val().trim());
        var inputA = $("#a").val();
        // delimitar decimales a 2
        var comaDecimal = inputA.indexOf('.');
        if (comaDecimal != -1){
            var entero = inputA.substring(0, comaDecimal+1);
            var decimales = inputA.substring(comaDecimal+1);

            if (decimales.length > 2){
                decimales = inputA.substring(comaDecimal+1,comaDecimal+3);
                $("#msj-inputs").remove();
                $(".msj-abc").append('<div id="msj-inputs">Máximo permitido <strong>2 decimales</strong></div>');
                $("#a").val(entero+decimales);

                mensajeTemporal();
            }
        }
        
        if (!$.isNumeric(inputA)) {
            $("#msj-inputs").remove();
            $(".msj-abc").append('<div id="msj-inputs">El valor debe ser <strong>Numérico</strong></div>');
            $("#a").val("");

            mensajeTemporal();
        }
        if (inputA < 0 || inputA > 100) {
            $("#msj-inputs").remove();
            $(".msj-abc").append('<div id="msj-inputs">El valor debe estar entre <strong>0 y 100</strong></div>');
            $("#a").val("");

            mensajeTemporal();
        }
    });
    
    $('#b').keyup(function (e) { 
        $("#b").val($("#b").val().trim());
        var inputB = $("#b").val();
        // delimitar decimales a 2
        var comaDecimal = inputB.indexOf('.');
        if (comaDecimal != -1){
            var entero = inputB.substring(0, comaDecimal+1);
            var decimales = inputB.substring(comaDecimal+1);

            if (decimales.length > 2){
                decimales = inputB.substring(comaDecimal+1,comaDecimal+3);
                $("#msj-inputs").remove();
                $(".msj-abc").append('<div id="msj-inputs">Máximo permitido <strong>2 decimales</strong></div>');
                $("#b").val(entero+decimales);

                mensajeTemporal();
            }
        }
        if (!$.isNumeric(inputB)) {
            $("#msj-inputs").remove();
            $(".msj-abc").append('<div id="msj-inputs">El valor debe ser <strong>Numérico</strong></div>');
            $("#b").val("");

            mensajeTemporal();
        }
        if (inputB < 0 || inputB > 100) {
            $("#msj-inputs").remove();
            $(".msj-abc").append('<div id="msj-inputs">El valor debe estar entre <strong>0 y 100</strong></div>');
            $("#b").val("");

            mensajeTemporal();
        }
    });

    function mensajeTemporal(){
        $(".msj-abc").fadeIn();
        setTimeout(() => {
            $("#msj-inputs").remove();
            $(".msj-abc").fadeOut();
        }, 1500);
    }

    // validacion formulario abc
    $("#abc-calculo").submit(function (e) {
        // e.preventDefault();
        if ($("#fechaInicial").val().trim() == '' && $("#fechaFinal").val().trim() == '' && $("#a").val().trim() == '' && $("#b").val().trim() == ''){
            validadoVacio = false;
        }
        else{
            validadoVacio = true;
        }

        var validadoformatoInicio = isValidDate($("#fechaInicial").val().trim());

        var validadoformatoFinal = isValidDate($("#fechaFinal").val().trim());

        if (!validadoformatoInicio){
            $("#msj-fecha-Inicial").remove();
            $(".msj-abc").append('<div id="msj-fecha-Inicial">El formato de la <strong>Fecha Inicial  </strong> es incorrecto</div>');
        }
        else{
            $("#msj-fecha-Inicial").remove();
        }

        if (!validadoformatoFinal){
            $("#msj-fecha-Final").remove();
            $(".msj-abc").append('<div id="msj-fecha-Final">El formato de la <strong>Fecha Final</strong> es incorrecto</div>');
        }
        else{
            $("#msj-fecha-Final").remove();
        }

        function isValidDate(dateString){
            dateToCheck = new RegExp("([1-2][0-9][0-9][0-9])([-])(0[123456789]|10|11|12)([-])(0[1-9]|[12][0-9]|3[01])");
            res = dateToCheck.test(dateString)
            if(!dateToCheck.test(dateString)){
                return false;
            }
            // convertir los numeros a enteros
            var parts = dateString.split("-");
            var day = parseInt(parts[2], 10);
            var month = parseInt(parts[1], 10);
            var year = parseInt(parts[0], 10);

            // Revisar los rangos de año y mes
            if( (year < 1000) || (year > 3000) || (month == 0) || (month > 12) )
                return false;

            var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

            // Ajustar para los años bisiestos
            if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
                monthLength[1] = 29;

            // Revisar el rango del dia
            return day > 0 && day <= monthLength[month - 1];
        };

        var fechaInicial = new Date($("#fechaInicial").val());
        var fechaFinal = new Date($("#fechaFinal").val());
        if (fechaInicial.getTime() <= fechaFinal.getTime()){
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
            if (!validadoAb){
                $(".msj-abc").fadeIn()
                return false
            }
            if (!validadoFecha){
                $(".msj-abc").fadeIn()
                return false
            }
            if (!validadoVacio){
                $(".msj-abc").fadeIn()
                return false
            }
            if (!validadoformatoInicio){
                $(".msj-abc").fadeIn()
                return false
            }
            if (!validadoformatoFinal){
                $(".msj-abc").fadeIn()
                return false
            }
            // validado = validadoAb && validadoFecha;
            // validado = validado && validadoVacio;
            // validado = validado && validadoformatoInicio;
            // validado = validado && validadoformatoFinal;

            // validado ? $("#loading_abc").fadeIn() : '';
            // validado ? $(".msj-abc").fadeOut() : $(".msj-abc").fadeIn();
            $(".msj-abc").fadeOut();
            $("#loading_abc").fadeIn();

        // return true;
    });
});