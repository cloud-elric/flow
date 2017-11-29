<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<?= $this->render("main-head")?>

<body class="layout-full">
    <div class="animsition page">
        <div class="page-content">
            <?php $this->beginBody() ?>

            <?= $content ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <footer class="page-copyright page-copyright-inverse text-center">
                        <p>DEVELOPMENT BY <?=Yii::$app->params ['developmentBy']?></p>
                        <p>© <?=date('Y')?>. Todos los derechos reservados.</p>
                        <div class="social">
                       
                        </div>
                    </footer>
                </div>
            </div>
            <?php $this->endBody() ?>
        </div>    
    </div>
    <script>
(function(document, window, $) {
  'use strict';
  var Site = window.Site;
  $(document).ready(function() {
    Site.run();
  });
})(document, window, jQuery);
</script>
</body>
</html>
<?php $this->endPage() ?>
