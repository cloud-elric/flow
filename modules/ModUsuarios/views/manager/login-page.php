<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';

?>


<body class="animsition page-login-v3 layout-full">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <!-- Page -->
  <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
      <div class="panel">
        <div class="panel-body">
          <div class="brand">
            <img class="brand-img mb-40" src="webassets/images/logo-mls-color.png" alt="...">
          </div>


          <?php 
          $form = ActiveForm::begin([
            'id' => 'form-ajax',
            'enableAjaxValidation' => true,
            'enableClientValidation'=>true,
            'fieldConfig' => [
              "template" => "{input}{label}{error}",
              "options" => [
                "class" => "form-group form-material floating",
                "data-plugin" => "formMaterial"
              ],
              "labelOptions" => [
                "class" => "floating-label"
              ]
            ]
          ]); 
          ?>

          <?= $form->field($model, 'username')->textInput() ?>

          <?= $form->field($model, 'password')->passwordInput()?>


            <div class="form-group clearfix">
              <a class="float-right" href="forgot-password.html">¿Olvidaste tu contraseña?</a>
            </div>


            <?= Html::submitButton('<span class="ladda-label">Ingresar</span>', ["data-style"=>"zoom-in", 'class' => 'btn btn-primary btn-block btn-lg mt-40 ladda-button', 'name' => 'login-button'])
            ?>
          



          <?php ActiveForm::end(); ?>


          <p class="soporteTxt">¿Necesitas ayuda? escribe a: <a href="mailto:soporte@2gom.com.mx?Subject=Solicitud%de%Soporte">soporte@2gom.com.mx</a></p>
        </div>
      </div>
      <footer class="page-copyright page-copyright-inverse">
        <p class="developer-link">sistema desarrollado por </p><a class="developer-link" href="https://www.2geeksonemonkey.com"> 2 Geeks one Monkey</a>
        <p>© 2017. Todos los derechos reservados.</p>
        <div class="social">
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <img class="developer-logo" src="webassets/images/monkey-logo.png" alt="We develop successfull apps">
          </a>
        </div>
      </footer>
    </div>
  </div>
  <!-- End Page -->
</body>
</html>