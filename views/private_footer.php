  </div>
  <footer class="main-footer">
      <?php require_once('static/footer.php'); ?>
  </footer>
</div>
<script src="assets/js/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="plugins/fastclick/fastclick.js"></script>
<script src="plugins/iCheck/iCheck.min.js"></script>
<script src="assets/js/app.min.js"></script>
<script src="assets/js/custom.js"></script>
<?php echo ViewHelper::getAfterBody(); ?>
</body>
</html>