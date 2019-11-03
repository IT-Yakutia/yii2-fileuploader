<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

?>

        <div>
            <?php /*foreach ($model->{$relationAttributeName} as $file) { ?>
                <p><a download="<?= $file->name ?>" href="<?= Url::toRoute($file->path) ?>"><?= $file->filename ?></a></p>
            <?php }*/ ?>
            <br>
            <?= GridView::widget([
                'tableOptions' => [
                    'class' => 'striped bordered my-responsive-table',
                    'id' => 'sortable'
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-sortable-id' => $model->id];
                },
                'options' => [
                    'data' => [
                        'sortable-widget' => 1,
                        'sortable-url' => \yii\helpers\Url::toRoute(['/directory/directory-file/sorting']),
                    ]
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'path',
                        'format' => 'raw',
                        'value' => function($model){
                            return Html::a($model->filename, [$model->path], ['download' => $model->filename]);
                        },
                    ],
                    'ext',
                    'size',
                    'created_at:datetime',

                    ['class' => 'uraankhayayaal\materializecomponents\grid\MaterialActionColumn', 'template' => '{update} {delete}'],
                    ['class' => \uraankhayayaal\sortable\grid\Column::className()],
                ],
                'pager' => [
                    'class' => 'yii\widgets\LinkPager',
                    'options' => ['class' => 'pagination center'],
                    'prevPageCssClass' => '',
                    'nextPageCssClass' => '',
                    'pageCssClass' => 'waves-effect',
                    'nextPageLabel' => '<i class="material-icons">chevron_right</i>',
                    'prevPageLabel' => '<i class="material-icons">chevron_left</i>',
                ],
            ]); ?>
        </div>
		<p>
		    <!-- <label> -->
		    <input type="file" id="<?= Html::getInputId($model, $attribute); ?>" name="<?= $model->formName() ?>[<?= $attribute ?>]" <?= ($model->$attribute) ? 'checked' : ''; ?>  class="filepond" multiple>
		    <!-- <span for="<?= Html::getInputId($model, $attribute); ?>"><?= $model->getAttributeLabel($attribute); ?></span> -->
		    <!-- </label> -->
        </p>
<?php
    $extraJsonData = '';
    if(!empty($extraFields)){
        $extraJsonData = \yii\helpers\Json::encode($extraFields);
    }
?>
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
                    formData.append('extraData', '".$extraJsonData."');
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

    FilePond.on('addfile', (error, file) => {
        if(error){
            console.log(error);
            return;
        }
        console.log(file);
    });
", $this::POS_READY);?>