<?php
/* @var \Admin\Components\Controller $this */
/* @var string $content ; */
$module = \Admin\Components\Pub::getModule();
$user = \Admin\Components\Pub::getUser();
$this->beginContent('/layouts/html');
?>
    <div class="w-navbar w-navbar-top">
        <div class="container-fluid">
            <a class="w-navbar-brand" href="<?php echo $module->createUrl('/default/index') ?>">Background For Administrator</a>
            <div class="w-navbar-ctrl btn btn-default"><span class="fa fa-bars"></span></div>
            <div class="w-navbar-main">
                <ul class="w-nav"><?php $this->widget('\Admin\Widgets\Nav', [
                        'navFlag' => $this->navFlag,
                    ]); ?></ul>

                <div class="w-navbar-right">
                    <ul class="w-nav">
                        <?php if ($user->getIsSuper()) { ?>
                            <li><a href="<?php echo $module->createUrl('/flush/runtime'); ?>" class="text-warning ACTION-HREF" data-message="确认清理缓存么？" data-is-ajax="true">清理缓存</a></li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo $module->createUrl('/personal/index'); ?>"><?php echo $user->getState('nickname'); ?></a>
                        </li>
                        <li><a href="<?php echo $module->createUrl('/login/logout'); ?>">退出</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="header-container"><!--  占位，漂浮 header 的高度 --></div>
    <div class="container-fluid margin-bottom">
        <div class="row">
            <div class="col-sm-2 col-md-2 col-lg-2 main-left"><?php
                $className = '\Admin\Widgets\LeftMenu' . ucfirst($this->navFlag);
                $this->widget($className); ?></div>
            <div class="col-sm-10 col-md-10 col-lg-10 main-right padding-right">
                <h3 class="page-header"><?php if ($this->getClip('title')) {
                        echo $this->getClip('title');
                    } else {
                        echo $this->getId() . '/' . $this->getAction()->getId();
                    } ?></h3>
                <?php echo $content; ?></div>
        </div>
    </div>
    <div id="footer"><?php $this->widget('\Admin\Widgets\Footer'); ?></div>
<?php $this->endContent(); ?>