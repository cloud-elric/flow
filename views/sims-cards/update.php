<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatSimsCards */

$this->title = 'Update Cat Sims Cards: ' . $model->id_sim_card;
$this->params['breadcrumbs'][] = ['label' => 'Cat Sims Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sim_card, 'url' => ['view', 'id' => $model->id_sim_card]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-sims-cards-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
