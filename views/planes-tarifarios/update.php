<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CatTiposPlanesTarifarios */

$this->title = 'Update Cat Tipos Planes Tarifarios: ' . $model->id_tipo_plan;
$this->params['breadcrumbs'][] = ['label' => 'Cat Tipos Planes Tarifarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tipo_plan, 'url' => ['view', 'id' => $model->id_tipo_plan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cat-tipos-planes-tarifarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
