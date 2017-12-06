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
use kartik\date\DatePicker;
use app\models\CatTiposClientes;
use app\models\CatCondicionesPlan;
use app\models\CatPlazos;
use app\models\CatTiposIdentificaciones;
use app\models\CatTiposPlanesTarifarios;
use app\models\RelEquipoPlazoCosto;
use app\models\RelCondicionPlanTarifario;
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
                    <a id="js-btn-update" class="btn btn-primary" data-token="<?=$model->txt_token?>"> 
                        <i class="icon fa-refresh"></i> Actualizar
                    </a>
                    <?php
                    if(\Yii::$app->user->can('supervisor-call-center')){
                    ?>
                    <a id="js-btn-autorizar" class="btn btn-success" href="#" data-token="<?=$model->txt_token?>"> 
                        <i class="icon fa-check"></i> Autorizar
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
        <div class="col-md-3">
            <?= $form->field($model, 'txt_telefono')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_apellido_materno')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'txt_email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?php 
                echo $form->field($model, 'fch_nacimiento')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => '16/12/1990'],
                    'pickerButton'=>false,
                    'removeButton'=>false,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd/mm/yyyy'
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_rfc')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_tipo_tramite')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(CatTiposTramites::find("b_habilitado=1")->orderBy('txt_nombre')->all(), 'id_tramite', 'txt_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccionar tipo de trámite'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'id_tipo_cliente')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(CatTiposClientes::find("b_habilitado=1")->orderBy('txt_nombre')->all(), 'id_tipo_cliente', 'txt_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccionar tipo de cliente'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>              
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'id_condicion_plan') ->widget(Select2::classname(), [
                'data' => ArrayHelper::map(CatCondicionesPlan::find("b_habilitado=1")->orderBy('txt_nombre')->all(), 'id_condicion_plan', 'txt_nombre'),
                'language' => 'es',
                'options' => ['placeholder' => 'Seleccionar condición del plan'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?> 
        </div>
        <div class="col-md-3">
            <?php 
            //Generar array con id del plan tarifario
            $idPlan = RelCondicionPlanTarifario::find()->where(['id_condicion_plan'=>$model->id_condicion_plan])->all();
            $idPlanesTarifarios = [];
            $i = 0;
            foreach($idPlan as $plan){
                $idPlanesTarifarios[$i] = $plan->id_plan_tarifario;
                $i = $i + 1;
            }

            echo $form->field($model, 'id_tipo_plan_tarifario')->widget(DepDrop::classname(), [
                'data'=> ArrayHelper::map(CatTiposPlanesTarifarios::find()->where(['in', 'id_tipo_plan', $idPlanesTarifarios])->all(), 'id_tipo_plan', 'txt_nombre'),
                'options' => [],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>[
                    'pluginOptions'=>[
                        
                        'allowClear'=>true,
                        'escapeMarkup' => new JsExpression('function (markup) { 
                            
                            return markup; }'),
                        'templateResult' => new JsExpression('formatRepoPlan'),
                    ],
                    ],
                'pluginOptions'=>[
                    'depends'=>['entcitas-id_condicion_plan'],
                    'url' => Url::to(['/condiciones-plan/get-planes-tarifarios']),
                    'loadingText' => 'Cargando planes ...',
                    'placeholder' => 'Seleccionar plan ...'
                ]
                
            ]);
            ?>
        </div>
        <div class="col-md-3">
        <?php 
            echo $form->field($model, 'id_plazo')->widget(DepDrop::classname(), [
                'data'=> ArrayHelper::map(CatPlazos::find()->all(), 'id_plazo', 'txt_nombre'),                
                'options' => [],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>[
                    'pluginOptions'=>[
                        'allowClear'=>true,
                        'escapeMarkup' => new JsExpression('function (markup) { 
                            
                            return markup; }'),
                        'templateResult' => new JsExpression('formatRepoPlan'),
                    ],
                    ],
                'pluginOptions'=>[
                    'depends'=>['entcitas-id_tipo_plan_tarifario'],
                    'url' => Url::to(['/planes-tarifarios/get-plazos']),
                    'loadingText' => 'Cargando plazos ...',
                    'placeholder' => 'Seleccionar plazo ...'
                ]
                
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?php
                require(__DIR__ . '/../components/scriptSelect2.php');
                $url = Url::to(['equipos/buscar-equipo']);
                $valEquipo = empty($model->id_equipo) ? '' : $equipo->txt_nombre;                                    
                //$equipo = empty($model->id_equipo) ? '' : CatEquipos::findOne($model->id_equipo)->txt_nombre;
                // render your widget
                echo $form->field($model, 'id_equipo')->widget(Select2::classname(), [
                    //'initValueText' => $cityDesc,
                    'options' => ['placeholder' => 'Seleccionar equipo'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
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
        <div class="col-md-3">
            <?=Html::label("Descripción de equipo","descripcion_equipo")?>
            <?=Html::textInput("descripcion_equipo", $equipo->txt_descripcion, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'descripcion_equipo'])?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?=Html::label("Costo diferido del equipo","costo_equipo")?>
                <?=Html::textInput("costo_equipo", '', ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'costo_equipo'])?>
                <?= $form->field($model, 'num_costo_equipo')->hiddenInput(['maxlength' => true, 'class'=>'form-control input-number'])->label(false) ?>
            </div>    
        </div>
        <div class="col-md-3">
            <?=Html::label("Costo de renta","costo_renta")?>
            <?=Html::textInput("costo_renta", '', ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'costo_renta'])?>
            <?= $form->field($model, 'num_costo_renta')->hiddenInput(['maxlength' => true, 'class'=>'form-control input-number'])->label(false) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'txt_numero_telefonico_nuevo')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'txt_imei')->textInput(['maxlength' => true]) ?>
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-md-4">
          
        </div>              
        <div class="col-md-4">
            <?=$form->field($model, 'num_cantidad_deposito', ['template'=>'<div class="container-monto">{label}{input}{error}</div>'])->textInput(["class"=>'form-control input-number'])?>
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
                <input id="texto_colonia" type="hidden" name="colonia" value="<?= $model->txt_colonia ?>">
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
                                'templateSelection' => new JsExpression('function (colonia) { return colonia.text; }'),
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

        <div class="row">
            
            <div class="col-md-3">
                <?= $form->field($model, 'txt_numero_referencia')->textInput(['maxlength' => true, "class"=>'form-control input-number']) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'txt_numero_referencia_2')->textInput(['maxlength' => true, "class"=>'form-control input-number']) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'txt_numero_referencia_3')->textInput(['maxlength' => true, "class"=>'form-control input-number']) ?>
            </div>
            
        </div>
        <div class="row">
        <div class="col-md-3">
                <?= $form->field($model, 'id_tipo_identificacion')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(CatTiposIdentificaciones::find("b_habilitado=1")->orderBy('txt_nombre')->all(), 'id_tipo_identificacion', 'txt_nombre'),
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccionar tipo de identificación'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'txt_folio_identificacion')->textInput(['maxlength' => true]) ?>
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
                <?=Html::textInput("txt_tipo_entrega", $model->idTipoEntrega->txt_nombre, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'txt_tipo_entrega' ])?>
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
