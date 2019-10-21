<?php

namespace uraankhayayaal\fileuploader\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class File extends Model
{
    public $file;

    public $parent_attribute;
    public $parent_id;

    public $file_path = "@backend/web/uploads/";
    public $url_path = "/uploads/";

    public function rules()
    {
        return [
            [['file', 'parent_attribute', 'parent_id'], 'required'],
            ['parent_id', 'integer'],
            [['parent_attribute'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => false],
        ];
    }
    
    public function upload($className = null)
    {
        if($className == null){
            return false;
        }
        $this->parent_attribute = Yii::$app->request->post('parent_attribute');
        $this->parent_id = Yii::$app->request->post('parent_id');
        if ($this->validate()) {
            $path = \Yii::getAlias($this->file_path);
            $filename = '_' . time() . '_' . $this->file->baseName . '.' . $this->file->extension;
            if (!file_exists($path) || !is_dir($path))
                    \yii\helpers\FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

            if($this->file->saveAs($path . $filename)){
                $fileModel  = new $className();
                $fileModel->name = $this->file->baseName . '.' . $this->file->extension;
                $fileModel->path = $this->url_path . $filename;
                $fileModel->ext = $this->file->extension;
                $fileModel->size = Yii::$app->formatter->asShortSize($this->file->size, 2);
                $fileModel->filename = $this->file->baseName;
                $fileModel->{$this->parent_attribute} = $this->parent_id;
                if($fileModel->save())
                    return $fileModel->id;
                else
                    return var_dump($fileModel->errors);
            }else{
                return "We can't save a file in the server";
            }
        } else {
            return "No valide data you send";
        }
    }
}