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
                'rowOptions' => function ($fileModel, $key, $index, $grid) {
                    return ['data-sortable-id' => $fileModel->id];
                },
                'options' => [
                    'data' => [
                        'sortable-widget' => 1,
                        'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
                    ]
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['class' => 'uraankhayayaal\materializecomponents\grid\MaterialActionColumn', 'template' => '{update}'],

                    [
                        'attribute' => 'path',
                        'format' => 'raw',
                        'value' => function($model){
                            return Html::a($model->name, [$model->path], ['download' => $model->name]);
                        },
                    ],
                    'filename',
                    'ext',
                    'size',

                    ['class' => 'uraankhayayaal\materializecomponents\grid\MaterialActionColumn', 'template' => '{delete}'],
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