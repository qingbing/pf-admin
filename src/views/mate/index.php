<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
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
echo Html::beginForm(['admin/mate/index'], 'get', [
    'class' => 'form-inline margin-bottom',
]); ?>
    <dl class="form-group inline">
        <dt class="control-label">启用状态:</dt>
        <dd>
            <?php echo Html::dropDownList('enable', isset($fixer['enable']) ? $fixer['enable'] : '', Labels::enable(null, true), [
                'class' => 'form-control',
            ]); ?>
        </dd>
    </dl>
    <dl class="form-group inline">
        <dt class="control-label">是否超管:</dt>
        <dd>
            <?php echo Html::dropDownList('super', isset($fixer['super']) ? $fixer['super'] : '', Labels::YesNo(null, true), [
                'class' => 'form-control',
            ]); ?>
        </dd>
    </dl>
    <dl class="form-group inline">
        <dt class="control-label">性别:</dt>
        <dd>
            <?php echo Html::dropDownList('sex', isset($fixer['sex']) ? $fixer['sex'] : '', Labels::sex(null, true), [
                'class' => 'form-control',
            ]); ?>
        </dd>
    </dl>
    <dl class="form-group inline">
        <dt class="control-label">账户关键字:</dt>
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
    <div class="margin-bottom">
        <a href="<?php echo $this->createUrl('add'); ?>" class="w-modal btn btn-default">
            <i class="fa fa-plus text-warning">添加</i>
        </a>
    </div>
    <?php
$this->widget('\Widgets\TableView', [
    'header' => TableHeader::getHeader('admin-mate-list'),
    'dataProcessing' => function ($data) {
        $operate = '<a href="' . $this->createUrl('edit', ['uid' => $data->uid]) . '" class="text-primary w-modal" data-mode="custom"><i class="fa fa-edit">编辑</i></a>';
        $operate .= ' <a href="' . $this->createUrl('resetPassword', ['uid' => $data->uid]) . '" class="text-primary w-modal" data-mode="custom"><i class="fa fa-cog">密码重置</i></a>';
        $operate .= ' <a href="' . $this->createUrl('detail', ['uid' => $data->uid]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-list-alt">详情</i></a>';
        if ($data->is_enable == 1) {
            $operate .= ' <a href="' . $this->createUrl('forbid', ['uid' => $data->uid]) . '" class="text-warning w-modal" data-mode="custom"><i class="fa fa-lock">禁用</i></a>';
        } else {
            $operate .= ' <a href="' . $this->createUrl('enable', ['uid' => $data->uid]) . '" class="text-warning w-modal" data-mode="custom"><i class="fa fa-unlock">启用</i></a>';
        }
//        if (U::keyValue('access-mod', 'admin')) {
//            $operate .= ' <a href="' . $this->createUrl('assignRole', ['uid' => $data->uid, 'mod' => 'admin']) . '" class="text-warning w-modal" data-mode="custom"><i class="fa fa-qrcode">角色分配</i></a>';
//        }

        $operate .= ' <a href="' . $this->createUrl('delete', ['uid' => $data->uid]) . '" class="text-danger w-modal" data-mode="custom"><i class="fa fa-trash">删除</i></a>';
        $process = [
            'is_enable' => Labels::enable($data->is_enable),
            'is_super' => Labels::YesNo($data->is_super),
            'sex' => Labels::sex($data->sex),
            'operate' => $operate,
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>