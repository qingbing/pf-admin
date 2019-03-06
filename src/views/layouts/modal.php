<?php
/* @var \Admin\Components\Controller $this */
/* @var string $content */
$assetBaseUrl = \Admin\Components\Pub::getAssetBaseUrl();
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo $assetBaseUrl; ?>/css/main.css">
    <link rel="stylesheet" href="<?php echo $assetBaseUrl; ?>/css/plugins.css">
    <link rel="stylesheet" href="<?php echo $assetBaseUrl; ?>/css/site.css">
    <script src="<?php echo $assetBaseUrl; ?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo $assetBaseUrl; ?>/js/holder.min.js"></script>
    <script src="<?php echo $assetBaseUrl; ?>/js/h.js"></script>
    <script src="<?php echo $assetBaseUrl; ?>/js/autoload.js"></script>
    <script src="<?php echo $assetBaseUrl; ?>/js/common.js"></script>
    <title>Administrator Helper<?php if ($this->getClip('title')) {
            echo " - " . $this->getClip('title');
        } ?></title>
</head>
<body>
<div class="container">
    <h3 class="page-header"><?php if ($this->getClip('title')) {
            echo $this->getClip('title');
        } else {
            echo $this->getId() . '/' . $this->getAction()->getId();
        } ?></h3>
    <div class="row">
        <?php echo $content; ?>
    </div>
</div>
</body>
</html>