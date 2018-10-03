jQuery(document).ready(function () {
    var busqueda;
    var pagina = 1;
    var url = window.location.href;
    var to = url.lastIndexOf('/');
    var end = url.lastIndexOf('?');
    to = to == -1 ? url.length : to + 1;
    url = end == -1 ? url.substring(to) : url.substring(to, end);
    // console.log('url:', url);

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
                $("#no-result-box").remove();
                $("tbody").empty();
                // $("ul.pagination").fadeOut();
                // if (busqueda.length <= 0){
                //     // $("ul.pagination").fadeIn();
                //     // location.reload();
                // }
                if (response.length === 0){
                    noResult();
                    $("#no-result-box").fadeIn(1000);
                }
                paginator(response, 1);
            }
        });
    }

    function paginator(response, pagina, previo = 0, proximo = 0){
       
        var porPagina = 5;
        var pagSecc = 10;
        proximo = proximo == 0 ? pagSecc : proximo;
        //cuantas paginas hay en total
        var totalPaginas = Math.ceil(response.length / porPagina);
        if (totalPaginas == 1){
            $(".pagination").css("display", "none");
        }
        //cuantas secciones hay en total redondeado hacia arriba
        var secciones = Math.ceil(totalPaginas/pagSecc);
        //principio de los registros de la pagina
        inicio = Math.max(pagina - 1, 0) * porPagina;
        //fin de los registros de la pagina
        fin = inicio + porPagina;
        // extrae los registros de la pagina
        mostrarElementos = response.slice(inicio, fin);
        //vacia la tabla
        $(".pagination").empty();

        //-------- Paginacion
        //Previo
        $(".pagination").append('<li class="page-item" aria-disabled="true" aria-label="« Previous"><a id="previo" class="page-link" href="" value="1" rel="prev" aria-label="Prev »">‹</a></li>');
        //crea los links con los numeros de las paginas 
        for (let i = 1; i <= pagSecc; i++) {
            // crea el numero de las paginas
            numeroPagina = i + previo;
            //define si es la pagina actual y agrega la clase active y el aria-current
            active = (pagina == numeroPagina) ? ' active' : '';
            aria = (pagina == numeroPagina) ? ' aria-current="page"' : '';
            // crea el link
            $(".pagination").append('<li class="page-item'+active+'"'+aria+'><a class="page-link" href="" value="'+numeroPagina+'">'+numeroPagina+'</a></li>');
            if (numeroPagina == totalPaginas){
                break;
            }
        }
        // Proximo
        $(".pagination").append('<li class="page-item"><a id="proximo" class="page-link" href="" value="'+totalPaginas+'" rel="next" aria-label="Next »">›</a></li>');
        // si la pagina actual es la primera de todas las paginas desactiva el previo
        (previo == 0) ? $('.pagination li:first').addClass('disabled').empty().append('<span class="page-link" aria-hidden="true">‹</span>') : $('.pagination li:first').removeClass('disabled');
        // si la pagina actual es la ultima de todas las paginas desactiva el proximo
        (numeroPagina == totalPaginas) ? $('.pagination li:last-child').addClass('disabled').empty().append('<span class="page-link" aria-hidden="true">›</span>') : $('.pagination li:last-child').removeClass('disabled');

        // accion al hacer click en un link de pagina
        $(".page-link").click(function (e) {
            e.preventDefault();
            // al hacer click en proximo o previo
            if (e.currentTarget.id == 'proximo' || e.currentTarget.id == 'previo'){
                // suma y resta a proximo y a previo el numero de paginas por seccion
                proximo = e.currentTarget.id == 'proximo' ? proximo + pagSecc : proximo - pagSecc;
                previo = proximo - pagSecc;
                // actualiza la primera pagina de la seccion como la actual
                pagina = previo + 1
            }
            else{
                // asigna a pagina el numero de la pagina en la que se hace click
                pagina =  e.currentTarget.attributes[2].value;
            }
            // asigna el nuevo valor al boton de previo
            previo = proximo - pagSecc;
            // vacia la tabla
            $("tbody").empty();
            // llamado recursivo a pagina para crear la nueva paginacion
            paginator(response, pagina, previo, proximo);
        });
        // llena la tabla
        data(mostrarElementos);
    }

    function data(mostrarElementos){
        $.each(mostrarElementos, function (index, json) {
            $("#no-result-box").fadeOut(300);
             $("tbody").append(createTables(url, json));
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