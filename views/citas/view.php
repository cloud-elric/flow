<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = "Revisión de cita";
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-calendar"></i>Citas', 'url' => ['index'], 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => '<i class="icon wb-mobile"></i> '.$this->title, 'encode' => false];

$tramite = $model->idTipoTramite;
$equipo = $model->idEquipo;
$status = $model->idStatus;

?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <h4>
                Estatus de cita: <?=$status->txt_nombre?>
                <div class="pull-right">
                    <?php
                    if(\Yii::$app->user->can('supervisor-call-center')){
                    ?>
                    <a class="btn btn-success" href="<?=Url::base()?>/citas/aprobar?txt_token=<?=$model->txt_token?>"> 
                        <i class="icon fa-check"></i> Autorizar
                    </a>
                    <a class="btn btn-primary" href="<?=Url::base()?>/citas/aprobar?txt_token=<?=$model->txt_token?>"> 
                        <i class="icon fa-refresh"></i> Actualizar
                    </a>
                    <a class="btn btn-warning" href="<?=Url::base()?>/citas/aprobar?txt_token=<?=$model->txt_token?>"> 
                        <i class="icon fa-times"></i> Rechazar
                    </a>
                    <a class="btn btn-danger" href="<?=Url::base()?>/citas/aprobar?txt_token=<?=$model->txt_token?>"> 
                        <i class="icon fa-trash"></i> Cancelar
                    </a>
                    <?php
                    }
                    ?>
                </div>
            </h4>
        </div>
    </div>
    <div class="panel-body">
        
    </div>
</div>

<div class="ent-citas-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_cita], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_cita], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_cita',
            'id_tipo_tramite',
            'id_equipo',
            'id_sim_card',
            'id_area',
            'id_tipo_entrega',
            'id_usuario',
            'num_dias_servicio',
            'txt_token',
            'txt_clave_sap_equipo',
            'txt_descripcion_equipo',
            'txt_serie_equipo',
            'txt_telefono',
            'txt_clave_sim_card',
            'txt_descripcion_sim',
            'txt_serie_sim_card',
            'txt_nombre_completo_cliente',
            'txt_numero_referencia',
            'txt_numero_referencia_2',
            'txt_numero_referencia_3',
            'txt_calle_numero',
            'txt_colonia',
            'txt_codigo_postal',
            'txt_municipio',
            'txt_entre_calles',
            'txt_observaciones_punto_referencia',
            'fch_cita',
            'fch_hora_cita',
        ],
    ]) ?>

</div>
