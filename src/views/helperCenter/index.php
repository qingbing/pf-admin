<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Helper\Coding;
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
 * @var \Admin\Models\HelperCenter[] $models
 * @var int $parentId
 */
?>
<div class="margin-bottom">
    <a href="<?php echo $this->createUrl('add', ['parentId' => $parentId]); ?>" class="btn btn-primary w-modal">
        <i class="fa fa-plus">添加</i>
    </a>
    <a href="<?php echo $this->createUrl('refreshSortOrder', ['parentId' => $parentId]); ?>"
       class="btn btn-primary CONFIRM_AJAX" data-message="确认刷新帮助中心顺序么？" data-reload="true"><i
                class="fa fa-refresh">刷新排序</i></a>
</div>
<table class="table table-hover table-bordered table-striped w-edit-table"
       data-ajax-url="<?php echo $this->createUrl('edit', ['parentId' => $parentId]); ?>"
       data-post-data='<?php echo Coding::json_encode(['parentId' => $parentId], true); ?>'>
    <thead>
    <tr>
        <th class="text-center" width="80px">引用代码</th>
        <th class="text-center" width="120px">标签</th>
        <th class="text-center" width="120px">主题</th>
        <th class="text-center" width="60px">排序</th>
        <th class="text-center" width="60px">启用状态</th>
        <th class="text-center" width="60px">是否分类</th>
        <th class="text-center" width="60px">子项数量</th>
        <th class="text-center" width="130px">修改时间</th>
        <th class="text-center">操作</th>
        <th class="text-center" width="100px">操作显示</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($models as $model) {
        ?>
        <tr data-post-data='<?php echo Coding::json_encode(['id' => $model->id], true); ?>'
            data-tip=".w_display_status">
            <td class="text-left"><?php echo $model->code; ?></td>
            <td class="text-left"><?php echo $model->label; ?></td>
            <td class="text-left"><?php echo $model->subject; ?></td>
            <td class="text-center"><?php echo $model->sort_order; ?></td>
            <td class="text-center" data-name="is_enable">
                <?php echo Html::checkBox('is_enable', !!$model->is_enable); ?>
            </td>
            <td class="text-center">
                <?php echo Labels::YesNo($model->is_category); ?>
            </td>
            <td class="text-center"><?php echo $model->subOptionCount; ?></td>
            <td class="text-center">
                <?php echo Html::encode($model->update_time); ?>
            </td>
            <td class="text-left" data-name="sort_order" data-type="upDown" data-reload="true"
                data-ajax-url="<?php echo $this->createUrl('upDown', ['parentId' => $parentId, 'id' => $model->id]) ?>">

                <a href="<?php echo $this->createUrl('detail', ['parentId' => $parentId, 'id' => $model->id]) ?>"
                   class="btn btn-primary w-modal" data-mode="custom"><i class="fa fa-list-alt">详情</i></a>
                <a href="<?php echo $this->createUrl('editDetail', ['parentId' => $parentId, 'id' => $model->id]) ?>"
                   class="btn btn-primary w-modal" data-mode="custom"><i class="fa fa-edit">编辑</i></a>
                <a href="<?php echo $this->createUrl('delete', ['parentId' => $parentId, 'id' => $model->id]) ?>"
                   class="btn btn-danger CONFIRM_AJAX" data-reload="true" data-message="确认要删除该帮助中心主题么？"><i
                            class="fa fa-trash">删除</i></a>

                <?php if ($model->is_category) { ?>
                    <a href="<?php echo $this->createUrl('index', ['parentId' => $model->id]) ?>"
                       class="btn btn-primary" target="_blank"><i class="fa fa-list-alt">查看子项</i></a>
                <?php } ?>

            </td>
            <td class="w_display_status"></td>
        </tr>
    <?php } ?>
    </tbody>
</table>