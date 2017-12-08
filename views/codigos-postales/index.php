<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntCitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cat Codigos Postales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-codigos-postales-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cat Codigos Postales', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'txt_codigo_postal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
