<?php
global $currentUser;
?>
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
    <div class="pull-left image">
        <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p><?php echo $_SESSION['fullname']; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> <?php echo T::__('Online'); ?></a>
    </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
    <li class="header"><?php echo T::__('NAVIGATION'); ?></li>
    <?php
    foreach($currentUser->modules as $module=>$moduleProps):
    ?>
    <li class="<?php echo Functions::isActive($moduleProps["key"]); ?>">
        <a href="index.php?controller=module&action=<?php echo $moduleProps["key"]; ?>"><i class="fa <?php echo $moduleProps["icon"]; ?>"></i> <?php echo $moduleProps["name"]; ?></a>
    </li>
    <?php endforeach; ?>
    </ul>
</section>
<!-- /.sidebar -->