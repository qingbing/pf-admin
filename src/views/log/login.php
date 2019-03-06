<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
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
 */
// 列表显示
$this->widget('\Widgets\TableView', [
    'header' => TableHeader::getHeader('admin-log_login-list'),
    'dataProcessing' => function ($data) {
        $process = [
            'is_success' => Labels::YesNo($data['is_success']),
            'operate' => '<a href="' . $this->createUrl('detail', ['id' => $data['id']]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-list-alt">Detail</i></a>',
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>