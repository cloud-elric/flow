<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-citas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_cita') ?>

    <?= $form->field($model, 'id_tipo_tramite') ?>

    <?= $form->field($model, 'id_equipo') ?>

    <?= $form->field($model, 'id_sim_card') ?>

    <?= $form->field($model, 'id_area') ?>

    <?php // echo $form->field($model, 'id_tipo_entrega') ?>

    <?php // echo $form->field($model, 'id_usuario') ?>

    <?php // echo $form->field($model, 'num_dias_servicio') ?>

    <?php // echo $form->field($model, 'txt_token') ?>

    <?php // echo $form->field($model, 'txt_clave_sap_equipo') ?>

    <?php // echo $form->field($model, 'txt_descripcion_equipo') ?>

    <?php // echo $form->field($model, 'txt_serie_equipo') ?>

    <?php // echo $form->field($model, 'txt_telefono') ?>

    <?php // echo $form->field($model, 'txt_clave_sim_card') ?>

    <?php // echo $form->field($model, 'txt_descripcion_sim') ?>

    <?php // echo $form->field($model, 'txt_serie_sim_card') ?>

    <?php // echo $form->field($model, 'txt_nombre_completo_cliente') ?>

    <?php // echo $form->field($model, 'txt_numero_referencia') ?>

    <?php // echo $form->field($model, 'txt_numero_referencia_2') ?>

    <?php // echo $form->field($model, 'txt_numero_referencia_3') ?>

    <?php // echo $form->field($model, 'txt_calle_numero') ?>

    <?php // echo $form->field($model, 'txt_colonia') ?>

    <?php // echo $form->field($model, 'txt_codigo_postal') ?>

    <?php // echo $form->field($model, 'txt_municipio') ?>

    <?php // echo $form->field($model, 'txt_entre_calles') ?>

    <?php // echo $form->field($model, 'txt_observaciones_punto_referencia') ?>

    <?php // echo $form->field($model, 'fch_cita') ?>

    <?php // echo $form->field($model, 'fch_hora_cita') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
