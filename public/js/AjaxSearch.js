jQuery(document).ready(function () {
    var busqueda;
    var url = window.location.href;
    var to = url.lastIndexOf('/');
    var end = url.lastIndexOf('?');
    to = to == -1 ? url.length : to + 1;
    url = end == -1 ? url.substring(to) : url.substring(to, end);
    // $("#buscar").focus();
    console.log('url:', url);

    $("#buscar_btn").click(function (e) { 
        e.preventDefault();
        buscar();
    });

    $("#buscar").keyup(function (e) {
        e.preventDefault();
        buscar();
    });

    function buscar(){
        busqueda = $("#buscar").val();
        var token = $("#_token").val();

        $.ajax({
            method: "POST",
            url: url+"/search",
            data: {busqueda:busqueda, _token:token},
            success: function (response) {
                console.log('response', response);
                $("#no-result-box").remove();
                $("tbody").empty();
                $("ul.pagination").fadeOut();
                if (busqueda.length <= 0){
                    $("ul.pagination").fadeIn();
                    location.reload();
                }
                if (response.length === 0){
                    noResult();
                    $("#no-result-box").fadeIn(1000);
                }
                $.each(response, function (index, json) {
                    $("#no-result-box").fadeOut(300);
                     $("tbody").append(createTables(url, json));
                    //  $("#buscar").focus();
                });
            }
        });
    }
    
    function noResult(){
        var element = $("table").after('<div id="no-result-box" class="row">'+
        '<div class="col-xs-6 col-xs-offset-3 no-result">'+
            '<h3>No se han encontrado resultados para tu búsqueda</h3>'+
        '</div>'+
        '</div>');
        return element;
    }

    function resaltar(dato){
        dato = dato.toString();
        var iniString = dato.search(RegExp(busqueda.toString(), "i"));
        var finString = iniString + busqueda.length;
        var segString = dato.substring(iniString, finString);

        return dato.replace(RegExp(busqueda, "i"), "<em>"+segString+"</em>");
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
                    '<td>'+resaltar(json.dia)+'</td>'+
                    '<td>'+resaltar(json.dia_despacho)+'</td>'+
                    '<td>'+resaltar(json.lead_time)+'</td>'+
                    '<td>'+resaltar(json.tiempo_entrega)+'</td>'+
                    '<td>'+resaltar(json.bodega)+'</td>'+
                    '<td>'+
                    resaltar(json.name)+'<span style="font-size:8px"><br>'+resaltar(json.updated_at)+
                        '</span></td>'+
                    '<td>'+
                        '<a href = "#" class = "viewShow btn btn-warning btn-xs" data-link = "/calendario/'+json.id+'><i class = "fa fa-eye"> Detalles</i></a>'+
                        '<a href = "#" class = "viewEdit btn btn-primary btn-xs" data-link = "/calendario/'+json.id+'/edit"><i class = "fa fa-edit"> Editar</i></a>'+
                        '<a data-toggle="modal" data-target="#myModal" class = "delete btn btn-danger btn-xs" data-link = "/calendario/'+json.id+'/deleteMsg" ><i class = "fa fa-trash"> Eliminar</i></a>'+
                    '</td>'+
                '</tr>';
                break;
                case "nivel_servicio":
                contenido ='<tr>'+
                    '<td>'+resaltar(json.letra)+'</td>'+
                    '<td>'+resaltar(json.nivel_servicio)+'</td>'+
                    '<td>'+resaltar(json.descripcion)+'</td>'+
                    '<td>'+
                    resaltar(json.name)+'<span style="font-size:8px"><br>'+resaltar(json.updated_at)+
                        '</span></td>'+
                    '<td>'+
                        '<a href = "#" class = "viewShow btn btn-warning btn-xs" data-link = "/nivel_servicio/'+json.id+'><i class = "fa fa-eye"> Detalles</i></a>'+
                        '<a href = "#" class = "viewEdit btn btn-primary btn-xs" data-link = "/nivel_servicio/'+json.id+'/edit"><i class = "fa fa-edit"> Editar</i></a>'+
                        '<a data-toggle="modal" data-target="#myModal" class = "delete btn btn-danger btn-xs" data-link = "/nivel_servicio/'+json.id+'/deleteMsg" ><i class = "fa fa-trash"> Eliminar</i></a>'+
                    '</td>'+
                '</tr>';
                break;
                case "bodega":
                contenido ='<tr>'+
                    '<td>'+resaltar(json.cod_bodega)+'</td>'+
                    '<td>'+resaltar(json.bodega)+'</td>'+
                    '<td>'+resaltar(json.agrupacion1)+'</td>'+
                    '<td>'+resaltar(json.ciudad)+'</td>'+
                    '<td>'+resaltar(json.comuna)+'</td>'+
                    '<td>'+resaltar(json.region)+'</td>'+
                    '<td>'+resaltar(json.latitude)+'</td>'+
                    '<td>'+resaltar(json.longitud)+'</td>'+
                    '<td>'+resaltar(json.direccion)+'</td>'+
                    '<td>'+
                    resaltar(json.name)+'<span style="font-size:8px"><br>'+resaltar(json.updated_at)+
                        '</span></td>'+
                    '<td>'+
                        '<a href = "#" class = "viewShow btn btn-warning btn-xs" data-link = "/bodega/'+json.id+'><i class = "fa fa-eye"> Detalles</i></a>'+
                        '<a href = "#" class = "viewEdit btn btn-primary btn-xs" data-link = "/bodega/'+json.id+'/edit"><i class = "fa fa-edit"> Editar</i></a>'+
                        '<a data-toggle="modal" data-target="#myModal" class = "delete btn btn-danger btn-xs" data-link = "/bodega/'+json.id+'/deleteMsg" ><i class = "fa fa-trash"> Eliminar</i></a>'+
                    '</td>'+
                '</tr>';
                break;
        }
        return contenido;
    }
});