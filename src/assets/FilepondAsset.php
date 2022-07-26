<?php

namespace uraankhayayaal\fileuploader\assets;

use yii\web\AssetBundle;

class FilepondAsset extends AssetBundle
{
    // public $sourcePath = '@npm/filepond/dist';
    public $sourcePath = '@uraankhayayaal/fileuploader/assets/src/';
    
    public $css = [
        'filepond.css',
    ];
    public $js = [
        'filepond.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}