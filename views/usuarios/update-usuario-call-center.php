<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\EntUsuarios */

$this->title = 'Editar usuario:'.$model->nombreCompleto;
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-users"></i>Usuarios', 'url' => ['usuarios-call-center'], 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-edit"></i>'.$this->title, 'encode' => false];
$this->registerCssFile(
  '@web/webAssets/css/signUp.css',
  ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
  '@web/webAssets/js/sign-up.js',
  ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel">
      <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="brand text-center">
                    <a class="avatar avatar-lg js-img-avatar">
                        <img class="js-image-preview" src="<?=Url::base()."/webAssets/images/site/user.png"?>">
                        </a>
                    
                </div>
            </div>
            <div class="col-md-8">
 
                <?php $form = yii\widgets\ActiveForm::begin([
                            'id' => 'form-ajax',
                            //'options' => ['class' => 'form-horizontal'],
                            'enableAjaxValidation' => true,
                            'enableClientValidation'=>true,
                        ]); ?>

                <?= $form->field($model, 'image')->fileInput(["class"=>"hide"])->label(false) ?> 
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_username')->textInput(['maxlength' => true, 'placeholder'=>'Nombre'])->label(false) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_apellido_paterno')->textInput(['maxlength' => true, 'placeholder'=>'Apellido paterno'])->label(false) ?>
                </div>    
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_auth_item')
                                    ->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map($usuariosCallCenter, 'name', 'description'),
                                        'language' => 'es',
                                        'options' => ['placeholder' => 'Seleccionar tipo de usuario'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label(false);
                    ?> 
                </div>    
                <div class="col-md-6">
                    <?= $form->field($model, 'txt_email')->textInput(['maxlength' => true, 'placeholder'=>'Email'])->label(false) ?>
                </div>    
                <div class="col-md-6">
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder'=>'Contraseña'])->label(false) ?>
                </div>    
                
                <div class="col-md-6">
                    <?= $form->field($model, 'repeatPassword')->passwordInput(['maxlength' => true, 'placeholder'=>'Repetir contraseña'])->label(false) ?>
                </div>    

                <div class="form-group text-center">
                    <?= Html::submitButton($model->isNewRecord ? 'Agregar usuario' : '<i class="icon wb-edit"></i> Actualizar información', ['class' => "btn btn-success"]) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
