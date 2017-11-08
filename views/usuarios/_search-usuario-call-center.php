<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CatStatusCitas;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-usuarios-search">

    <?php $form = ActiveForm::begin([
        'id'=>'form-search',
        'action' => ['usuarios-call-center'],
        'method' => 'get',
        'options' => ['data-pjax' => true,'class'=>'page-search-form' ]
    ]); ?>

    <div class="row">
        <div class="col-md-4">
             <?= $form->field($model, 'txt_auth_item')
                                ->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map($usuariosCallCenter, 'name', 'description'),
                                    'language' => 'es',
                                    'options' => ['placeholder' => 'Seleccionar tipo de usuario'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                ?> 
        </div>

        <div class="col-md-4">
            <?php  echo $form->field($model, 'txt_username')->textInput(['maxlength' => true, 'class'=>'form-control']); ?>
        </div>

        <div class="col-md-4">
            <?php  echo $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true, 'class'=>'form-control']); ?>
        </div>
    </div>


    <div class="form-group">
    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary js-search-button', 'name'=>'isOpen', 'value'=>Yii::$app->request->get('isOpen')?'1':'0']) ?>
    <?= Html::button('Limpiar', ['class' => 'btn btn-default js-limpiar-campos']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
