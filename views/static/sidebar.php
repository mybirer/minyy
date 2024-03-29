<?php
global $currentUser;
global $MODULES;
?>
<section class="sidebar">
    <div class="user-panel">
    <div class="pull-left image">
        <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p><?php echo $currentUser->fullname; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> <?php echo T::__('Online'); ?></a>
    </div>
    </div>
    <ul class="sidebar-menu">
    <li class="header"><?php echo T::__('NAVIGATION'); ?></li>
    <?php
    foreach($currentUser->modules as $module=>$moduleProps):
    ?>
    <li class="<?php echo Functions::isActive($module); ?>">
        <a href="index.php?controller=module&action=<?php echo $module; ?>"><i class="fa <?php echo $MODULES[$module]["icon"]; ?>"></i><span><?php echo $MODULES[$module]["name"]; ?></span></a>
    </li>
    <?php endforeach; ?>
    </ul>
</section>