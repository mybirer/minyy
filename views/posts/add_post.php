<?php ViewHelper::getHeader();  ?>
<section class="content-header">
    <h1>
    <?php T::__("Posts"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li class="active"> <?php T::__("New Post"); ?></li>
    </ol>
</section>
<form method="post" action="index.php?controller=module&action=posts&do=add" id="addPostForm" name="addPostForm" >
    <section class="content">
        <div class="row">
        <div class="col-xs-9">
        <?php echo MessageHelper::getMessageHTML(); ?>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php T::__("New Post"); ?></h3>
                </div>
                <div class="box-body table-responsive">
                    <div class="box-body pad form-group">
                        <input id="title" name="title" class="form-control" type="text" placeholder="Title">
                        <p class="help-block"><b>Permalink: </b>  http://minyy.com/example-title-alias-link-here.php</p>
                            <textarea class="form-control" id="content" name="content" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 16px; line-height: 12px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="box-body pad form-group">
                        <a href="index.php?controller=module&action=posts" class="btn btn-danger pull-right"><?php T::__("Delete"); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php T::__("Publish"); ?></h3>
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <label><?php T::__("Status"); ?></label>
                    <select id="status" name="status" class="form-control select2" style="width: 100%;">
                        <option value="publish" selected="selected"><?php T::__("Publish"); ?></option>
                        <option value="draft"><?php T::__("Draft"); ?></option>
                    </select>
                </div>
                <div class="box-body table-responsive">
                    <label class="help-block pull-left">
                        <input type="checkbox" class="flat-red">  
                        &nbsp;<?php T::__("Allow Comments"); ?>
                    </label>
                    <button type="submit" data-toggle="save" class="btn btn-success pull-right">
                        <?php T::__("Save"); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php T::__("Featured Image"); ?></h3>
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <button type="button" data-toggle="openModal" data-target="#addImageModal" class="btn pull-right btn-default ">
                        <?php T::__("Select"); ?>
                    </button>
                </div>
            </div>
        </div>
        </div>
    </section>
</form>
<?php
$script=<<<EOT
<script src="plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">
  $(function () {
    $("#content").wysihtml5();
  });
</script>
EOT;
ViewHelper::setAfterBody($script);
ViewHelper::getFooter();
?>