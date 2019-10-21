<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

        <div>
            <?php foreach ($model->{$relationAttributeName} as $file) { ?>
                <p><a download="<?= $file->name ?>" href="<?= Url::toRoute($file->path) ?>"><?= $file->filename ?></a></p>
            <?php } ?>
            </div>
		<p>
		    <!-- <label> -->
		    <input type="file" id="<?= Html::getInputId($model, $attribute); ?>" name="<?= $model->formName() ?>[<?= $attribute ?>]" <?= ($model->$attribute) ? 'checked' : ''; ?>  class="filepond" multiple>
		    <!-- <span for="<?= Html::getInputId($model, $attribute); ?>"><?= $model->getAttributeLabel($attribute); ?></span> -->
		    <!-- </label> -->
        </p>
        
<?php $this->registerJs("
    FilePond.parse(document.body);

    FilePond.setOptions({
        name: 'filepond',
        server:{
            process: {
                url: '".$action."',
                method: 'POST',
                //headers: {
                //    'x-customheader': 'Hello World'
                //},
                withCredentials: false,
                onload: (response) => response.key,
                onerror: (response) => response.data,
                ondata: (formData) => {
                    formData.append('".Yii::$app->request->csrfParam."', '".Yii::$app->request->getCsrfToken()."');
                    formData.append('parent_id', '".$model_id."');
                    formData.append('parent_attribute', '".$model_attribute."');
                    return formData;
                }
            },
            //revert: './revert',
            //restore: './restore/',
            //load: './load/',
            //fetch: './fetch/'
        }
    });

    FilePond.create({
        files: [
            {
                // the server file reference
                source: '12345',
    
                // set type to local to indicate an already uploaded file
                options: {
                    type: 'local',
    
                    // mock file information
                    file: {
                        name: 'my-file.png',
                        size: 3001025,
                        type: 'image/png'
                    }
                }
            }
        ]
    });
", $this::POS_READY);?>