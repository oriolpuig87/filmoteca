$(document).ready(function() {
    var winwidth = $( window ).width();
    var winheight = $( window ).height();
    var mainwidth = winwidth - 350;
    $('aside').css('height',winheight+'px');
    $('.main').css('width',mainwidth+'px');
    $('footer').css('width',mainwidth+'px');
    $('#addFilm').click(function(event) {
        $('#modal-1').css('display', 'block');
    });
    $('#addBiblio').click(function(event) {
        $('#modalAddBiblio').css('display', 'block');
    });

    $('form#anadirBiblioteca').submit(function(event) {
        var formData = {
            'biblioname'              : $('input[name=biblioname]').val(),
        };
        $.ajax({
            type        : 'POST',
            url         : 'actions/addbiblio.php',
            data        : formData,
            dataType    : 'HTML',
        })
            .done(function(data) {
                url = "http://peliteca.cat/biblioteca.php?id="+data;
                $( location ).attr("href", url);
            });
        event.preventDefault();
    });

    // process the form
    $('form#searchFilm').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = {
            'busqueda'              : $('input[name=busqueda]').val(),
            'biblioteca'              : $('input[name=biblioteca]').val(),
        };

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'actions/addfilmfirst.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'HTML', // what type of data do we expect back from the server
        })
            // using the done promise callback
            .done(function(data) {

                $('#modal-2').html(data);
                $('#modal-1').css('display', 'none');
                $('#modal-2').css('display', 'block');
                var winheight = $( window ).height();
                var winmaxheight = winheight - 150;
                $('.modal-contenido').css('max-height', winmaxheight+'px');



                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

    $( window ).resize(function() {
        console.log('resizing');
        var winwidth = $( window ).width();
        var winheight = $( window ).height();
        var mainwidth = winwidth - 350;
        $('aside').css('height',winheight+'px');
        $('.main').css('width',mainwidth+'px');
        $('footer').css('width',mainwidth+'px');
    });
});
function saveFilm() {
        var biblio = $('input[name=biblioteca]').val();
        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = {
            'pelicode'              : $('input[name=pelicode]').val(),
            'usuario'              : $('input[name=usuario]').val(),
            'biblioteca'           : $('input[name=biblioteca]').val(),
            'pelinom'              : $('input[name=pelinom]').val(),
            'pelioriginal'         : $('input[name=pelioriginal]').val(),
            'peliduracio'              : $('input[name=peliduracio]').val(),
            'peliano'              : $('input[name=peliano]').val(),
            'pelivaloracion'              : $('input[name=pelivaloracion]').val(),
            'peliweb'              : $('input[name=peliweb]').val(),
            'pelidirector'              : $('input[name=pelidirector]').val(),
            'pelipais'              : $('input[name=pelipais]').val(),
            'peligenero'              : $('input[name=peligenero]').val(),
            'peliguio'              : $('input[name=peliguio]').val(),
            'peliproductora'              : $('input[name=peliproductora]').val(),
            'pelimusica'              : $('input[name=pelimusica]').val(),
            'peliimatge'              : $('input[name=peliimatge]').val(),
            'pelireparto'              : $('textarea[name=pelireparto]').val(),
            'peliresumen'              : $('textarea[name=peliresumen]').val(),
        };

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'actions/addfilmthird.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'HTML', // what type of data do we expect back from the server
        })
            // using the done promise callback
            .done(function(data) {
                url = "http://peliteca.cat/biblioteca.php?id="+biblio;
                $( location ).attr("href", url);
                 // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
}

function setForm(id,biblio) {
        var formData = {
            'pelicula'              : id,
            'biblioteca'            : biblio,
        };

        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'actions/addfilmsecond.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'HTML', // what type of data do we expect back from the server
        })
            // using the done promise callback
            .done(function(data) {

                $('#modal-3').html(data);
                $('#modal-1').css('display', 'none');
                $('#modal-2').css('display', 'none');
                $('#modal-3').css('display', 'block');
                var winheight = $( window ).height();
                var winmaxheight = winheight - 150;
                $('.modal-contenido').css('max-height', winmaxheight+'px');                

            });

}
function goback(id){
    if(id == 1){
        $('#modal-1').css('display', 'block');
        $('#modal-2').css('display', 'none');
        $('#modal-3').css('display', 'none');
    } else {
        $('#modal-1').css('display', 'none');
        $('#modal-2').css('display', 'block');
        $('#modal-3').css('display', 'none');
    }
}
function closeModal(){
        $('#modal-1').css('display', 'none');
        $('#modal-2').css('display', 'none');
        $('#modal-3').css('display', 'none');
}