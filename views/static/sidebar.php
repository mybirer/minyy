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
    <li class="<?php echo Functions::isActive('dashboard'); ?>">
        <a href="index.php">
        <i class="fa fa-dashboard"></i> <span><?php echo T::__('Dashboard'); ?></span>
        </a>
    </li>
    <li class="<?php echo Functions::isActive('users'); ?>">
        <a href="index.php?controller=module&action=users"><i class="fa fa-user"></i> <?php echo T::__('Users'); ?></a>
    </li>
    <li class="<?php echo Functions::isActive('user_groups'); ?>">
        <a href="index.php?controller=module&action=user_groups"><i class="fa fa-group"></i> <?php echo T::__('Groups'); ?></a>
    </li>
    <li class="<?php echo Functions::isActive('view_levels'); ?>">
        <a href="index.php?controller=module&action=view_levels"><i class="fa fa-bars"></i> <?php echo T::__('View Levels'); ?></a>
    </li>
    </ul>
</section>
<!-- /.sidebar -->