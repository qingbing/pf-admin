<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\User $model
 */
$options = [
    'uid',
    'username',
    'real_name',
    'nickname',
    'sex' => [
        'callable' => ['\Tools\Labels', 'sex'],
        'type' => 'view',
    ],
    'birthday',
    'avatar' => [
        'function' => [$model, 'showAvatar'],
        'type' => 'view',
    ],
    'mobile',
    'phone',
    'qq',
    'address',
    'zip_code',
    'refer_uid',
    'zip_code',
    'register_ip',
    'register_time',
    'login_times',
    'last_login_ip',
    'last_login_time',
    'is_super' => [
        'callable' => ['\Tools\Labels', 'YesNo'],
        'type' => 'view',
    ],
    'is_enable' => [
        'callable' => ['\Tools\Labels', 'enable'],
        'type' => 'view',
    ]
];
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