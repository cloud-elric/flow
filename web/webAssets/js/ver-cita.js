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
    


});