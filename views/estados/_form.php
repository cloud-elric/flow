<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CatEstados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-estados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_latitud')->textInput() ?>

    <?= $form->field($model, 'num_longitud')->textInput() ?>

    <?= $form->field($model, 'b_habilitado')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
