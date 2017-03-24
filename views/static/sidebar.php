<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
    <div class="pull-left image">
        <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p><?php echo $_SESSION['fullname']; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
    <li class="header">NAVIGASYON</li>
    <li class="<?php echo Functions::isActive('dashboard'); ?> treeview">
        <a href="index.php">
        <i class="fa fa-dashboard"></i> <span>Ana Panel</span>
        </a>
    </li>
    <li class="<?php echo Functions::isActive('forms'); ?> treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
            <span>İletişim Formları</span>
        </a>
        <ul class="treeview-menu">
        <li><a href="index.php?controller=forms&action=show&filter=all"><i class="fa fa-circle-o"></i> Tümü</a></li>
        <li><a href="index.php?controller=forms&action=show&filter=social"><i class="fa fa-circle-o"></i> Sosyal</a></li>
        <li><a href="index.php?controller=forms&action=show&filter=website"><i class="fa fa-circle-o"></i> Web Site</a></li>
        <li><a href="index.php?controller=forms&action=show&filter=direct"><i class="fa fa-circle-o"></i> Elden-Direkt</a></li>
        </ul>
    </li>
    </ul>
</section>
<!-- /.sidebar -->