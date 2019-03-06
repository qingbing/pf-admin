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
 * Date         :   2019-03-06
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\User $user
 * @var \Admin\Models\FormResetPassword $model
 */
echo Html::beginForm('', 'post', [
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$this->widget('\Widgets\FormGenerator', [
    'model' => $user,
    'options' => [
        'uid',
        'username',
        'nickname',
    ]
]); ?>
<?php $this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => [
        'oldPassword' => [
            'code' => 'oldPassword',
            'allow_empty' => false,
            'input_type' => FormGenerator::INPUT_TYPE_PASSWORD,
            'data_type' => FormGenerator::DATA_TYPE_PASSWORD,
            'tip_msg' => '请输入原始密码',
            'empty_msg' => '原始密码不能为空',
        ],
        'newPassword' => [
            'code' => 'newPassword',
            'allow_empty' => false,
            'input_type' => FormGenerator::INPUT_TYPE_PASSWORD,
            'data_type' => FormGenerator::DATA_TYPE_PASSWORD,
            'tip_msg' => '请输入新密码',
            'empty_msg' => '新密码不能为空',
        ],
        'confirmPassword' => [
            'code' => 'confirmPassword',
            'allow_empty' => false,
            'input_type' => FormGenerator::INPUT_TYPE_PASSWORD,
            'data_type' => FormGenerator::DATA_TYPE_COMPARE,
            'tip_msg' => '确认新密码',
            'empty_msg' => '确认密码不能为空',
            'compare_field' => 'newPassword',
        ],
    ],
]); ?>

<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">确认修改</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
