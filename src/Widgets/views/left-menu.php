<?php
/* @var boolean $isSuper */
$module = \Admin\Components\Pub::getModule();
?>
<div class="w-menu" data-name="admin-bg-menu" data-share="true">
    <dl>
        <dt>个人信息</dt>
        <dd><a href="<?php echo $module->createUrl('personal/index'); ?>">个人信息</a></dd>
        <dd><a href="<?php echo $module->createUrl('personal/changeInfo'); ?>">修改信息</a></dd>
        <dd><a href="<?php echo $module->createUrl('personal/changeAvatar'); ?>">上传头像</a></dd>
        <dd><a href="<?php echo $module->createUrl('personal/resetPassword'); ?>">重置密码</a></dd>
    </dl>

    <?php if ($isSuper) { ?>
        <dl>
            <dt>人员管理</dt>
            <dd><a href="<?php echo $module->createUrl('mate/index'); ?>">管理员列表</a></dd>
        </dl>
        <!--        --><?php //if (!empty($accessMods)) { ?>
        <!--            <dl>-->
        <!--                <dt>角色管理</dt>-->
        <!--                --><?php //foreach ($accessMods as $key => $name) { ?>
        <!--                    <dd>-->
        <!--                        <a href="--><?php //echo $module->createUrl('accessRole/index', ['key' => $key]); ?><!--">--><?php //echo $name; ?><!--</a>-->
        <!--                    </dd>-->
        <!--                --><?php //} ?>
        <!--            </dl>-->
        <!--        --><?php //} ?>

        <!--        --><?php //if (!empty($siteSetting)) { ?>
        <!--            <dl>-->
        <!--                <dt>参数配置</dt>-->
        <!--                --><?php //foreach ($siteSetting as $setting) { ?>
        <!--                    <dd>-->
        <!--                        <a href="--><?php //echo $module->createUrl('formSetting/index', ['ckey' => $setting['ckey']]); ?><!--">--><?php //echo $setting['name']; ?><!--</a>-->
        <!--                    </dd>-->
        <!--                --><?php //} ?>
        <!--            </dl>-->
        <!--        --><?php //} ?>

        <!--        --><?php //if (!empty(!$replaceSetting)) { ?>
        <!--            <dl>-->
        <!--                <dt>模板管理</dt>-->
        <!--                --><?php //foreach ($replaceSetting as $setting) { ?>
        <!--                    <dd>-->
        <!--                        <a href="--><?php //echo $module->createUrl('replace/index', ['key' => $setting['key']]); ?><!--">--><?php //echo $setting['name']; ?><!--</a>-->
        <!--                    </dd>-->
        <!--                --><?php //} ?>
        <!--            </dl>-->
        <!--        --><?php //} ?>

        <!--        --><?php //if (!empty($navMods)) { ?>
        <!--            <dl>-->
        <!--                <dt>导航管理</dt>-->
        <!--                --><?php //foreach ($navMods as $key => $name) { ?>
        <!--                    <dd>-->
        <!--                        <a href="--><?php //echo $module->createUrl('nav/index', ['key' => $key]); ?><!--">--><?php //echo $name; ?><!--</a>-->
        <!--                    </dd>-->
        <!--                --><?php //} ?>
        <!--            </dl>-->
        <!--        --><?php //} ?>

        <dl>
            <dt>网站配置</dt>
            <dd><a href="<?php echo $module->createUrl('headerCate/index'); ?>">表头设置</a></dd>
            <dd><a href="<?php echo $module->createUrl('formCate/index'); ?>">表单配置</a></dd>
            <dd><a href="<?php echo $module->createUrl('block/index'); ?>">区块配置</a></dd>
            <dd><a href="<?php echo $module->createUrl('static/index'); ?>">静态内容</a></dd>
            <dd><a href="<?php echo $module->createUrl('helper/index'); ?>">帮助中心</a></dd>
        </dl>
    <?php } ?>
    <dl>
        <dt>公告管理</dt>
        <dd><a href="<?php echo $module->createUrl('notice/index'); ?>">公告列表</a></dd>
    </dl>
    <dl>
        <dt>日志查看</dt>
        <dd><a href="<?php echo $module->createUrl('log/login'); ?>">登录日志</a></dd>
        <dd><a href="<?php echo $module->createUrl('log/index'); ?>">操作日志</a></dd>
    </dl>
</div>