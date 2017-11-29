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


function mostrarLoading(){
    $("#panel .panel-body").addClass("fade-out");
    $(".js-ms-loading").addClass("fade-in");
}

function clearInput(elemento){
    var padre = elemento.parents(".form-group");
    var input = padre.find(".form-control");
    input.val("");
}
