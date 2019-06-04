<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Helper\Coding;
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\HeaderCategory $category
 * @var array $models
 */
?>
<table class="table table-hover table-bordered table-striped w-edit-table"
       data-ajax-url="<?php echo $this->createUrl('edit', ['key' => $category->key]); ?>"
       data-post-data='<?php echo Coding::json_encode(['key' => $category->key], true); ?>'>
    <thead>
    <tr>
        <th class="text-center" width="100px">显示顺序</th>
        <th class="text-center" width="100px">显示名</th>
        <th class="text-center" width="60px">默认值</th>
        <th class="text-center" width="100px">显示位置</th>
        <th class="text-center" width="50px">启用状态</th>
        <th class="text-center" width="50px">可排序</th>
        <th class="text-center" width="150px">操作</th>
        <th class="text-center" width="100px">操作显示</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($models as $model) {
        /* @var $model \Admin\Models\HeaderOption */
        $cssClass = $model->cssClass();
        ?>
        <tr data-post-data='<?php echo Coding::json_encode(['id' => $model->id], true); ?>'
            data-tip=".w_display_status">
            <td class="text-center"><?php echo $model->sort_order; ?></td>
            <td class="text-center"><?php echo $model->label; ?></td>
            <td class="text-center" data-name="default"><?php echo $model->default; ?></td>
            <td class="text-center" data-name="css_class" data-type="select"
                data-options='<?php echo Coding::json_encode($cssClass, true); ?>'><?php echo $cssClass[$model->css_class]; ?></td>
            <?php if ($model->is_required) { ?>
                <td class="text-center">
                    <?php echo Html::checkBox('is_enable', true, ['disabled' => 'disabled']); ?>
                </td>
            <?php } else { ?>
                <td class="text-center" data-name="is_enable">
                    <?php echo Html::checkBox('is_enable', !!$model->is_enable); ?>
                </td>
            <?php } ?>

            <td class="text-center" data-name="is_sortable">
                <?php echo Html::checkBox('is_sortable', !!$model->is_sortable); ?>
            </td>
            <td class="text-center" data-name="sort_order" data-type="upDown" data-reload="true"
                data-ajax-url="<?php echo $this->createUrl('upDown', ['key' => $category->key, 'id' => $model->id]) ?>">
            </td>
            <td class="w_display_status"></td>
        </tr>
    <?php } ?>
    </tbody>
</table>