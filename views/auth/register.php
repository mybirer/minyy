<?php ViewHelper::getHeader(); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>Minyy</b></a>
  </div>
  <div class="login-box-body">
    <?php if(isset($_SESSION['error_text'])): ?>
    <div class="alert alert-danger">
            <h4><i class="icon fa fa-ban"></i> <?php T::__("Error"); ?></h4>
            <?php echo $_SESSION['error_text']; ?>
    </div>
    <?php endif; ?>
    <p class="login-box-msg"><?php T::__("Register a new membership"); ?></p>
    <form action="" method="post" autocomplete="on">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="fullname" placeholder="<?php T::__("Full Name"); ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="<?php T::__("Email"); ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="<?php T::__("Password"); ?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="repassword" placeholder="<?php T::__("Retype Password"); ?>">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="terms"> <?php T::__("I agree to the <a href='#'>terms</a>"); ?>
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" name="register_form" class="btn btn-primary btn-block btn-flat"><?php T::__("Register"); ?></button>
        </div>
      </div>
    </form>
    <a href="index.php?controller=page&action=login" class="text-center"><?php T::__("I already have a membership"); ?></a>
  </div>
</div>
<?php ViewHelper::getFooter(); ?>