<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Log;
use Helper\Format;
use Html;
use Tools\Labels;
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
echo Html::beginForm(['admin/log/index'], 'get', [
    'class' => 'form-inline margin-bottom',
]); ?>
    <dl class="form-group inline">
        <dt class="control-label">日志类型:</dt>
        <dd>
            <?php echo Html::dropDownList('type', (isset($fixer['type']) ? $fixer['type'] : ''), Log::type(true), [
                'class' => 'form-control',
            ]); ?>
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
// 操作日志类型
$logTypes = Log::type();
// 列表显示
$this->widget('\Widgets\TableView', [
    'header' => TableHeader::getHeader('admin-log-list'),
    'dataProcessing' => function ($data) use ($logTypes) {
        $process = [
            'type' => Format::dataValue($data['type'], $logTypes),
            'is_success' => Labels::YesNo($data['is_success']),
            'operate' => '<a href="' . $this->createUrl('detail', ['id' => $data['id']]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-list-alt">Detail</i></a>',
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>