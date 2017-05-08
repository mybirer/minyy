<?php ViewHelper::getHeader(); ?>
<?php 
    global $obj;
?>
<section class="content-header">
    <h1>
    <?php T::__("Posts"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li class="active"> <?php T::__("Edit Post"); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
    <div class="col-xs-9">
    <?php echo MessageHelper::getMessageHTML(); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php T::__("Edit Post"); ?></h3>
            </div>
            <div class="box-body table-responsive">
                <div class="box-body pad form-group">
                    <input class="form-control" type="text" placeholder="Title" value="<?php echo $obj->post_title; ?>">
                    <p class="help-block"><b>Permalink: </b>  http://minyy.com/example-title-alias-link-here.php</p>
                    <form>
                        <textarea class="form-control" id="content" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 16px; line-height: 12px; border: 1px solid #dddddd; padding: 10px;"><?php echo $obj->post_content; ?></textarea>
                    </form>
                </div>
                <div class="box-body pad form-group">
                    <button type="button" class="btn btn-danger pull-right"><?php T::__("Move Trash"); ?></button>
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
                <select class="form-control select2" style="width: 100%;">
                  <option selected="selected"><?php T::__("Publish"); ?></option>
                  <option><?php T::__("Draft"); ?></option>
                </select>
            </div>
            <div class="box-body table-responsive">
                <button type="button" data-toggle="openModal" data-target="#addUserModal" class="btn pull-left btn-default ">
                    <?php T::__("Preview"); ?>
                </button>
                <button type="button" data-toggle="openModal" data-target="#addUserModal" class="btn btn-success pull-right">
                    <?php T::__("Publish"); ?>
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
<script type="text/javascript">
$('button[data-toggle="openModal"]').on('click',function(){
    $($(this).data("target")).modal('show');
    return false;
});
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $("#content").wysihtml5();
  });
</script>
<?php
ViewHelper::getView('posts','select_image');
ViewHelper::getFooter();
?>