jQuery(document).ready(function(){
    var url = window.location.href;
    var to = url.lastIndexOf('/');
    to = to == -1 ? url.length : to + 1;
    url = url.substring(0, to);
    // console.log(url);
    $("select[name='agrupacion1']").change(function(){
        var agrupacion1 = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: url+"marcas",
            method: 'POST',
            data: {agrupacion1:agrupacion1, _token:token},
            success: function(data) {
                $("#marca").empty();
                $("#marca").append('<option id="select-option" value="">Seleccione</option>');
                 $.each(data,function(index,json){
                      $("#select-option").after($("<option></option>").attr("value", json.marca).text(json.marca.toUpperCase()));
                 });
            }
        });
    });

});