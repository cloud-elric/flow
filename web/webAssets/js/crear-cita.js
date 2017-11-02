$(document).ready(function(){
    $("#entcitas-id_equipo").on("change", function(){
        var id = $(this).val();

        if(id){
            buscarEquipo(id);
        }else{
            limpiarCamposEquipo();
        }

    });


    $("#entcitas-id_sim_card").on("change", function(){
        var id = $(this).val();

        if(id){
            buscarSim(id);
        }else{
            limipiarCamposSim();
        }

    });

    $("#entcitas-id_estado").on("change", function(){
        var id = $(this).val();

        if(id){
            buscarArea(id);
        }
    });
});

function buscarArea(id){
    $.ajax({
        url: baseUrl+"estados/get-area?id="+id,
        success:function(resp){
           
        }

    });
}

function buscarSim(id){
    $.ajax({
        url: baseUrl+"sims-cards/get-sim?id="+id,
        success:function(resp){
            var descripcion = '';
            if(resp.txt_descripcion){
                descripcion = resp.txt_descripcion;
            }

            $("#descripcion_sim").val(descripcion);

            var claveSap = '';
            if(resp.txt_clave_sim_card){
                claveSap = resp.txt_clave_sim_card;
            }

            $("#clave_sap_sim").val(claveSap);
        }

    });
}

function limipiarCamposSim(){
    $("#descripcion_sim").val('');
    $("#clave_sap_sim").val('');
}

function limpiarCamposEquipo(){
    $("#descripcion_equipo").val('');
    $("#clave_sap").val('');
}

function buscarEquipo(id){
    $.ajax({
        url: baseUrl+"equipos/get-equipo?id="+id,
        success:function(resp){
            var descripcion = '';
            if(resp.txt_descripcion){
                descripcion = resp.txt_descripcion;
            }

            $("#descripcion_equipo").val(descripcion);

            var claveSap = '';
            if(resp.txt_clave_sap){
                claveSap = resp.txt_clave_sap;
            }

            $("#clave_sap").val(claveSap);
        }

    });
}