<?php

namespace uraankhayayaal\fileuploader\actions;

use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use uraankhayayaal\fileuploader\models\File;
use yii\web\Response;

class FileUplaodAction extends Action
{
    public $fileModel;

    public function run()
    {
        if (Yii::$app->request->isPost) {
            $model = new File();
            $model->file = UploadedFile::getInstanceByName('filepond');
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->upload($this->fileModel);
        } else {
            throw new BadRequestHttpException(Yii::t('file upload', 'ONLY_POST_REQUEST'));
        }
    }
}
