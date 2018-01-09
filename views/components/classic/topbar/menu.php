<?php
use \yii\helpers\Url;
?>
<div class="site-menubar site-menubar-light">
  <div class="site-menubar-body">
    <div>
      <div>
        <ul class="site-menu" data-plugin="menu">
          <li class="site-menu-category">General</li>
          <li class="dropdown site-menu-item">
            <a data-toggle="dropdown" href="<?=Url::base()?>" data-dropdown-toggle="false">
              <i class="site-menu-icon pe-7s-edit" aria-hidden="true"></i>
              <span class="site-menu-title">Dashboard</span>
            </a>
          </li>  
          <li class="dropdown site-menu-item has-sub">
            <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
              <i class="site-menu-icon pe-7s-headphones" aria-hidden="true"></i>
              <span class="site-menu-title">Call center</span>
              <span class="site-menu-arrow"></span>
            </a>
            <div class="dropdown-menu">
              <div class="site-menu-scroll-wrap is-list">
                <div>
                  <div>
                    <ul class="site-menu-sub site-menu-normal-list">
                      <?php
                      if(\Yii::$app->user->can(Yii::$app->params ['roles'] ['supervisorTelcel'])){?>
                      <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/usuarios/usuarios-call-center">
                          <i class="site-menu-icon pe-7s-users" aria-hidden="true"></i>
                          <span class="site-menu-title">Empleados</span>
                        </a>
                      </li>
                      <?php
                      }
                      ?>
                      <?php 
                      if(\Yii::$app->user->can(Yii::$app->params ['roles'] ['ejecutivoTelcel'])){
                      ?>
                      <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/citas">
                          <i class="site-menu-icon pe-7s-bookmarks" aria-hidden="true"></i>
                          <span class="site-menu-title">Citas</span>
                        </a>
                      </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>
          
        </ul>
      </div>
    </div>
  </div>
</div>