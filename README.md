Yii2 file uploader
==================
Yii2 file uploader

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist uraankhayayaal/yii2-fileuploader "*"
```

or add

```
"uraankhayayaal/yii2-fileuploader": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \uraankhayayaal\fileuploader\widgets\input\WFileinput::widget([
    'model' => $model,
    'attribute' => 'files',
    'relationAttributeName' => 'directoryFiles',
    'action' => Url::toRoute(['/directory/directory/upload']),
    'model_attribute' => 'directory_id',
    'model_id' => $model->id,
]); ?>
```

On controller:
```
public function actions()
{
    return [
        ...
        'upload' => [
            'class' => \uraankhayayaal\fileuploader\actions\FileUplaodAction::className(),
            'fileModel' => \yourpath\to\Model::className(),
        ]
    ];
}
```