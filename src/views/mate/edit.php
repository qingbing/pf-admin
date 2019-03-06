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
 * Date         :   2019-03-06
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\User $model
 */
echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveModalCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
// 设置默认新密码为"123456"
$model->setAttribute('password', '123456');
$options = [
    'uid',
    'username',
    'nickname' => [
        'code' => 'nickname',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入用户昵称',
        'empty_msg' => '用户昵称不能为空',
        'ajax_url' => $this->createUrl('/ajax/uniqueNickname', ['uid' => $model->uid]),
        'allow_empty' => false,
    ],
    'real_name' => [
        'code' => 'real_name',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入真实姓名',
        'allow_empty' => true,
    ],
    'sex' => [
        'code' => 'sex',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::sex(),
    ],
];
// 填写表单
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]);
// 个人密码验证
$this->widget('\Admin\Widgets\MyPassword');
?>
    <dl class="form-group row">
        <dd class="col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
            <button type="submit" class="btn btn-primary" id="submitBtn"><i class="fa fa-save">保存</i></button>
            <button type="button" class="btn btn-primary MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
        </dd>
    </dl>
    <?php echo Html::endForm(); ?>