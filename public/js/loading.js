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
});