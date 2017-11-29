<?php
  use \yii\helpers\Url;
?>

    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega navbar-inverse"
      role="navigation">
    
    	<div class="navbar-header">
			<button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
			  data-toggle="menubar">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="hamburger-bar"></span>
			</button>
			<button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
			  data-toggle="collapse">
			  <i class="icon wb-more-horizontal" aria-hidden="true"></i>
			</button>
			<a class="navbar-brand navbar-brand-center" href="../index.html">
			  <img class="navbar-brand-logo navbar-brand-logo-normal" src="<?=Url::base()?>/webAssets/images/logo-plan-perfecto-bco.png"
			    title="Plan Perfecto Telcel">
			</a>
			<button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
			  data-toggle="collapse">
			  <span class="sr-only">Buscar</span>
			  <i class="icon wb-search" aria-hidden="true"></i>
			</button>
      	</div>
    
      <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
          <!-- Navbar Toolbar -->
          <ul class="nav navbar-toolbar">
            <li class="nav-item hidden-float" id="toggleMenubar">
              <a class="nav-link" data-toggle="menubar" href="#" role="button">
                <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
              </a>
            </li>
          </ul>
          <!-- End Navbar Toolbar -->
    
          <!-- Navbar Toolbar Right -->
          <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            <li class="nav-item hidden-sm-down" id="toggleFullscreen">
              <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                <span class="sr-only">Toggle fullscreen</span>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                data-animation="scale-up" role="button">
                <span class="avatar avatar-online">
                  <img src="<?=Url::base()?>/webAssets/images/system/portraits/5.jpg" alt="...">
                  <i></i>
                </span>
              </a>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item disabled" href="javascript:void(0)" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Perfil</a>
                <div class="dropdown-divider" role="presentation"></div>
                <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Cerrar sesión</a>
              </div>
            </li>
          </ul>
          <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
      </div>
    </nav>