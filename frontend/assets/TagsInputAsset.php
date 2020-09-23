<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
/**
 * Main frontend application asset bundle.
 */
class TagsInputAsset extends AssetBundle
{
    public $basePath = '@webroot/tagsinput';
    public $baseUrl = '@web/tagsinput';
    public $css = [
        'bootstrap-tagsinput.css',
    ];
    public $js = [
      'bootstrap-tagsinput.js',
    ];
    public $depends = [
      JqueryAsset::class
    ];
}
