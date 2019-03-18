<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Models\BlockCategory;
use Html;
use Tools\Labels;
use Tools\TableHeader;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-18
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var array $pager
 * @var array $fixer
 */
echo Html::beginForm(['admin/blockCate/index'], 'get', [
    'class' => 'form-inline margin-bottom',
]); ?>
    <dl class="form-group inline">
        <dt class="control-label">区块类型:</dt>
        <dd>
            <?php echo Html::dropDownList('type', (isset($fixer['type']) ? $fixer['type'] : ''), BlockCategory::types(null, true)); ?>
        </dd>
    </dl>
    <dl class="form-group inline">
        <dt class="control-label">关键字:</dt>
        <dd>
            <?php echo Html::textField('keyword', (isset($fixer['keyword']) ? $fixer['keyword'] : ''), [
                'class' => 'form-control',
            ]); ?>
        </dd>
    </dl>
    <dl class="form-group inline">
        <dd>
            <button class="btn btn-info"><i class="fa fa-search"></i>查询</button>
        </dd>
    </dl>
    <?php echo Html::endForm(); ?>
    <?php
$this->widget('\Widgets\TableView', [
    'header' => TableHeader::getHeader('admin-block_category-list'),
    'dataProcessing' => function ($data) {
        $operate = ' <a href="' . $this->createUrl('detail', ['key' => $data->key]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-list-alt">详情</i></a>';
        if (!in_array($data->type, [BlockCategory::TYPE_CONTENT])) {
            $operate .= ' <a href="' . $this->createUrl('/blockOption/index', ['key' => $data->key]) . '" class="text-info" target="_blank"><i class="fa fa-list">查看子项</i></a>';
        } else if ($data->type == BlockCategory::TYPE_CONTENT) {
            $operate .= ' <a href="' . $this->createUrl('content', ['key' => $data->key]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-edit">编辑内容</i></a>';
        }
        $process = [
            'is_enable' => Labels::enable($data->is_enable),
            'type' => BlockCategory::types($data->type),
            'subOptionCount' => $data->subOptionCount,
            'operate' => $operate,
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>