<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use FormGenerator;
use Html;
use Tools\Labels;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-14
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\Notice $model
 */
echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveModalCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$options = [
    'subject' => array(
        'code' => 'subject',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入主题',
        'allow_empty' => false,
    ),
    'keywords' => [
        'code' => 'keywords',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入关键字',
        'allow_empty' => true,
    ],
    'description' => [
        'code' => 'description',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入描述',
        'allow_empty' => true,
    ],
    'sort_order' => [
        'code' => 'sort_order',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_INTEGER,
        'tip_msg' => '请输入排序',
        'min' => '0',
        'allow_empty' => true,
    ],
    'is_publish' => [
        'code' => 'is_publish',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::YesNo(),
    ],
    'publish_at' => [
        'code' => 'publish_at',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_TIME,
        'allow_empty' => false,
    ],
    'expire_at' => [
        'code' => 'expire_at',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_TIME,
        'allow_empty' => false,
    ],
    'content' => [
        'code' => 'content',
        'input_type' => FormGenerator::INPUT_TYPE_EDITOR,
        'allow_empty' => true,
        'editor' => [
            'mode' => \KindEditor::MODE_SIMPLE,
            'folder' => 'notice',
            'width' => '150%',
            'height' => '400px',
        ],
    ],
];
// 填写表单
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]);
?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">保存</i></button>
    </dd>
    <dd class="col-sm-3 col-md-3 col-lg-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>