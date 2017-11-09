<?php

use yii\web\View;
$resultsJs = <<< JS
function (data, params) {
    
    params.page = params.page || 1;
    return {
        results: data.results,
        pagination: {
            more: (params.page * 10) < data.total_count
        }
    };
}
JS;

$formatJs = <<< 'JS'
var formatRepo = function (repo) {
    var ajaxResults = $('#entcitas-fch_hora_cita').depdrop('getAjaxResults');
    var cantidadDisponible = 0;
   
    if (repo.loading) {
        return repo.text;
    }


    if(!repo.loading){
        for($i=0; $i<ajaxResults["output"].length; $i++){

            if(ajaxResults["output"][$i]['id'] == repo.id){
                cantidadDisponible = ajaxResults["output"][$i]['cantidad'];
            }
        }
    }
    var markup =
'<div class="row">' + 
    '<div class="col-md-8">' +
        '<b style="margin-left:5px">' + repo.text + '</b>' + 
    '</div>' +
    '<div class="col-md-4">' + cantidadDisponible + '</div>' +
'</div>';
    
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
JS;
 
// Register the formatting script
$this->registerJs($formatJs, View::POS_HEAD);
 
?>