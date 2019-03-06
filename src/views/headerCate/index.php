<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Html;
use Tools\TableHeader;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 *
 * @var \Admin\Components\Controller $this
 * @var array $pager
 * @var array $fixer
 */
echo Html::beginForm(['admin/headerCate/index'], 'get', [
    'class' => 'form-inline margin-bottom',
]); ?>
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
    'header' => TableHeader::getHeader('admin-header_category-list'),
    'dataProcessing' => function ($data) {
        $operate = ' <a href="' . $this->createUrl('detail', ['key' => $data->key]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-list-alt">详情</i></a>';
        $operate .= ' <a href="' . $this->createUrl('/headerOption/index', ['key' => $data->key]) . '" class="text-info" target="_blank"><i class="fa fa-list-alt">查看选项</i></a>';
        $process = [
            'subOptionCount' => $data->subOptionCount,
            'operate' => $operate,
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>