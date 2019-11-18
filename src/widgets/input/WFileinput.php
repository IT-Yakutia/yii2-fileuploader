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
    public $fileSearchModel;
    public $extraFields = [];
    public $controller = null;

    public function init() {
        FilepondAsset::register( $this->getView() );
        parent::init();
    }

    public function run()
    {
        $className = $this->fileSearchModel;
        $searchModel = new $className();
        $searchModel->{$this->model_attribute} = $this->model_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'extraFields' => $this->extraFields,
                'controller' => $this->controller,
            ]);
        }
    }
}
