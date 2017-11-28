<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatTiposPlanesTarifariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Tipos Planes Tarifarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-tipos-planes-tarifarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat Tipos Planes Tarifarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_tipo_plan',
            'txt_nombre',
            'num_costo_renta',
            'txt_descripcion',
            'b_habilitado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
