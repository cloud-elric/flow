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
class AppAssetsLogin extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	//Core
    	'webAssets/css/core/bootstrap.min.css',
        'webAssets/css/core/bootstrap-extend.min.css',
        'webAssets/css/core/site.min.css',
        'http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic',

        //Custom by Page
        'webAssets/css/custom/page/login.css',
    ];
    public $js = [
    	//Core
    	'webAssets/js/plugins/jquery.min.js',
    	'webAssets/js/plugins/tether.min.js',
    	'webAssets/js/plugins/bootstrap.min.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

