<?php
use app\assets\AppAsset;

AppAsset::register($this);

?>


<?php $this->beginPage() ?>

<?= $this->render("//components/main-head")?>

<?php $this->head() ?>

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>

<?php $this->endPage() ?>

