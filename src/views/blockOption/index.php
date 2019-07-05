<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Admin\Models\BlockCategory;
use Helper\Coding;
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-18
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var \Admin\Models\BlockCategory $category
 * @var \Admin\Models\BlockOption[] $models
 */
?>
<div class="margin-bottom">
    <a href="<?php echo $this->createUrl('add', ['key' => $category->key]); ?>" class="btn btn-primary w-modal">
        <i class="fa fa-plus">添加</i>
    </a>
    <a href="<?php echo $this->createUrl('refreshSortOrder', ['key' => $category->key]); ?>"
       class="btn btn-primary ACTION-HREF" data-message="确认刷新表头选项顺序么？" data-is-ajax="true" data-reload="true"><i
                class="fa fa-refresh">刷新排序</i></a>
</div>
<table class="table table-hover table-bordered table-striped w-edit-table"
       data-ajax-url="<?php echo $this->createUrl('edit', ['key' => $category->key]); ?>"
       data-post-data='<?php echo Coding::json_encode(['key' => $category->key], true); ?>'>
    <thead>
    <tr>
        <th class="text-center" width="100px">显示名称</th>
        <th class="text-center" width="80px">链接地址</th>
        <th class="text-center" width="80px">图片</th>
        <th class="text-center" width="80px">显示排序</th>
        <?php
        if (in_array($category->type, [BlockCategory::TYPE_CLOUD_WORDS_LINKS, BlockCategory::TYPE_LIST_LINKS, BlockCategory::TYPE_IMAGES_LINKS,])) {
            ?>
            <th class="text-center" width="50px">新开窗口</th>
            <?php
        }
        ?>
        <th class="text-center" width="50px">启用状态</th>
        <th class="text-center" width="240px">操作</th>
        <th class="text-center">操作显示</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($models as $model) {
        ?>
        <tr data-post-data='<?php echo Coding::json_encode(['id' => $model->id], true); ?>'
            data-tip=".w_display_status">
            <td class="text-left"<?php if ($model->is_open) {
                echo ' data-name="label"';
            } ?>><?php echo $model->label; ?></td>
            <td class="text-left"><?php echo $model->link; ?></td>
            <td class="text-center"><?php if ('' != $model->src) {
                    echo '<img src="' . $model->getImageSrc() . '" width="180px" />';
                } ?></td>
            <td class="text-center"<?php if ($model->is_open) {
                echo ' data-name="sort_order"';
            } ?>><?php echo $model->sort_order; ?></td>

            <?php
            if (in_array($category->type, [BlockCategory::TYPE_CLOUD_WORDS_LINKS, BlockCategory::TYPE_LIST_LINKS, BlockCategory::TYPE_IMAGES_LINKS,])) {
                ?>
                <td class="text-center"<?php if ($model->is_open) {
                    echo ' data-name="is_blank"';
                } ?>>
                    <?php
                    $subOptions = [];
                    if (!$model->is_open) {
                        $subOptions['disabled'] = 1;
                    }
                    echo Html::checkBox('is_blank', !!$model->is_blank, $subOptions); ?>
                </td>
                <?php
            }
            ?>

            <td class="text-center"<?php if ($model->is_open) {
                echo ' data-name="is_enable"';
            } ?>>
                <?php
                $subOptions = [];
                if (!$model->is_open) {
                    $subOptions['disabled'] = 1;
                }
                echo Html::checkBox('is_enable', !!$model->is_enable, $subOptions); ?>
            </td>
            <td class="text-left" data-name="sort_order" data-type="upDown" data-reload="true"
                data-ajax-url="<?php echo $this->createUrl('upDown', ['key' => $category->key, 'id' => $model->id]) ?>">
                <?php if ($model->is_open) { ?>
                    <a href="<?php echo $this->createUrl('editDetail', ['key' => $category->key, 'id' => $model->id]) ?>"
                       class="btn btn-primary w-modal" data-mode="custom"><i class="fa fa-edit">编辑</i></a>
                    <a href="<?php echo $this->createUrl('delete', ['key' => $category->key, 'id' => $model->id]) ?>"
                       class="btn btn-danger ACTION-HREF" data-message="确认要删除该选项么？" data-is-ajax="true" data-reload="true">
                        <i class="fa fa-trash">删除</i>
                    </a>
                <?php } ?>
            </td>
            <td class="w_display_status"></td>
        </tr>
    <?php } ?>
    </tbody>
</table>