<?php
use app\assets\AppAssetsLogin;

AppAssetsLogin::register($this);

?>


<?php $this->beginPage() ?>

<?= $this->render("//components/main-head")?>

<?php $this->head() ?>

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>

<?php $this->endPage() ?>

