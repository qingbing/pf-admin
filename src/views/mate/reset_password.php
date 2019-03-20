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
    'nickname',
    'real_name',
    'password' => [
        'code' => 'password',
        'css_id' => 'password',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_PASSWORD,
        'tip_msg' => '请输入密码',
        'allow_empty' => false,
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
        <button type="button" class="btn btn-info" id="fixedPassword"><i class="fa fa-gavel">固定密码</i></button>
        <button type="button" class="btn btn-info" id="randPassword"><i class="fa fa-random">随机密码</i></button>
        <button type="submit" class="btn btn-primary" id="submitBtn"><i class="fa fa-save">保存</i></button>
        <button type="button" class="btn btn-primary MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
<script type="text/javascript">
    jQuery(function () {
        let $password = $('#password');
        // 固定密码
        $('#fixedPassword').on('click', function () {
            $password.val('123456');
        });
        // 随机密码
        $('#randPassword').on('click', function () {
            $password.val(PL.randChar(6));
        });
    });
</script>