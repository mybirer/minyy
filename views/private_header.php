<!DOCTYPE html>
<html>
<head>
  <?php echo ViewHelper::getBeforeHeader(); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ViewHelper::getTitle(); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="robots" content="noindex" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
  <link rel="stylesheet" href="assets/css/AdminLTE.min.css" />
  <link rel="stylesheet" href="assets/css/skins/skin-green.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css" />
  <link rel="stylesheet" href="plugins/iCheck/flat/green.css" />
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" />
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php echo ViewHelper::getAfterHeader(); ?>
</head>
<body class="hold-transition skin-green sidebar-mini <?php echo ViewHelper::getBodyClasses(); ?>">
<?php echo ViewHelper::getBeforeBody(); ?>
<div class="wrapper">
  <header class="main-header">
      <?php require_once('static/header.php'); ?>
  </header>
  <aside class="main-sidebar">
      <?php require_once('static/sidebar.php'); ?>
  </aside>
  <div class="content-wrapper">