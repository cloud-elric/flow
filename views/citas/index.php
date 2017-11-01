<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntCitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ent Citas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-citas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ent Citas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_cita',
            'id_tipo_tramite',
            'id_equipo',
            'id_sim_card',
            'id_area',
            // 'id_tipo_entrega',
            // 'id_usuario',
            // 'num_dias_servicio',
            // 'txt_token',
            // 'txt_clave_sap_equipo',
            // 'txt_descripcion_equipo',
            // 'txt_serie_equipo',
            // 'txt_telefono',
            // 'txt_clave_sim_card',
            // 'txt_descripcion_sim',
            // 'txt_serie_sim_card',
            // 'txt_nombre_completo_cliente',
            // 'txt_numero_referencia',
            // 'txt_numero_referencia_2',
            // 'txt_numero_referencia_3',
            // 'txt_calle_numero',
            // 'txt_colonia',
            // 'txt_codigo_postal',
            // 'txt_municipio',
            // 'txt_entre_calles',
            // 'txt_observaciones_punto_referencia',
            // 'fch_cita',
            // 'fch_hora_cita',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
