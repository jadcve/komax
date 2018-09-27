jQuery("#tabla").ready(function () {
    $("#temp").fadeOut()
});

jQuery(document).ready(function (){
    $("#busca_abc").click(function () {
        if ($("#fechaInicial").val() != '' && $("#fechaFinal").val() != '' && $("#canal").val() != '' && $("#marca").val() != '' && $("#a").val() != '' && $("#b").val() != ''){
            $("#loading_abc").fadeIn();
        }
    });
});