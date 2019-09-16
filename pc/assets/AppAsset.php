<?php

namespace pc\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = 'https://cdn.3661732.comm';
    public $css = [
        '/public/css/bootstrap.css',
    ];
    public $js = [
        'public/js/jquery/jquery_2.2.4.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
