<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EntCitas */

$this->title = $model->id_cita;
$this->params['breadcrumbs'][] = ['label' => 'Ent Citas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-citas-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
