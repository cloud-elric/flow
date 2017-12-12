$(document).on({
    'click': function(e){
        e.preventDefault();
        $("#alert-autorizacion").hide();
                var button = document.getElementById("btn-autorizar-envio-express");
                var l = Ladda.create(button);
                var data = $("#form-autorizar-supervisor").serialize();
                l.start();
                $.ajax({
                    url:baseUrl+"citas/validar-pass-supervisor",
                    data:data,
                    method: "POST",
                    success:function(resp){

                        if(resp.status=='success'){
                            $("#express-autorizado").val(resp.mensaje);
                            $("#btn-autorizar-envio-express").hide();
                            $("#btn-success-autorizacion").show();
                        }else{
                            $("#alert-autorizacion").html(resp.mensaje);
                            $("#alert-autorizacion").show();
                        }
                        l.stop();
                    },
                    error: function(){
                        l.stop();
                    }
                });
    }
}, "#btn-autorizar-envio-express");

$(document).on({
    'click': function(e){
        e.preventDefault();
        $("#modal-express-autorizar").modal("hide");
               
    }
}, "#btn-success-autorizacion");

