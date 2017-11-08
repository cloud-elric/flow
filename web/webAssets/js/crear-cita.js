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
            buscarEstado(id);
        }else{
            limpiarCamposEstado();
        }
  
    });
});

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

$("#w0").submit(function(){
    $("#entcitas-num_dias_servicio").prop('disabled', false);
    //console.log("cambio propiedad de input");
    //return;
});

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

function buscarEstado(id){
    $.ajax({
        url: baseUrl+"estados/get-estado?id="+id,
        success:function(resp){
            var area = '';
            var entrega = '';
            if(resp.txt_nombre){
                area = resp.txt_nombre;
            }
            if(resp.id_tipo_entrega){
                entrega = 'Terrestre';
            }
            $("#txt_area").val(area);
            $("#entcitas-num_dias_servicio").val(resp.txt_dias_servicio);
            $("#txt_tipo_entrega").val(entrega);

            $("#entcitas-id_area").val(resp.id_area);
            $("#entcitas-id_tipo_entrega").val(resp.id_tipo_entrega);
        },
        error: function(){
            $("#txt_area").val('');
            $("#entcitas-num_dias_servicio").val('');
            $("#txt_tipo_entrega").val('');           
        }
    });
}

function limpiarCamposEstado(){
    $("#txt_area").val('');
}