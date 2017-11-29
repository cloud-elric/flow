<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAssetsCore extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	//Core
    	'webAssets/css/core/bootstrap.min.css',
        'webAssets/css/core/bootstrap-extend.min.css',
        'webAssets/css/core/site.min.css',
		'webAssets/css/core/animsition.min.css',
	    'webAssets/css/core/asScrollable.min.css',
	    'webAssets/css/core/switchery.min.css',
	    'webAssets/css/core/introjs.min.css',

	    //Fonts
	    'webAssets/fonts/web-icons/web-icons.min.css',
	    'webAssets/fonts/brand-icons/brand-icons.min.css',
        'http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'

        //JS del principio

    ];
    public $js = [
    	//Core
    	'webAssets/js/plugins/babel-external-helpers.js',
        'webAssets/js/core/breakpoints.min.js',
    	'webAssets/js/core/jquery.min.js',
    	'webAssets/js/core/tether.min.js',
    	'webAssets/js/core/bootstrap.min.js',
    	'webAssets/js/plugins/animsition.min.js',
    	'webAssets/js/plugins/jquery.mousewheel.js',
    	'webAssets/js/plugins/jquery-asScrollbar.min.js',
    	'webAssets/js/plugins/jquery-asScrollable.min.js',
    	'webAssets/js/plugins/switchery.min.js',
    	'webAssets/js/plugins/intro.min.js',
    	'webAssets/js/plugins/screenfull.min.js',
    	'webAssets/js/plugins/jquery-slidePanel.js',
    	'webAssets/js/plugins/Component.js',
    	'webAssets/js/plugins/Plugin.js',
    	'webAssets/js/plugins/Base.js',
    	'webAssets/js/plugins/Config.js',
    	'webAssets/js/plugins/Menubar.js',
    	'webAssets/js/plugins/Sidebar.js',
    	'webAssets/js/plugins/PageAside.min.js',
    	'webAssets/js/plugins/menu.min.js',

    	//page
    	'webAssets/js/plugins/Site.js',
    	'webAssets/js/plugins/asscrollable.js',
    	'webAssets/js/plugins/slidepanel.js',
    	'webAssets/js/plugins/switchery.js',
        'webAssets/js/geek.js'


    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

