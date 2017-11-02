$(document).ready(function(){
    $(".js-autorizar-cita").on("click", function(){
        var token = $(this).data("token");

        swal({
            title: "Autorización",
            text: "¿Estas seguro de autorizar esta cita?",
            icon: "warning",
            buttons: {
                cancel: true,
                confirmar: {
                  text: "Autorizar",
                  value: "catch2",

                },
              },
            dangerMode: true,
          })
          .then((value) => {

            return fetch(baseUrl+"citas/autorizar");
          }).catch(err => {
            if (err) {
              swal("Oh noes!", "The AJAX request failed!", "error");
            } else {
              swal.stopLoading();
              swal.close();
            }
          });
    });
});