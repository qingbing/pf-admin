<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
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
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => [
        'uid',
        'username',
        'real_name',
        'nickname',
        'avatar' => [
            'input_type' => \FormGenerator::INPUT_TYPE_FILE,
            'file_extensions' => 'jpg|jpeg|png',
            'allow_empty' => false,
            'empty-msg' => '必须选择上传头像图片',
        ],
    ],
]); ?>

<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">确认上传</i></button>
    </dd>
</dl>

<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <img src="<?php echo $model->getAvatarUrl(); ?>" width="200px" height="200px"/>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
