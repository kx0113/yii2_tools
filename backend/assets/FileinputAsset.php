<?php

namespace backend\assets;

use yii\web\AssetBundle;

class FileinputAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kartik-v/bootstrap-fileinput';//路径
    public $css = [
        'css/fileinput.min.css',//css
    ];
    
    public $js = [
        'js/fileinput.min.js'//js
    ];
}