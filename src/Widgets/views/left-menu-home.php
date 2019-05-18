<?php
/* @var boolean $isSuper */
$module = \Admin\Components\Pub::getModule();
?>
<div class="w-menu" data-name="admin-left-menu-home" data-share="false">
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
    <?php } ?>

    <dl>
        <dt>日志查看</dt>
        <dd><a href="<?php echo $module->createUrl('log/login'); ?>">登录日志</a></dd>
        <dd><a href="<?php echo $module->createUrl('log/index'); ?>">操作日志</a></dd>
    </dl>

    <dl>
        <dt>其他信息</dt>
        <dd><a href="<?php echo $module->createUrl('contact/index'); ?>">联系我们</a></dd>
        <dd><a href="http://www.phpcorner.net/" target="_blank">技术支持</a></dd>
    </dl>
</div>