<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Sistema de TMS | Marel - Logistics">
    <meta name="author" content="2 Geeks one Monkey">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->head() ?>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<script>
        var baseUrl = "<?= Yii::$app->urlManager->createAbsoluteUrl(['']) ?>";
    </script>
    
</head>