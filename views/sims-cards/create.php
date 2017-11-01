<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatSimsCards */

$this->title = 'Create Cat Sims Cards';
$this->params['breadcrumbs'][] = ['label' => 'Cat Sims Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-sims-cards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
