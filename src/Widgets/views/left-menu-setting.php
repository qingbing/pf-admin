<?php
/* @var boolean $isSuper */
$module = \Admin\Components\Pub::getModule();
?>
<div class="w-menu" data-name="admin-left-menu-setting" data-share="false">

    <?php if ($isSuper) { ?>
        <?php if (!empty($siteSetting)) { ?>
            <dl>
                <dt>参数配置</dt>
                <?php foreach ($siteSetting as $setting) { ?>
                    <dd>
                        <a href="<?php echo $module->createUrl('formSetting/index', ['key' => $setting['key']]); ?>"><?php echo $setting['name']; ?></a>
                    </dd>
                <?php } ?>
            </dl>
        <?php } ?>
        <?php if (!empty($replaceSetting)) { ?>
            <dl>
                <dt>模板管理</dt>
                <?php foreach ($replaceSetting as $setting) { ?>
                    <dd>
                        <a href="<?php echo $module->createUrl('replace/index', ['key' => $setting['key']]); ?>"><?php echo $setting['name']; ?></a>
                    </dd>
                <?php } ?>
            </dl>
        <?php } ?>
        <dl>
            <dt>配置管理</dt>
            <dd><a href="<?php echo $module->createUrl('nav/index'); ?>">前台导航</a></dd>
            <dd><a href="<?php echo $module->createUrl('headerCate/index'); ?>">表头管理</a></dd>
            <dd><a href="<?php echo $module->createUrl('formCate/index'); ?>">表单管理</a></dd>
            <dd><a href="<?php echo $module->createUrl('blockCate/index'); ?>">区块管理</a></dd>
            <dd><a href="<?php echo $module->createUrl('staticPage/index'); ?>">静态内容</a></dd>
            <dd><a href="<?php echo $module->createUrl('helperCenter/index'); ?>">帮助中心</a></dd>
        </dl>
    <?php } ?>

    <dl>
        <dt>公告管理</dt>
        <dd><a href="<?php echo $module->createUrl('notice/index'); ?>">公告列表</a></dd>
    </dl>
</div>