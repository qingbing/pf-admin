<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Admin\Models\BlockCategory;
use FormGenerator;
use Helper\HttpException;
use Html;
use Tools\Labels;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-18
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\BlockCategory $category
 * @var \Admin\Models\BlockOption $model
 */
\ClientScript::getInstance()->registerScriptFile(\Assets001::getAssetBaseUrl() . '/js/jquery.form.js');
echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveAjaxFileCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$options = [
    'label' => [
        'code' => 'label',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入子项名称',
        'ajax_url' => $this->createUrl('uniqueLabel', ['key' => $category->key]),
        'allow_empty' => false,
    ],
];
$link = [
    'code' => 'link',
    'input_type' => FormGenerator::INPUT_TYPE_TEXT,
    'data_type' => FormGenerator::DATA_TYPE_STRING,
    'tip_msg' => '请输入链接地址',
    'allow_empty' => false,
];
$is_blank = [
    'code' => 'is_blank',
    'input_type' => FormGenerator::INPUT_TYPE_SELECT,
    'input_data' => Labels::YesNo(),
];
$src = [
    'code' => 'src',
    'input_type' => FormGenerator::INPUT_TYPE_FILE,
    'file_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
    'tip_msg' => '请上传图片',
    'allow_empty' => false,
];
switch ($category->type) {
    case BlockCategory::TYPE_CONTENT:
    case BlockCategory::TYPE_IMAGE_LINK:
        break;
    case BlockCategory::TYPE_CLOUD_WORDS:
        break;
    case BlockCategory::TYPE_CLOUD_WORDS_LINKS:
        $options['link'] = $link;
        $options['is_blank'] = $is_blank;
        break;
    case BlockCategory::TYPE_LIST:
        break;
    case BlockCategory::TYPE_LIST_LINKS:
        $options['link'] = $link;
        $options['is_blank'] = $is_blank;
        break;
    case BlockCategory::TYPE_IMAGES:
        $options['src'] = $src;
        break;
    case BlockCategory::TYPE_IMAGES_LINKS:
        $options['link'] = $link;
        $options['is_blank'] = $is_blank;
        $options['src'] = $src;
        break;
    default :
        throw new HttpException('区块类型(type)不存在', 404);
}
$options['is_enable'] = [
    'code' => 'is_enable',
    'input_type' => FormGenerator::INPUT_TYPE_SELECT,
    'input_data' => Labels::enable(),
];
$options['sort_order'] = [
    'code' => 'sort_order',
    'input_type' => FormGenerator::INPUT_TYPE_TEXT,
    'data_type' => FormGenerator::DATA_TYPE_INTEGER,
    'tip_msg' => '请输入排序',
    'min' => '0',
    'allow_empty' => false,
];
$options['description'] = [
    'code' => 'description',
    'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
    'data_type' => FormGenerator::DATA_TYPE_STRING,
    'tip_msg' => '请输入子项含义',
    'allow_empty' => true,
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