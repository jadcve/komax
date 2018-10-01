$(document).ready(function () {
    // para redirigir cuando expira la sesion
    // php configuration 120 minute * 60 second * 1000 milisecond = 7.200.000
    // $(function() {
    //     // Set idle time
    //     $(document).idleTimer(7200000);
    // });
    
    // $(function() {
    //     $( document ).on( "idle.idleTimer", function(event, elem, obj){
    //         var url = window.location.href;
    //         var to = url.lastIndexOf('/');
    //         to = to == -1 ? url.length : to + 1;
    //         url = url.substring(0, to);
    //         console.log('url principal', url)
    //         window.location.href = "example.com/login"
    //     });  
    // });

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