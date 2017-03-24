<?php ViewHelper::getHeader(); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>Minyy</b></a>
  </div>
  <div class="login-box-body">
    <?php if(isset($error_text)): ?>
    <div class="alert alert-danger">
            <h4><i class="icon fa fa-ban"></i> Hata!</h4>
            <?php echo $error_text; ?>
    </div>
    <?php endif; ?>
    <p class="login-box-msg">Giriş yap</p>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Giriş Yap</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php ViewHelper::getFooter(); ?>