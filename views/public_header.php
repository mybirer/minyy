<!DOCTYPE html>
<html>
<head>
  <?php echo ViewHelper::getBeforeHeader(); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ViewHelper::getTitle(); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="robots" content="noindex" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
  <link rel="stylesheet" href="assets/css/AdminLTE.min.css" />
  <link rel="stylesheet" href="plugins/iCheck/square/green.css" />
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php echo ViewHelper::getAfterHeader(); ?>
</head>
<body class="hold-transition <?php echo ViewHelper::getBodyClasses(); ?>">
<?php echo ViewHelper::getBeforeBody(); ?>