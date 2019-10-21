<?php

namespace uraankhayayaal\fileuploader\widgets\input;

use Yii;
use \uraankhayayaal\fileuploader\assets\FilepondAsset;

class WFileinput extends \yii\base\Widget
{
    public $model;
    public $attribute;
    public $relationAttributeName;
    public $action;
    public $model_attribute;
    public $model_id;

    public function init() {
        FilepondAsset::register( $this->getView() );
        parent::init();
    }

    public function run()
    {
        if($this->model_id == null){
            return $this->render('nomodel');
        }else{
            return $this->render('index', [
                'model' => $this->model,
                'attribute' => $this->attribute,
                'action' => $this->action,
                'model_id' => $this->model_id,
                'model_attribute' => $this->model_attribute,
                'relationAttributeName' => $this->relationAttributeName,
            ]);
        }
    }
}
