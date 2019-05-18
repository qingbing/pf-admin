<?php
foreach ($navs as $nav) {
    $active = $navFlag == $nav['flag'] ? ' class="active"' : '';
    ?>
    <li<?php echo $active; ?>><a href="<?php echo $nav['url']; ?>"><?php echo $nav['label']; ?></a></li>
    <?php
} ?>