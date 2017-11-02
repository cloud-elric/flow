<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatSimsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Sims Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-sims-cards-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat Sims Cards', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_sim_card',
            'txt_token',
            'txt_nombre',
            'txt_clave_sim_card',
            'txt_descripcion',
            // 'b_habilitado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
