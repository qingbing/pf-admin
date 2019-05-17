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
 * Date         :   2019-05-15
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\HelperCenter $model
 */
$options = [
    'is_category' => [
        'callable' => ['\Tools\Labels', 'YesNo'],
        'type' => 'view',
    ],
    'label',
    'code',
    'subject',
    'keywords',
    'description',
    'sort_order',
    'is_enable' => [
        'callable' => ['\Tools\Labels', 'enable'],
        'type' => 'view',
    ],
    'content',
    'create_time',
    'uid',
    'ip',
    'update_time',
];

// 填写表单
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]);
?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>