var inputNombre = $("#entcitas-txt_nombre");
var inputApellidoPaterno = $("#entcitas-txt_apellido_paterno");
var inputApelllidoMaterno = $("#entcitas-txt_apellido_materno");
var inputFchNacimiento = $("#entcitas-fch_nacimiento");
var inputRFC = $("#entcitas-txt_rfc");

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

    $("#entcitas-id_tipo_plan_tarifario").on("change", function(){
        var idPlan = $(this).val();
        
        getCostoRenta(idPlan);
    });

});

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

