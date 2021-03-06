<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Admin\Models\BlockCategory;

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
$options = [
    'type' => [
        'callable' => ['\Admin\Models\BlockCategory', 'types'],
        'type' => 'view',
    ],
    'name',
    'is_enable' => [
        'callable' => ['\Tools\Labels', 'enable'],
        'type' => 'view',
    ],
    'description',
    'sort_order',
    'created_at',
    'updated_at',
];

if (BlockCategory::TYPE_CONTENT == $model->type) {
    $options['content'] = [
        'type' => 'view',
        'callable' => function () use ($model) {
            return $model->content;
        },
    ];
} else if (BlockCategory::TYPE_IMAGE_LINK == $model->type) {
    $options['content'] = [
        'type' => 'view',
        'callable' => function () use ($model) {
            return $model->content;
        },
    ];
    $options['src'] = [
        'code' => 'src',
        'type' => 'view',
        'callable' => function () use ($model) {
            if ('' != $model->src) {
                return '<img src="' . $model->getImageSrc() . '" width="180px" />';
            }
            return null;
        }
    ];
}

// 填写表单
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]);
?>
<dl class="form-group row">
    <dd class="col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="button" class="btn btn-primary MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>