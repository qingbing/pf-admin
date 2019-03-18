<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use FormGenerator;
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-18
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\BlockCategory $model
 */
echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveModalCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$options = [
    'type' => [
        'callable' => ['\Admin\Models\BlockCategory', 'types'],
        'type' => 'view',
    ],
    'name',
    'description',
    'content' => [
        'code' => 'content',
        'input_type' => FormGenerator::INPUT_TYPE_EDITOR,
        'editor' => [
            'mode' => \KindEditor::MODE_FULL,
            'openFlag' => true,
            'folder' => 'block',
            'width' => '120%',
            'height' => '300px',
            'resizeType' => '2',
        ],
    ],
];
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]); ?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">保存</i></button>
    </dd>
    <dd class="col-sm-3 col-md-3 col-lg-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
