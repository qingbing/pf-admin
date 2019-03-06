<?php
$module = \Admin\Components\Pub::getModule();
$user = \Admin\Components\Pub::getUser();
?><div class="container-fluid">
    <a class="w-navbar-brand" href="<?php echo $module->createUrl('/default/index') ?>">Background For
        Administrator</a>
    <div class="w-navbar-ctrl btn btn-default"><span class="fa fa-bars"></span></div>
    <div class="w-navbar-main">
        <ul class="w-nav">
            <li><a href="<?php echo $module->createUrl('/personal/index'); ?>">个人信息</a></li>
            <li><a href="<?php echo $module->createUrl('/contact/index'); ?>">联系我们</a></li>
        </ul>

        <div class="w-navbar-right">
            <ul class="w-nav">
                <li>
                    <a href="<?php echo $module->createUrl('/personal/index'); ?>"><?php echo $user->getState('nickname'); ?></a>
                </li>
                <li><a href="<?php echo $module->createUrl('/login/logout'); ?>">退出</a></li>
            </ul>
        </div>
    </div>
</div>
