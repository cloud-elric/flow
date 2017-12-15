var buttonSubmit = '<button type="submit" '+
'id="submit-button-ladda" '+
'class="btn btn-success ladda-button pull-right" '+
'data-style="zoom-in">'+
'<span class="ladda-label">'+
'Validar crédito'+
'</span>'+
'<span class="ladda-spinner"></span>'+
'</button>';
var inputNombre = $("#entcitas-txt_nombre");
var inputApellidoPaterno = $("#entcitas-txt_apellido_paterno");
var inputApelllidoMaterno = $("#entcitas-txt_apellido_materno");
var inputFchNacimiento = $("#entcitas-fch_nacimiento");
var inputRFC = $("#entcitas-txt_rfc");
var cargarSupervisores = false;
var formCita = $("#form-cita");
var botonEnviar = "submit-button-ladda";

$(document).ready(function(){

    $("#entcitas-id_tipo_entrega").on("change", function(){
        
                           
        if($(this).val()==2){
            $('#entcitas-fch_cita').kvDatepicker('destroy');
            $('#entcitas-fch_cita').attr("readonly", true);
            $("#entcitas-fch_cita").val(getTomorrow());
            
        }else{
            var fechaEntrega = getFechaEntrega();
            $("#entcitas-fch_cita").val(fechaEntrega);
            $('#entcitas-fch_cita').kvDatepicker(
                {"autoclose":true,
                "format":"dd-mm-yyyy",
                "startDate":fechaEntrega,
                "language":"es",  
                daysOfWeekDisabled: "0"
            });
            $('#entcitas-fch_cita').attr("readonly", false);
            
                
        }

        $("#entcitas-fch_cita").trigger("change");

    });

    formCita.on('beforeSubmit', function(e) {
        var form = $(this);
        var button = document.getElementById(botonEnviar);
        var l = Ladda.create(button);
    
        if (form.find('.has-error').length) {
            
            l.stop();
            return false;
        }

        if(($("#entcitas-id_tipo_entrega").val()==2)){
            l.stop();
            
            
            if(!cargarSupervisores && !$("#express-autorizado").val()){
                $("#modal-express-autorizar").modal("show");
                cargarSupervisoresPeticion();
                //cargarSupervisores = true;
                return false;
            }
            
        }

    });
    
    formCita.on('afterValidate', function (e, messages, errorAttributes) {
        
        if(errorAttributes.length > 0){
            
            var button = document.getElementById(botonEnviar);
            var l = Ladda.create(button);
            l.stop();
            return false;
        }
        
    });

    


    $("#js-btn-autorizar").on("click", function(e){
      e.preventDefault();
        var token = $(this).data("token");

        if($("#entcitas-txt_imei").val()==""){
            $("#w0").yiiActiveForm('updateAttribute', 'entcitas-txt_imei', ["IMEI debe ser ingresado"]);
            swal("Espera", "Para autorizar debe ingresar el IMEI.", "warning");
            return false;
        }else{
            $("#w0").yiiActiveForm('updateAttribute', 'entcitas-txt_imei', "");
            var imei = $("#entcitas-txt_imei").val();
        }


        swal({
            title: "Autorización",
            text: "¿Estas seguro de autorizar esta cita?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, autorizar cita",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    $.post(baseUrl+"citas/autorizar?token="+token, {imei:imei})
                    .done(function (data) {
                        $(".js-status-cita").html("Autorizada");
                        $(".js-motivo-cancelacion").remove();
                        $(".token-envio").html(data.envio);
                      resolve();
                    }).error(function(){
                        swal("Error", "Un problema ha ocurrido al intentar guardar la información.", "error");
                        reject();
                    });
                     // resolve()
                   
                })
              },
              allowOutsideClick: false
            }).then(function (email) {
                console.log(email);
                swal("Autorizada", "Cita ha sido autorizada.", "success");
                window.location.href = "index";
            })

    });

    $("#js-btn-update").on("click", function(e){
        e.preventDefault();
        var token = $(this).data("token");


        swal({
            title: "Estas seguro?",
            text: "Estas actualizando este documento!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, actualizarlo!'
          }).then(function () {
            swal(
              'Actualizado!',
              'Se a actualizado este documento.',
              'success'
            )
            $("#entcitas-num_dias_servicio").prop('disabled', false);
            $('#w0').submit();
        })
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

    $("#entcitas-id_estado").on("change", function(){
        var id = $(this).val();

        if(id){
            buscarEstado(id);
        }else{
            limpiarCamposEstado();
        }

    });

    $("#entcitas-txt_colonia").on("change", function(){
        var id = $(this).val();
        
        if(id){
            buscarMunicipioByColonia($(this).val());
        }
    });

    $("#entcitas-id_tipo_plan_tarifario").on("change", function(){
        var idPlan = $(this).val();
        
        getCostoRenta(idPlan);
        getCostodiferidoEquipo();
    });

    //Seleccionar colonia en select
    var idColonia = $('#entcitas-txt_colonia option').filter(function () { return $(this).html() == $("#texto_colonia").val(); }).val();    
    $("#entcitas-txt_colonia").val(idColonia).change();
});

$(window).on('load', function() {
    $("#entcitas-id_area").trigger("change");
    $("#entcitas-txt_codigo_postal").trigger("change");
    $("#entcitas-id_tipo_plan_tarifario").trigger("change");      
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

function buscarEstado(id){
    $.ajax({
        url: baseUrl+"estados/get-estado?id="+id,
        success:function(resp){
            var area = '';
            var entrega = '';
            if(resp.txt_nombre){
                area = resp.txt_nombre;
            }
            if(resp.id_tipo_entrega == 1){
                entrega = 'Terrestre';
            }else{
                entrega = 'Aerea';
            }
            $("#txt_area").val(area);
            $("#entcitas-num_dias_servicio").val(resp.txt_dias_servicio);
            $("#txt_tipo_entrega").val(entrega);

            $("#entcitas-id_area").val(resp.id_area);
            $("#entcitas-id_tipo_entrega").val(resp.id_tipo_entrega);
            $("#entcitas-id_area").trigger("change");
            $("#entcitas-txt_colonia").trigger("change");           
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

function getCostodiferidoEquipo(){
    
        var equipo = $("#entcitas-id_equipo").val();
        var planTarifario = $("#entcitas-id_tipo_plan_tarifario").val();
        var plazo = $("#entcitas-id_plazo").val();
    
        var data = {
            idEquipo: equipo,
            idPlanTarifario: planTarifario,
            idPlazo: plazo,
        };
    
        $.ajax({
            url: baseUrl+"equipos/get-costo-equipo",
            method: "POST",
            data: data,
            success: function (res){
                if(res.status=="success"){
                    $("#entcitas-num_costo_equipo").val(res.costo);
                    $("#costo_equipo").val(res.costo);
                }else{
                    $("#entcitas-num_costo_equipo").val(0);
                    $("#costo_equipo").val(0);
                }
            }
        });
    }
    
    function getCostoRenta(idPlanTarifario){
        $.ajax({
            url: baseUrl+"planes-tarifarios/get-costo-plan?idPlan="+idPlanTarifario,
            success:function(res){
                if(res.status=="success"){
                    $("#entcitas-num_costo_renta").val(res.costo);
                    $("#costo_renta").val(res.costo);
                }else{
                    $("#entcitas-num_costo_renta").val(0);
                    $("#costo_renta").val(0);
                }
            }
        });
    }

    function buscarMunicipioByColonia(colonia){
        $.ajax({
            url: baseUrl+"municipios/get-municipio-by-colonia?colonia="+colonia,
            success:function(resp){
                console.log(resp);
                $("#entcitas-txt_municipio").val(resp.municipio.txt_nombre);
                $("#txt_municipio").val(resp.municipio.txt_nombre);
                $("#entcitas-id_estado").val(resp.estado.id_estado);
                $("#txt_estado").val(resp.estado.txt_nombre);
            }
        });
    }

    function getTomorrow(){
        var currentDate = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
        var day = ("0" + currentDate.getDate()).slice(-2)
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2)
        var year = currentDate.getFullYear()
      
        return day+"-"+month+"-"+year;
    }
    
    function getFechaEntrega(){
        var currentDate = new Date(new Date().getTime() + 48 * 60 * 60 * 1000);
        if(currentDate==7){
            var currentDate = new Date(new Date().getTime() + 72 * 60 * 60 * 1000);
        }
        var day = ("0" + currentDate.getDate()).slice(-2)
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2)
        var year = currentDate.getFullYear()
      
        return day+"-"+month+"-"+year;
    }

    function cargarSupervisoresPeticion(){
        
        $.ajax({
            url:baseUrl +"citas/form-pass-supervisor",
            success:function(resp){
                $(".contenedor-modal").html(resp);
                $("#express-autorizado").val("");
                $("#btn-autorizar-envio-express").show();
                $("#btn-success-autorizacion").hide();
               
                $("#alert-autorizacion").hide();
            }
        });
    }