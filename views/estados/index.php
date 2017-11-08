<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatEstadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Estados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-estados-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat Estados', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_estado',
            'id_pais',
            'id_area',
            'num_estado',
            'txt_nombre',
            // 'txt_descripcion',
            // 'num_latitud',
            // 'num_longitud',
            // 'b_habilitado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
