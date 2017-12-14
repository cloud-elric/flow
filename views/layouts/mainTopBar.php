<?php
use app\assets\AppAssetsCore;

AppAssetsCore::register($this);

?>


<?php $this->beginPage() ?>

<?= $this->render("//components/main-head")?>


<?= $this->render("//components/header")?>
<?= $this->render("//components/menu")?>

<?php $this->beginBody() ?>


<?= $content ?>
<?= $this->render("//components/footer")?>
<?php $this->endBody() ?>

<script>
    Breakpoints();
</script>
<script>
  (function(document, window, $){
    'use strict';

    var Site = window.Site;
    $(document).ready(function(){
      Site.run();
    });
  })(document, window, jQuery);
</script>

<?php $this->endPage() ?>

