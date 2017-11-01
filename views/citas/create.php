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

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = 'Captura de cita';
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-calendar"></i>Citas', 'url' => ['index'], 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => '<i class="icon fa-plus"></i>Agregar cita', 'encode' => false];

$this->registerCssFile(
    '@web/webassets/plugins/select2/select2.css',
    ['depends' => [kartik\select2\Select2Asset::className()]]
);

$this->registerJsFile(
    '@web/webassets/js/crear-cita.js',
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
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                require(__DIR__ . '/../components/scriptSelect2.php');
                $url = Url::to(['equipos/buscar-equipo']);
                // render your widget
                echo $form->field($model, 'id_equipo')->widget(Select2::classname(), [
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
            <div class="col-md-4">
                <?=Html::label("Descripción de equipo","descripcion_equipo")?>
                <?=Html::textInput("descripcion_equipo", '', ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'descripcion_equipo'])?>
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
                    // render your widget
                    echo $form->field($model, 'id_sim_card')->widget(Select2::classname(), [
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
                            'templateResult' => new JsExpression('function(sim) { return sim.txt_nombre; }'),
                            'templateSelection' => new JsExpression('function (sim) { return sim.txt_nombre; }'),
                        ],
                    ]);
                    
                    ?>  
               
            </div>
            <div class="col-md-4">
                <?=Html::label("Descripción SIM Card", "descripcion_sim_card")?>
                <?=Html::textInput("descripcion_sim_card", '', ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'descripcion_sim' ])?>
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
            <div class="col-md-8">
                <?= $form->field($model, 'txt_calle_numero')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'txt_colonia')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'txt_codigo_postal')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'txt_municipio')->textInput(['maxlength' => true]) ?>
            </div>
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
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'num_dias_servicio')->textInput(['maxlength' => true, "disabled"=>"disabled"]) ?>
            </div>
            <div class="col-md-4">
                <?=Html::label("Tipo de entrega", "txt_tipo_entrega")?>
                <?=Html::textInput("txt_tipo_entrega", $area->idTipoEntrega->txt_nombre, ['class'=>'form-control', 'disabled'=>'disabled', 'id'=>'txt_tipo_entrega' ])?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'fch_cita')->widget(\yii\jui\DatePicker::classname(), [
                    'language' => 'es',
                    'options'=>['class'=>'form-control'],
                    'dateFormat' => 'dd-MM-yyyy', ])
                ?>
            </div>
            <div class="col-md-4">
                <?php
               echo  $form->field($model, 'fch_hora_cita')
                    ->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($horarios, 'id_horario_area', 'horario'),
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccionar horario'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Crear cita' : 'Actualizar cita', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>