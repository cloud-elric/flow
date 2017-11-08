$(document).ready(function(){
    $(".js-recovery-pass").on("click", function(e){
        e.preventDefault();
        
        var token = $(this).data("token");
        var url = baseUrl+"super-admin/reenviar-email-activacion";

        var l = Ladda.create(this);
        l.start();

        $.ajax({
            url: url,
            type:'GET',
            data:{
                token: token
            },
            dataType:'JSON',
            success: function(r){
                swal("Ok", "Correo enviado", "success");
            }
        }).always(function() { l.stop(); });
    });

});

$(document).on({
    'click': function(){
        mostrarLoading();
    }
}, ".js-search-button");

$(document).on({
    'click': function(){
        mostrarLoading();
    }
}, ".animsition-linke");

$(document).on({
    'click': function(){
        clearInput($(this));
    }
}, ".js-clear-input");

$(document).on({
    'click': function(){
        resetForm($("#form-search").get(0));
        $('#entusuariossearch-txt_auth_item').val(null).trigger('change');
    }
}, ".js-limpiar-campos");

$(document).on({
    'click': function(){
        if($(".js-search-button").val()==1){
            $(".js-search-button").val(0);
        }else{
            $(".js-search-button").val(1);
        }
    }
}, ".js-collapse");

$(document).on({
    'click': function(e){
        e.preventDefault();
        var token = $(this).data("token");

        confirmDelete(token, $(this));

    }
}, ".js-deshabilitar-user");

$(document).on({
    'click': function(e){
        e.preventDefault();
        var token = $(this).data("token");

        confirmHabilitar(token, $(this));

    }
}, ".js-habilitar-user");

function confirmHabilitar(id, elemento){
    swal({
        title: "Habilitar usuario",
        text: "¿Estas seguro que deseas habilitar este usuario?.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, Habilitar usuario",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        preConfirm: function (email) {
            return new Promise(function (resolve, reject) {
                $.get(baseUrl+"usuarios/habilitar-usuario?id="+id)
                .done(function (data) {
                    elemento.removeClass("js-habilitar-user");
                    elemento.addClass("js-deshabilitar-user");
                    elemento.text("Deshabilitar");
                    var contenedor = elemento.parents(".media");
                    contenedor.find(".avatar").removeClass("avatar-busy");
                    contenedor.find(".avatar").addClass("avatar-online");
                  resolve()
                })
                 // resolve()
               
            })
          },
          allowOutsideClick: false
        }).then(function (email) {
          swal({
            type: 'success',
            title: 'Correcto',
            text: 'El usuario ha sido deshabilitado'
          })
        })
}

function confirmDelete(id, elemento) {

    
    swal({
        title: "Deshabilitar usuario",
        text: "¿Estas seguro que deseas deshabilitar este usuario?. Si se deshabilita no podra ingresar a la plataforma a menos que se habilite nuevamente.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, deshabilitar usuario",
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        preConfirm: function (email) {
            return new Promise(function (resolve, reject) {
                $.get(baseUrl+"usuarios/deshabilitar-usuario?id="+id)
                .done(function (data) {
                    elemento.removeClass("js-deshabilitar-user");
                    elemento.addClass("js-habilitar-user");
                    elemento.text("Habilitar");
                    var contenedor = elemento.parents(".media");
                    contenedor.find(".avatar").removeClass("avatar-online");
                    contenedor.find(".avatar").addClass("avatar-busy");
                  resolve()
                })
                 // resolve()
               
            })
          },
          allowOutsideClick: false
        }).then(function (email) {
          swal({
            type: 'success',
            title: 'Correcto',
            text: 'El usuario ha sido habilitado'
          })
        })
}


function mostrarLoading(){
    $("#panel .panel-body").addClass("fade-out");
    $(".js-ms-loading").addClass("fade-in");
}

function clearInput(elemento){
    var padre = elemento.parents(".form-group");
    var input = padre.find(".form-control");
    input.val("");
}
