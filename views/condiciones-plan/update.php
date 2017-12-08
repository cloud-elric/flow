<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatCondicionesPlan */

$this->title = 'Update Cat Condiciones Plan: ' . $model->id_condicion_plan;
$this->params['breadcrumbs'][] = ['label' => 'Cat Condiciones Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_condicion_plan, 'url' => ['view', 'id' => $model->id_condicion_plan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-condiciones-plan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
