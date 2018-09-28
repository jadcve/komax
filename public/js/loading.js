// jQuery("#tabla").ready(function () {
//     $("#temp").fadeOut()
// });

jQuery(document).ready(function (){
    $("#busca_abc").click(function () {
        if ($("#fechaInicial").val().trim() != '' && $("#fechaFinal").val().trim() != '' && $("#canal").val().trim() != '' && $("#marca").val().trim() != '' && $("#a").val().trim() != '' && $("#b").val().trim() != ''){
            $("#loading_abc").fadeIn();
        }
    });

    $("#busca_sugerido").click(function () {
        if ($("#fecha").val().trim() != '' && $("#bodega").val().trim() != ''){
            $("#loading_sugerido").fadeIn();
        }
    });

    $("#bodega").keyup(function (e) { 
        $("#bodega").val($("#bodega").val().trim());
    });

    $('#a').keyup(function (e) { 
        $("#a").val($("#a").val().trim());
    });
    
    $('#b').keyup(function (e) { 
        $("#b").val($("#b").val().trim());
    });
});