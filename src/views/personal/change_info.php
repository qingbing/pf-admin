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
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => [
        'uid' => ['type' => 'view'],
        'username' => ['type' => 'view'],
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
        'birthday' => [
            'code' => 'birthday',
            'input_type' => FormGenerator::INPUT_TYPE_TEXT,
            'data_type' => FormGenerator::DATA_TYPE_DATE,
            'tip_msg' => '请选择出生日期',
            'allow_empty' => true,
        ],
        'mobile' => [
            'code' => 'mobile',
            'input_type' => FormGenerator::INPUT_TYPE_TEXT,
            'data_type' => FormGenerator::DATA_TYPE_MOBILE,
            'tip_msg' => '请输入联系手机',
            'allow_empty' => true,
        ],
        'phone' => [
            'code' => 'phone',
            'input_type' => FormGenerator::INPUT_TYPE_TEXT,
            'data_type' => FormGenerator::DATA_TYPE_PHONE,
            'tip_msg' => '请输入联系电话',
            'allow_empty' => true,
        ],
        'qq' => [
            'code' => 'qq',
            'input_type' => FormGenerator::INPUT_TYPE_TEXT,
            'data_type' => FormGenerator::DATA_TYPE_INTEGER,
            'tip_msg' => '请输入您的QQ号码',
            'min' => '10000',
            'allow_empty' => true,
        ],
        'address' => [
            'code' => 'address',
            'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
            'data_type' => FormGenerator::DATA_TYPE_STRING,
            'tip_msg' => '请输入地址',
            'allow_empty' => true,
            'min' => '5',
            'max' => '120',
        ],
        'zip_code' => [
            'code' => 'zip_code',
            'input_type' => FormGenerator::INPUT_TYPE_TEXT,
            'data_type' => FormGenerator::DATA_TYPE_ZIP,
            'min' => '5',
            'max' => '120',
            'allow_empty' => true,
        ],
    ],
]); ?>
    <dl class="form-group row">
        <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
            <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">保存</i></button>
        </dd>
    </dl>
    <?php echo Html::endForm(); ?>