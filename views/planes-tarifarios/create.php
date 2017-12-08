<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CatTiposPlanesTarifarios */

$this->title = 'Create Cat Tipos Planes Tarifarios';
$this->params['breadcrumbs'][] = ['label' => 'Cat Tipos Planes Tarifarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-tipos-planes-tarifarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
