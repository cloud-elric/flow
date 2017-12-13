$(document).ready(function(){
    $("#js-btn-autorizar").on('click', function(e){
        e.preventDefault();
        var url = $(this).data("url");
        console.log($(this).data("url"));
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then(function () {
            swal(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
            window.location.href = baseUrl + url;

        }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
              swal(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
              )
            }
        })
    });

    $("#js-btn-rechazar").on('click', function(e){
        e.preventDefault();
        console.log(baseUrl + $(this).data("url"));
        swal({
            title: 'Submit email to run ajax request',
            input: 'motivo',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: function (motivo) {
              return new Promise(function (resolve, reject) {
                setTimeout(function() {
                  if (motivo === 'taken@example.com') {
                    reject('This email is already taken.')
                  } else {
                    resolve()
                  }
                }, 2000)
              })
            },
            allowOutsideClick: false
        }).then(function (motivo) {
            swal({
              type: 'success',
              title: 'Ajax request finished!',
              html: 'Submitted email: ' + motivo
            })
            $.ajax({
                url: baseUrl + $(this).data("url") + '&texto' + motivo,
                data: {texto: motivo},
            });
        })
    });

    $("#js-btn-cancelar").on('click', function(e){
        swal({
            title: 'Submit email to run ajax request',
            input: 'motivo',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: function (motivo) {
              return new Promise(function (resolve, reject) {
                setTimeout(function() {
                  if (motivo === 'taken@example.com') {
                    reject('This email is already taken.')
                  } else {
                    resolve()
                  }
                }, 2000)
              })
            },
            allowOutsideClick: false
        }).then(function (motivo) {
            swal({
              type: 'success',
              title: 'Ajax request finished!',
              html: 'Submitted email: ' + motivo
            })
            $.ajax({
                url: baseUrl + $(this).data("url") + '&texto' + motivo,
                data: {texto: motivo},
            });
        })
    });
});