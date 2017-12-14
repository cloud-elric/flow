<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

$this->registerJsFile(
    '@web/webAssets/js/autorizar-envio-express.js',
    ['depends' => [kartik\select2\Select2Asset::className()]]
);
require(__DIR__ . '/../components/scriptSelect2.php');
?>

<form id="form-autorizar-supervisor">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <?php
                echo Select2::widget([
                    'name' => 'id_supervisor',
                    'data' => $supervisores,
                    'options' => ['placeholder' => 'Seleccionar supervisor'],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'templateResult' => new JsExpression('formatRepoSupervisor'),
                        'templateSelection' => new JsExpression('formatSelectionSupervisor'),
                    ],
                ]);
                ?>

            </div>

        </div>

        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <input type="password" class="form-control" name="password-supervisor" placeholder="Contraseña del supervisor"/>
            </div>

        </div>
        
    </div>

    <div class="row">

        <div class="col-md-6 col-md-offset-3 text-center">
            <div class="form-group">
                <div class="alert alert-danger" role="alert" style="display:none" id="alert-autorizacion">
                    
                </div>
                
            </div>

        </div>
        
    </div>

    <div class="row">
    
        <div class="col-md-6 col-md-offset-3 text-center">
            <div class="form-group">
                <button class="btn btn-success ladda-button" data-style="zoom-in" id="btn-autorizar-envio-express">
                    <span class="ladda-label">
                        Autorizar envio express
                    </span>
                </button>
                <button class="btn btn-success" id="btn-success-autorizacion" style="display:none;">
                        Envio express autorizado
                </button>
                
            </div>

        </div>
        
    </div>

</form>