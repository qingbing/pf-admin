<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-14
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\ReplaceSetting $model
 */
echo Html::beginForm('', 'post', [
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
?>
<dl class="form-group row">
    <dd class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
        <?php
        $this->widget('\Widgets\KindEditor', [
            'model' => $model,
            'mode' => \KindEditor::MODE_FULL,
            'openFlag' => true,
            'contentField' => 'content',
            'folder' => 'replace',
            'width' => '100%',
            'height' => '400px',
            'resizeType' => '2',
        ]);
        ?>
    </dd>
</dl>
<dl class="form-group row">
    <dd class="col-sm-2 col-md-2 col-lg-2 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">保存</i></button>
    </dd>
    <dd class="col-sm-2 col-md-2 col-lg-2">
        <a href="<?php echo $this->createUrl('reset', ['key' => $model->key]); ?>"
           data-message="确认重置该内容么？"
           class="btn btn-primary btn-block ACTION-HREF" data-is-ajax="true" data-reload="true"><i class="fa fa-cog">重置</i></a>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
<dl class="form-group row">
    <dd class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 row"><label>可使用替换标签</label>
    </dd>
</dl>
<dl class="form-group row">
    <dd class="col-sm-8 col-md-8 col-lg-8 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 row">
        <?php
        foreach ($model->getSupportFields() as $key => $label) { ?>
            <div class="col-sm-4 col-md-4 col-lg-4">
                <pre><?php echo "{$label}"; ?></pre>
            </div>
        <?php } ?>
    </dd>
</dl>