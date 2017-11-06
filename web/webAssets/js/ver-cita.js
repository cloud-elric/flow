$(document).ready(function(){
    $("#js-btn-autorizar").on("click", function(e){
      e.preventDefault();
        var token = $(this).data("token");

        swal({
            title: "Autorización",
            text: "¿Estas seguro de autorizar esta cita?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirmar: {
                  text: "Autorizar",
                  value: token,
                  closeModal: false,
                },
              },
            dangerMode: true,
          })
          .then((value) => {
            if(value){
              return fetch(baseUrl+"citas/autorizar?token="+value);
            }
          }).then(results => {
            if (results){
                return results.json();
            }
          })
          .then(json => {
              if(json){
                  $(".js-status-cita").html("Autorizada");
                  $(".js-motivo-cancelacion").remove();
                  $(".token-envio").html(json.envio);
                  swal("Autorizada", "Cita ha sido autorizada. Clave de envio"+json.envio, "success");
              } 
          }).catch(err => {
            if (err) {
              swal("Oh noes!", "The AJAX request failed!", "error");
            } else {
              swal.stopLoading();
              swal.close();
            }
          });
    });

    $("#js-btn-update").on("click", function(e){
        e.preventDefault();
        var token = $(this).data("token");

        swal({
          title: "Estas seguro?",
          text: "Estas actualizando este documento!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Actualizado! Se a actualizado este documento.", {
              icon: "success",
            });
            $('#w0').submit();
          } else {
            swal("Este documento no tiene cambios!");
          }
        });
    });

    $("#js-btn-rechazar").on("click", function(e){
        e.preventDefault();
        var token = $(this).data("token");
        
        $("#cita-rechazo-modal").modal("show")
          
    });

    $("#js-btn-cancelar").on("click", function(e){
        e.preventDefault();
        var token = $(this).data("token");
        
        $("#cita-cancelacion-modal").modal("show")
          
    });
    
    
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