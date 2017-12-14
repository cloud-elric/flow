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
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
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
                        <li class="site-menu-item">
                          <a class="animsition-link" href="">
                            <i class="site-menu-icon pe-7s-users" aria-hidden="true"></i>
                            <span class="site-menu-title">Empleados</span>
                          </a>
                        </li>
                        <li class="site-menu-item">
                          <a class="animsition-link" href="">
                            <i class="site-menu-icon pe-7s-bookmarks" aria-hidden="true"></i>
                            <span class="site-menu-title">Citas</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="dropdown site-menu-item has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon pe-7s-users" aria-hidden="true"></i>
                <span class="site-menu-title">Usuarios</span>
                <span class="site-menu-arrow"></span>
              </a>
              <div class="dropdown-menu">
                <div class="site-menu-scroll-wrap is-list">
                  <div>
                    <div>
                      <ul class="site-menu-sub site-menu-normal-list">
                        <li class="site-menu-item">
                          <a class="animsition-link" href="">
                            <i class="site-menu-icon pe-7s-id" aria-hidden="true"></i>
                            <span class="site-menu-title">Lista de usuarios</span>
                          </a>
                        </li>
                        <li class="site-menu-item">
                          <a class="animsition-link">
                            <i class="site-menu-icon pe-7s-add-user" aria-hidden="true"></i>
                            <span class="site-menu-title">Agregar nuevo</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="site-menu-category">Productos</li>
            <li class="dropdown site-menu-item has-section has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon pe-7s-box2" aria-hidden="true"></i>
                <span class="site-menu-title">Productos</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="dropdown-menu site-menu-sub site-menu-section-wrap blocks-md-3">
                <li class="site-menu-section site-menu-item has-sub">
                  <header>
                    <i class="site-menu-icon pe-7s-box1" aria-hidden="true"></i>
                    <span class="site-menu-title">Envios</span>
                    <span class="site-menu-arrow"></span>
                  </header>
                  <div class="site-menu-scroll-wrap is-section">
                    <div>
                      <div>
                        <ul class="site-menu-sub site-menu-section-list">
                          <li class="site-menu-item has-sub">
                            <a href="javascript:void(0)">
                              <span class="site-menu-title">Panel</span>
                              <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                              <li class="site-menu-item">
                                <a class="animsition-link" href="uikit/panel-structure.html">
                                  <span class="site-menu-title">Panel Structure</span>
                                </a>
                              </li>
                              <li class="site-menu-item">
                                <a class="animsition-link" href="uikit/panel-actions.html">
                                  <span class="site-menu-title">Panel Actions</span>
                                </a>
                              </li>
                              <li class="site-menu-item">
                                <a class="animsition-link" href="uikit/panel-portlets.html">
                                  <span class="site-menu-title">Panel Portlets</span>
                                </a>
                              </li>
                            </ul>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/buttons.html">
                              <span class="site-menu-title">Buttons</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/cards.html">
                              <span class="site-menu-title">Cards</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/dropdowns.html">
                              <span class="site-menu-title">Dropdowns</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/icons.html">
                              <span class="site-menu-title">Icons</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/list.html">
                              <span class="site-menu-title">List</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/tooltip-popover.html">
                              <span class="site-menu-title">Tooltip &amp; Popover</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/modals.html">
                              <span class="site-menu-title">Modals</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/tabs-accordions.html">
                              <span class="site-menu-title">Tabs &amp; Accordions</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/images.html">
                              <span class="site-menu-title">Images</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/badges.html">
                              <span class="site-menu-title">Badges</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/progress-bars.html">
                              <span class="site-menu-title">Progress Bars</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/carousel.html">
                              <span class="site-menu-title">Carousel</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/typography.html">
                              <span class="site-menu-title">Typography</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/colors.html">
                              <span class="site-menu-title">Colors</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="uikit/utilities.html">
                              <span class="site-menu-title">Utilties</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="site-menu-section site-menu-item has-sub">
                  <header>
                    <span class="site-menu-title">Advanced UI</span>
                    <span class="site-menu-arrow"></span>
                  </header>
                  <div class="site-menu-scroll-wrap is-section">
                    <div>
                      <div>
                        <ul class="site-menu-sub site-menu-section-list">
                          <li class="site-menu-item hidden-sm-down site-tour-trigger">
                            <a href="javascript:void(0)">
                              <span class="site-menu-title">Tour</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/animation.html">
                              <span class="site-menu-title">Animation</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/highlight.html">
                              <span class="site-menu-title">Highlight</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/lightbox.html">
                              <span class="site-menu-title">Lightbox</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/scrollable.html">
                              <span class="site-menu-title">Scrollable</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/rating.html">
                              <span class="site-menu-title">Rating</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/context-menu.html">
                              <span class="site-menu-title">Context Menu</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/alertify.html">
                              <span class="site-menu-title">Alertify</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/masonry.html">
                              <span class="site-menu-title">Masonry</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/treeview.html">
                              <span class="site-menu-title">Treeview</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/toastr.html">
                              <span class="site-menu-title">Toastr</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/maps-vector.html">
                              <span class="site-menu-title">Vector Maps</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/maps-google.html">
                              <span class="site-menu-title">Google Maps</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/sortable-nestable.html">
                              <span class="site-menu-title">Sortable &amp; Nestable</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="advanced/bootbox-sweetalert.html">
                              <span class="site-menu-title">Bootbox &amp; Sweetalert</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="site-menu-section site-menu-item has-sub">
                  <header>
                    <span class="site-menu-title">Structure</span>
                    <span class="site-menu-arrow"></span>
                  </header>
                  <div class="site-menu-scroll-wrap is-section">
                    <div>
                      <div>
                        <ul class="site-menu-sub site-menu-section-list">
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/alerts.html">
                              <span class="site-menu-title">Alerts</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/ribbon.html">
                              <span class="site-menu-title">Ribbon</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/pricing-tables.html">
                              <span class="site-menu-title">Pricing Tables</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/overlay.html">
                              <span class="site-menu-title">Overlay</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/cover.html">
                              <span class="site-menu-title">Cover</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/timeline-simple.html">
                              <span class="site-menu-title">Simple Timeline</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/timeline.html">
                              <span class="site-menu-title">Timeline</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/step.html">
                              <span class="site-menu-title">Step</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/comments.html">
                              <span class="site-menu-title">Comments</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/media.html">
                              <span class="site-menu-title">Media</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/chat.html">
                              <span class="site-menu-title">Chat</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/testimonials.html">
                              <span class="site-menu-title">Testimonials</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/nav.html">
                              <span class="site-menu-title">Nav</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/navbars.html">
                              <span class="site-menu-title">Navbars</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/blockquotes.html">
                              <span class="site-menu-title">Blockquotes</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/pagination.html">
                              <span class="site-menu-title">Pagination</span>
                            </a>
                          </li>
                          <li class="site-menu-item">
                            <a class="animsition-link" href="structure/breadcrumbs.html">
                              <span class="site-menu-title">Breadcrumbs</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </li>
            <li class="site-menu-category">Envios</li>
            <li class="dropdown site-menu-item has-sub">
              <a data-toggle="dropdown" href="javascript:void(0)" data-dropdown-toggle="false">
                <i class="site-menu-icon pe-7s-box1" aria-hidden="true"></i>
                <span class="site-menu-title">Envios</span>
                <span class="site-menu-arrow"></span>
              </a>
              <div class="dropdown-menu">
                <div class="site-menu-scroll-wrap is-list">
                  <div>
                    <div>
                      <ul class="site-menu-sub site-menu-normal-list">
                        <li class="site-menu-item">
                          <a class="animsition-link" href="apps/contacts/contacts.html">
                            <span class="site-menu-title">Tracking</span>
                          </a>
                        </li>
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




