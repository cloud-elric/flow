<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-citas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_tipo_tramite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_equipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_sim_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_tipo_entrega')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_usuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_dias_servicio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_clave_sap_equipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_descripcion_equipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_serie_equipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_clave_sim_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_descripcion_sim')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_serie_sim_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_nombre_completo_cliente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_numero_referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_numero_referencia_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_numero_referencia_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_calle_numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_colonia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_codigo_postal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_municipio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_entre_calles')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_observaciones_punto_referencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fch_cita')->textInput() ?>

    <?= $form->field($model, 'fch_hora_cita')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
