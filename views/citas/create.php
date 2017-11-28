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
use kartik\depdrop\DepDrop;
use app\models\CatTiposPlanes;
use app\models\CatTiposClientes;
use app\models\CatCondicionesPlan;
use kartik\date\DatePicker;
use app\models\CatTiposIdentificaciones;
use app\models\CatTiposDepositosGarantia;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = 'Captura de cita';
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-calendar"></i>Citas', 'url' => ['index'], 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => '<i class="icon fa-plus"></i>Agregar cita', 'encode' => false];

$this->registerCssFile(
    '@web/webAssets/plugins/select2/select2.css',
    ['depends' => [kartik\select2\Select2Asset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/js/crear-cita.js',
    ['depends' => [kartik\select2\Select2Asset::className()]]
);
?>

<div class="panel">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel-heading">
        <h2 class="panel-title">
            Equipo y tipo de trámite
            <hr>
        </h2>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'txt_apellido_materno')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'txt_telefono')->textInput(['maxlength' => true, 'class'=>'form-control input-number']) ?>
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
                <?= $form->field($model, 'id_tipo_tramite')
                                ->widget(Select2::classname(), [
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
                <?= $form->field($model, 'id_tipo_cliente')
                                        ->widget(Select2::classname(), [
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
                <?= $form->field($model, 'id_condicion_plan')
                                            ->widget(Select2::classname(), [
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
                echo $form->field($model, 'id_tipo_plan_tarifario')->widget(DepDrop::classname(), [
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
                            'templateSelection' => new JsExpression('function (equipo) { return equipo.txt_nombre; }'),
                        ],
                    ]);
                
                ?>
            </div>
            <div class="col-md-3">
                <?=Html::label("Descripción de equipo","descripcion_equipo")?>
                <?=Html::textInput("descripcion_equipo", '', ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'descripcion_equipo'])?>
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

        <div class="js-pago-contraentrega">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'id_tipo_deposito_garantia')
                                                ->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(CatTiposDepositosGarantia::find("b_habilitado=1")->orderBy('txt_nombre')->all(), 'id_tipo_deposito_garantia', 'txt_nombre'),
                                                    'language' => 'es',
                                                    'options' => ['placeholder' => 'Seleccionar condición del plan'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                    ?>
                </div>              
                <div class="col-md-3">
                <?=$form->field($model, 'num_monto_cod', ['template'=>'<div class="container-monto">{label}{input}{error}</div>'])->textInput(["class"=>'form-control input-number'])?>
                </div>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?= Html::submitButton('Pasar a autorización', ['class' => "btn-success btn-lg btn-block"]) ?>
            </div>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>