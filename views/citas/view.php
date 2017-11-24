<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\CatTiposTramites;
use app\models\CatEquipos;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\bootstrap\Modal;
use kartik\depdrop\DepDrop;

use app\models\CatColonias;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = "Revisión de cita";
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-calendar"></i>Citas', 'url' => ['index'], 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-mobile"></i> '.$this->title, 'encode' => false];

$tramite = $model->idTipoTramite;
$equipo = $model->idEquipo;
$status = $model->idStatus;
$simCard = $model->idSimCard;
$estado = $model->idEstado;

$this->registerCssFile(
    '@web/webAssets/plugins/select2/select2.css',
    ['depends' => [kartik\select2\Select2Asset::className()]]
);


$this->registerJsFile(
    '@web/webAssets/js/ver-cita.js',
    ['depends' => [kartik\select2\Select2Asset::className()]]
);
?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <h4>
                Estatus de cita: <span class="js-status-cita"><?=$status->txt_nombre?></span>
                <div class="pull-right">
                    <?php
                    if(\Yii::$app->user->can('supervisor-call-center')){
                    ?>
                    <a id="js-btn-autorizar" class="btn btn-success" href="#" data-token="<?=$model->txt_token?>"> 
                        <i class="icon fa-check"></i> Autorizar
                    </a>
                    <a id="js-btn-update" class="btn btn-primary" data-token="<?=$model->txt_token?>"> 
                        <i class="icon fa-refresh"></i> Actualizar
                    </a>
                    <a id="js-btn-rechazar" class="btn btn-warning" data-token="<?=$model->txt_token?>"> 
                        <i class="icon fa-times"></i> Rechazar
                    </a>
                    <a id="js-btn-cancelar" class="btn btn-danger" data-token="<?=$model->txt_token?>"> 
                        <i class="icon fa-trash"></i> Cancelar
                    </a>
                    <?php
                    }
                    ?>
                </div>
            </h4>
            <?php
            if($model->txt_motivo_cancelacion){
            ?>
            <h6 class="js-motivo-cancelacion">Motivo de cancelación/rechazo   <br>         
                <?=$model->txt_motivo_cancelacion?>
            </h6>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="panel">
    <?php $form = ActiveForm::begin(['action' =>['update?token=' . $model->txt_token]]); ?>
    <div class="panel-heading">
        <h2 class="panel-title">
            Equipo y tipo de trámite
            <hr>
        </h2>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'txt_telefono')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_tipo_tramite')
                    ->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(CatTiposTramites::find("b_habilitado=1")->all(), 'id_tramite', 'txt_nombre'),
                        'language' => 'es',
                        'options' => ['placeholder' => 'Seleccionar tipo de trámite'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>                
            </div>
            <div class="col-md-4">
                <h6 class="token-envio">
                <?php
                if($model->id_envio){
                    echo $model->idEnvio->txt_token;
                }
                ?>
                    </h6>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                    require(__DIR__ . '/../components/scriptSelect2.php');
                    $url = Url::to(['equipos/buscar-equipo']);
                    $valEquipo = empty($model->id_equipo) ? '' : $equipo->txt_nombre;
                    // render your widget
                    echo $form->field($model, 'id_equipo')->widget(Select2::classname(), [
                        'initValueText' => $valEquipo,
                        'options' => ['placeholder' => 'Seleccionar equipo'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 4,
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                'processResults' => new JsExpression($resultsJs),
                                'cache' => true
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(equipo) { return equipo.txt_nombre; }'),
                            'templateSelection' => new JsExpression('function (equipo) { 
                                if(equipo.txt_nombre){
                                    return equipo.txt_nombre; 
                                }else{
                                    return "'.$valEquipo.'"
                                }
                                
                            }'),
                        ],
                    ]);
                ?>                
            </div>
            <div class="col-md-4">
                <?=Html::label("Descripción de equipo","descripcion_equipo")?>
                <?=Html::textInput("descripcion_equipo", $equipo->txt_descripcion, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'descripcion_equipo'])?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'txt_imei')->textInput(['maxlength' => true]) ?>                          
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php
                    require(__DIR__ . '/../components/scriptSelect2.php');
                    $url = Url::to(['sims-cards/buscar-sim']);
                    $valSim = empty($model->id_sim_card) ? '' : $simCard->txt_nombre;
                    // render your widget
                    echo $form->field($model, 'id_sim_card')->widget(Select2::classname(), [
                        'initValueText' => $valSim,                    
                        'options' => ['placeholder' => 'Seleccionar equipo'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 4,
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                'processResults' => new JsExpression($resultsJs),
                                'cache' => true
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(sim) { return sim.txt_nombre; }'),
                            'templateSelection' => new JsExpression('function (sim) { 
                                if(sim.txt_nombre){
                                    return sim.txt_nombre; 
                                }else{
                                    return "'.$valSim.'"
                                }
                            }'),
                        ],
                    ]);
                ?>  
            </div>
            <div class="col-md-4">
                <?=Html::label("Descripción SIM Card", "descripcion_sim_card")?>
                <?=Html::textInput("descripcion_sim_card", $simCard->txt_descripcion, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'descripcion_sim' ])?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'txt_iccid')->textInput(['maxlength' => true]) ?>                          
            </div>
        </div>
        
    </div>

    <div class="panel-heading">
        <h2 class="panel-title">  
                Información de contacto
                <hr>
        </h2>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'txt_nombre_completo_cliente')->textInput(['maxlength' => true]) ?>                        
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'txt_numero_referencia')->textInput(['maxlength' => true, "class"=>'form-control input-number']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'txt_numero_referencia_2')->textInput(['maxlength' => true, "class"=>'form-control input-number']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?php
                    require(__DIR__ . '/../components/scriptSelect2.php');
                    $url = Url::to(['codigos-postales/buscar-codigo']);
                    // render your widget
                    echo $form->field($model, 'txt_codigo_postal')->widget(Select2::classname(), [
                        'initValueText' => empty($model->id_estado) ? '' : $estado->txt_nombre,
                        'options' => ['placeholder' => 'Seleccionar código postal'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'delay' => 250,
                                'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                'processResults' => new JsExpression($resultsJs),
                                'cache' => true
                            ],
                            'pluginEvents' => [
                                "change" => "function() { log('change'); }"
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(equipo) { return equipo.txt_nombre; }'),
                            'templateSelection' => new JsExpression('function (equipo) { 
                                if(equipo.txt_nombre){
                                    return equipo.txt_nombre;
                                }else{
                                    return "'.$model->txt_codigo_postal.'"
                                }
                            }'),
                        ],
                    ]);
                ?>
            </div>
            <div class="col-md-4">
                <?php 
                    echo $form->field($model, 'txt_colonia')->widget(DepDrop::classname(), [
                        'data'=> ArrayHelper::map(CatColonias::find()->where(['txt_codigo_postal'=>$model->txt_codigo_postal])->all(), 'id_colonia', 'txt_nombre'),
                        'options' => ['placeholder' => 'Seleccionar ...'],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options'=>[
                            'pluginOptions'=>[
                                
                                'allowClear'=>true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(colonia) {return colonia.text; }'),
                                'templateSelection' => new JsExpression('function (colonia) {
                                    return colonia.text;
                                }'),
                            ],
                            ],
                        'pluginOptions'=>[
                            'depends'=>['entcitas-txt_codigo_postal'],
                            'url' => Url::to(['/codigos-postales/get-colonias-by-codigo-postal?code='.$model->txt_codigo_postal]),
                            'loadingText' => 'Cargando colonias ...',
                        ]
                    ]);
                    ?>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                        <?=Html::label("Municipio", "txt_municipio", ['class'=>'control-label'])?>
                        <?=Html::textInput("txt_municipio", $model->txt_municipio, ['class'=>'form-control','disabled'=>'disabled', 'id'=>'txt_municipio' ])?>
                        <?= $form->field($model, 'txt_municipio')->hiddenInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group field-entcitas-txt_municipio">
                        <?=Html::label("Estado", "txt_estado", ['class'=>'control-label'])?>
                        <?=Html::textInput("txt_estado", $estado->txt_nombre, ['class'=>'form-control','disabled'=>'disabled', 'id'=>'txt_estado' ])?>
                        <?= $form->field($model, 'id_estado')->hiddenInput()->label(false)?>
                </div>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'txt_calle_numero')->textInput(['maxlength' => true]) ?>
            </div>
            <!-- <div class="col-md-4">
                
                
            </div> -->
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'txt_entre_calles')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'txt_observaciones_punto_referencia')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>

    <div class="panel-heading">
        <h2 class="panel-title">  
            Información de la cita
            <hr>
        </h2>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?=Html::label("Área", "txt_area")?>
                <?=Html::textInput("txt_area", $area->txt_nombre, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'txt_area' ])?>
                <?= $form->field($model, 'id_area')->hiddenInput(['value' => $area->id_area])->label(false) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'num_dias_servicio')->textInput(['maxlength' => true, "disabled"=>true]) ?>
            </div>
            <div class="col-md-4">
                <?=Html::label("Tipo de entrega", "txt_tipo_entrega")?>
                <?=Html::textInput("txt_tipo_entrega", $area->idTipoEntrega->txt_nombre, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'txt_tipo_entrega' ])?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                    $hoy = date("d-m-Y");
                    $tresDias = date("d-m-Y", strtotime($hoy . '+4 day'));
                ?>
                <?= $form->field($model, 'fch_cita')->widget(\yii\jui\DatePicker::classname(), [
                    'language' => 'es',
                    'options'=>['class'=>'form-control'],
                    'dateFormat' => 'dd-MM-yyyy', 
                    'clientOptions' => [
                        'minDate' => $tresDias, //date("d-m-Y")
                        'dayNamesShort' => ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
                        'dayNamesMin' => ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                        'beforeShowDay' => false             
                    ],    
                ])
                ?>
            </div>
            <div class="col-md-4">
                <?php
                echo $form->field($model, 'fch_hora_cita')->widget(DepDrop::classname(), [
                    'options' => ['placeholder' => 'Seleccionar ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options'=>[
                        'pluginOptions'=>[
                            
                            'allowClear'=>true,
                            'escapeMarkup' => new JsExpression('function (markup) { 
                                return markup; }'
                            ),
                            'templateResult' => new JsExpression('formatRepo'),
                        ],
                    ],
                    'pluginOptions'=>[
                        'depends'=>['entcitas-id_area'],
                        'url' => Url::to(['/horarios-areas/get-horarios-disponibilidad-by-area?fecha='.$model->fch_hora_cita]),
                        'loadingText' => 'Cargando horarios ...',  
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php 
Modal::begin([
    'header'=>'<h4>Motivo de rechazo</h4>',
    'id'=>'cita-rechazo-modal',
    
    //'size'=>'modal-lg',
]);
$model->scenario = 'cancelacion';
    $form = ActiveForm::begin([
        'id'=>'cita-rechazo-form',
        'action'=>'rechazar?token='.$model->txt_token
        ]);

    echo $form->field($model, 'txt_motivo_cancelacion')->textArea(['required'=>'required'])->label("Motivo de rechazo");

    echo Html::submitButton('Rechazar', ['class' => 'btn btn-warning']);

ActiveForm::end();
Modal::end();
?>


<?php 
Modal::begin([
    'header'=>'<h4>Motivo de cancelación</h4>',
    'id'=>'cita-cancelacion-modal',
    
    //'size'=>'modal-lg',
]);
$model->scenario = 'cancelacion';
    $form = ActiveForm::begin([
        'id'=>'cita-rechazo-form',
        'action'=>'rechazar?token='.$model->txt_token
        ]);

    echo $form->field($model, 'txt_motivo_cancelacion')->textArea(['required'=>'required'])->label("Motivo de cancelación");

    echo Html::submitButton('Cancelar cita', ['class' => 'btn btn-warning']);

ActiveForm::end();
Modal::end();
?>
