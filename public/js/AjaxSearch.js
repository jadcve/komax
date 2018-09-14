jQuery(document).ready(function () {
    var busqueda;
    var url = window.location.href;
    var to = url.lastIndexOf('/');
    to = to == -1 ? url.length : to + 1;
    url = url.substring(to);
    console.log('url', url);

    $("#buscar_btn").click(function (e) { 
        e.preventDefault();
        
    });

    $("#buscar").keyup(function (e) {
        e.preventDefault();
        busqueda = $("#buscar").val();
        var token = $("#_token").val();

        $.ajax({
            method: "POST",
            url: url+"/search",
            data: {busqueda:busqueda, _token:token},
            success: function (response) {
                console.log('response', response)
                $("#no-result-box").remove();
                $("tbody").empty();
                if (response.length === 0){
                    noResult();
                    $("#no-result-box").fadeIn(1000);
                }
                $.each(response, function (index, json) {
                    $("#no-result-box").fadeOut(300);
                     $("tbody").append(createTables(url, json));
                });
            }
        });
    });
    
    function noResult(){
        var element = $("table").after('<div id="no-result-box" class="row">'+
        '<div class="col-xs-6 col-xs-offset-3 no-result">'+
            '<h3>No se han encontrado resultados para tu búsqueda</h3>'+
        '</div>'+
        '</div>');
        return element;
    }

    function createTables(seccion, json){
        var contenido;
        switch (seccion) {
            case "proveedor":
                contenido = '<tr>'+
                '<td>'+resaltar(json.codigo_proveedor)+'</td>'+
                '<td>'+resaltar(json.descripcion_proveedor)+'</td>'+
                '<td>'+resaltar(json.lead_time_proveedor)+'</td>'+
                '<td>'+resaltar(json.tiempo_entrega_proveedor)+'</td>'+
                '<td>'+
                        resaltar(json.name)+'<span style="font-size:8px"><br>'+resaltar(json.updated_at)+'</span>'+
                 '</td>'+
                '<td>'+
                    '<a href = "#" class = "viewShow btn btn-warning btn-xs" data-link = "/proveedor/'+json.id+'"><i class = "fa fa-eye"> Detalles</i></a>'+
                    '<a href = "#" class = "viewEdit btn btn-primary btn-xs" data-link = "/proveedor/'+json.id+'/edit"><i class = "fa fa-edit"> Editar</i></a>'+
                    '<a data-toggle="modal" data-target="#myModal" class = "delete btn btn-danger btn-xs" data-link = "/proveedor/'+json.id+'/deleteMsg" ><i class = "fa fa-trash"> Eliminar</i></a>'+
                '</td>'+
               '</tr>';
                break;
            case "calendario":
                contenido ='<tr>'+
                    '<td>'+json.dia+'</td>'+
                    '<td>'+json.dia_despacho+'</td>'+
                    '<td>'+json.lead_time+'</td>'+
                    '<td>'+json.tiempo_entrega+'</td>'+
                    '<td>'+json.bodega+'</td>'+
                    '<td>'+
                        json.name+'<span style="font-size:8px"><br>'+json.updated_at+
                        '</span></td>'+
                    '<td>'+
                        '<a href = "#" class = "viewShow btn btn-warning btn-xs" data-link = "/calendario/'+json.id+'><i class = "fa fa-eye"> Detalles</i></a>'+
                        '<a href = "#" class = "viewEdit btn btn-primary btn-xs" data-link = "/calendario/'+json.id+'/edit"><i class = "fa fa-edit"> Editar</i></a>'+
                        '<a data-toggle="modal" data-target="#myModal" class = "delete btn btn-danger btn-xs" data-link = "/calendario/'+json.id+'/deleteMsg" ><i class = "fa fa-trash"> Eliminar</i></a>'+
                    '</td>'+
                '</tr>';
                break;
        }
        return contenido;
    }

    function resaltar(dato){
        return dato.toLowerCase().replace(busqueda, "<em>"+busqueda+"</em>");
    }
});