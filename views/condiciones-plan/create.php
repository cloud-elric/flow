<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatCondicionesPlan */

$this->title = 'Create Cat Condiciones Plan';
$this->params['breadcrumbs'][] = ['label' => 'Cat Condiciones Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-condiciones-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
