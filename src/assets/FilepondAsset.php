<?php

namespace uraankhayayaal\fileuploader\assets;

use yii\web\AssetBundle;

class FilepondAsset extends AssetBundle
{
    public $sourcePath = '@npm/filepond/dist';
    
    public $css = [
        'filepond.min.css',
    ];
    public $js = [
        'filepond.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}