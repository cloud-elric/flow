var inputNombre = $("#entcitas-txt_nombre");
var inputApellidoPaterno = $("#entcitas-txt_apellido_paterno");
var inputApelllidoMaterno = $("#entcitas-txt_apellido_materno");
var inputFchNacimiento = $("#entcitas-fch_nacimiento");
var inputRFC = $("#entcitas-txt_rfc");
var cargarSupervisores = false;
var formCita = $("#form-cita");
var botonEnviar = "submit-button-ladda";

$(document).ready(function(){


    inputNombre.on("change", function(){
        calculaRFC();
    });

    inputApellidoPaterno.on("change", function(){
        calculaRFC();
    });

    inputApelllidoMaterno.on("change", function(){
        calculaRFC();
    });

    inputFchNacimiento.on("change", function(){
        calculaRFC();
    });


    $("#entcitas-id_equipo").on("change", function(){
        var id = $(this).val();

        getCostodiferidoEquipo();
    

        if(id){
            buscarEquipo(id);
        }else{
            limpiarCamposEquipo();
        }

    });

    $("#entcitas-txt_colonia").on("change", function(){
        buscarMunicipioByColonia($(this).val());
    });


    $("#entcitas-id_sim_card").on("change", function(){
        var id = $(this).val();

        if(id){
            buscarSim(id);
        }else{
            limipiarCamposSim();
        }

    });

    $("#entcitas-b_deposito_contra_entrega").on("change", function(){
        //alert($(this).prop("checked"));
        if($(this).prop("checked")){
            $(".container-monto").show();
        }else{
            $(".container-monto").hide();
            $("#entcitas-num_cantidad_deposito").val('');
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

    $("#entcitas-id_tipo_deposito_garantia").on("change", function(){
        
        if($(this).val()==2){
            $("#entcitas-num_monto_cod").val($("#entcitas-num_costo_equipo").val());    
            $(".container-monto").show();
        }else{
            $("#entcitas-num_monto_cod").val(0);
            $(".container-monto").hide();
        }
    });

    $("#entcitas-id_tipo_plan_tarifario").on("change", function(){
        var idPlan = $(this).val();
        
        getCostoRenta(idPlan);
        getCostodiferidoEquipo();
    });

    $("#entcitas-id_condicion_plan").on("change", function(){
        $("#entcitas-num_costo_equipo").val("");
        $("#costo_equipo").val("");
    });

    $("#entcitas-id_plazo").on("change", function(){
        getCostodiferidoEquipo();
    });

    var buttonSubmit = '<button type="submit" '+
    'id="submit-button-ladda" '+
    'class="btn btn-success ladda-button pull-right" '+
    'data-style="zoom-in">'+
    '<span class="ladda-label">'+
    'Validar crédito'+
    '</span>'+
    '<span class="ladda-spinner"></span>'+
    '</button>';

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

     formCita.on('afterValidateAttribute', function (e, attribute, messages) {
        
         if(attribute.name=="txt_telefono"){
             if(messages.length==0){
                 generarRegistro();
             }
         }
        
     });

});

$(window).on('load', function() {
    $("#entcitas-id_tipo_plan_tarifario").trigger("change");  
});

function generarRegistro(){
    var telefono = $("#entcitas-txt_telefono").val();
    $.ajax({
        url:baseUrl+"citas/generar-registro?tel="+telefono,
        success:function(resp){
            if(resp.status=="success"){
                $("#entcitas-id_cita").val(resp.identificador);
                
            }else if($("#entcitas-id_cita").val()!=resp.identificador){
                formCita.yiiActiveForm('updateAttribute', 'entcitas-txt_telefono', ["No se puede generar el registro con un número teléfonico repetido"]);
            }
        }
    });
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

function validarDia(){

}

function buscarMunicipioByColonia(colonia){
    $.ajax({
        url: baseUrl+"municipios/get-municipio-by-colonia?colonia="+colonia,
        success:function(resp){
            $("#entcitas-txt_municipio").val(resp.municipio.txt_nombre);
            $("#txt_municipio").val(resp.municipio.txt_nombre);
            $("#entcitas-id_estado").val(resp.estado.id_estado);
            $("#txt_estado").val(resp.estado.txt_nombre);
            $("#entcitas-id_estado").trigger("change");
            
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
            var inputImei = '<div class="col-md-3">'+
            '<div class="form-group field-entcitas-txt_imei required">'+
            '<label class="control-label" for="entcitas-txt_imei">IMEI</label>'+
            '<input type="text" id="entcitas-txt_imei" class="form-control" name="EntCitas[txt_imei]" maxlength="150" aria-required="true"'+ 
            'aria-invalid="true">'+
            '<div class="help-block"></div>'+
            '</div></div>';
            if(resp.txt_descripcion){
                descripcion = resp.txt_descripcion;
            }

            if(resp.b_inventario_virtual=="1"){
                $(".contenedor-imei").html(inputImei);
               formCita.yiiActiveForm('add', {
                    id: 'entcitas-txt_imei',
                    name: 'EntCitas[txt_imei]',
                    container: '.field-entcitas-txt_imei',
                    input: '#entcitas-txt_imei',
                    error: '.help-block',
                    validate:  function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {message: "IMEI es requerido"});
                    }
                });
            }else{
                $(".contenedor-imei").html("");
                $('#contact-form').yiiActiveForm('remove','entcitas-txt_imei');
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

                if(res.costo==0){
                    $("#costo_equipo").val("Gratuito");
                    $(".js-pago-contraentrega").hide();
                }else{
                    $(".js-pago-contraentrega").show();
                }
            }else{
                $("#entcitas-num_costo_equipo").val(0);
                $("#costo_equipo").val("");
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
                $("#entcitas-num_costo_renta").val();
                $("#costo_renta").val("");
            }
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
            $("#num_dias_servicio").val(resp.txt_dias_servicio);
            

            $("#entcitas-id_area").val(resp.id_area);
            
            $("#entcitas-id_area").trigger("change");
        },
        error: function(){
            $("#txt_area").val('');
            $("#entcitas-num_dias_servicio").val('');
            $("#num_dias_servicio").val('');
                      
        }
    });
}

function limpiarCamposEstado(){
    $("#txt_area").val('');
}

function calculaRFC() {
	function quitaArticulos(palabra) {
		return palabra.replace("DEL ", "").replace("LAS ", "").replace("DE ",
				"").replace("LA ", "").replace("Y ", "").replace("A ", "");
	}
	function esVocal(letra) {
		if (letra == 'A' || letra == 'E' || letra == 'I' || letra == 'O'
				|| letra == 'U' || letra == 'a' || letra == 'e' || letra == 'i'
				|| letra == 'o' || letra == 'u')
			return true;
		else
			return false;
	}
	nombre = inputNombre.val().toUpperCase();
	apellidoPaterno = inputApellidoPaterno.val().toUpperCase();
	apellidoMaterno = inputApelllidoMaterno.val().toUpperCase();
	fecha = inputFchNacimiento.val();
	var rfc = "";
	apellidoPaterno = quitaArticulos(apellidoPaterno);
	apellidoMaterno = quitaArticulos(apellidoMaterno);
	rfc += apellidoPaterno.substr(0, 1);
	var l = apellidoPaterno.length;
	var c;
	for (i = 0; i < l; i++) {
		c = apellidoPaterno.charAt(i);
		if (esVocal(c) && i>0) {
			rfc += c;
			break;
		}
	}
	rfc += apellidoMaterno.substr(0, 1);
	rfc += nombre.substr(0, 1);
	rfc += fecha.substr(8, 10);
	rfc += fecha.substr(3, 5).substr(0, 2);
	rfc += fecha.substr(0, 2);
	// rfc += "-" + homclave;
	inputRFC.val(rfc);
}

