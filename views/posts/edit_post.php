<?php ViewHelper::getHeader(); ?>
<?php 
    global $obj;
    $type = $obj->post_type;
?>
<section class="content-header">
    <h1>
    <?php if($type=='post') T::__("Posts"); else if($type=='page') T::__("Pages"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li class="active"> <?php if($type=='post') T::__("Edit Post"); else if($type=='page') T::__("Edit Page"); ?></li>
    </ol>
</section>
<section class="content">
<form method="post" action="index.php?controller=module&action=<?php echo $type=='post'?'posts':'pages'; ?>&do=edit" id="editPostForm" >
    <div class="row">
    <div class="col-xs-9">
    <?php echo MessageHelper::getMessageHTML(); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php if($type=='post') T::__("Edit Post"); else if($type=='page') T::__("Edit Page"); ?></h3>
            </div>
            <div class="box-body table-responsive">
                <div class="box-body pad form-group">
                    <input type="hidden" id="editPostFormId" value="<?php echo $obj->pk_post_id; ?>" name="editPostFormId" />
                    <input class="form-control" type="text" name="title" id="title" placeholder="Title" value="<?php echo $obj->post_title; ?>">
                    <p class="help-block"><b>Permalink: </b>  http://minyy.com/example-title-alias-link-here.php</p>
                    <textarea class="form-control" id="content" name="content" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 16px; line-height: 12px; border: 1px solid #dddddd; padding: 10px;"><?php echo $obj->post_content; ?></textarea>
                </div>
                <div class="box-body pad form-group">
                    <a type="button" href="index.php?controller=module&action=<?php echo $type=='post'?'posts':'pages';?>&do=remove&id=<?php echo $obj->pk_post_id; ?>" class="btn btn-danger pull-right"><?php if($type=='post') T::__("Delete Post"); else if($type=='page') T::__("Delete Page"); ?></a>
                    <a type="button" class="btn btn-default pull-left"><?php T::__("Discard Changes"); ?></a>
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
                <select class="form-control select2" id="status" name="status" style="width: 100%;">
                  <option value="publish" <?php if($obj->post_status == 'published') echo 'selected="selected"';?>><?php T::__("Publish"); ?></option>
                  <option value="draft" <?php if($obj->post_status == 'draft') echo 'selected="selected"';?>><?php T::__("Draft"); ?></option>
                </select>
            </div>
            <div class="box-body table-responsive">
                <label class="help-block pull-left">
                    <input type="checkbox" name="comment_status" id="comment_status" class="flat-red" <?php echo $obj->comment_status=='on'?'checked="true"':'';?>>  
                    &nbsp;<?php T::__("Allow Comments"); ?>
                </label>
                <button type="submit" name="editPostForm" class="btn btn-success pull-right">
                    <?php T::__("Update"); ?>
                </button>
            </div>
        </div>
    </div>
    <?php if($type=='post') {?>
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
    <?php }?>
    </div>
</section>
</form>
<script type="text/javascript">
  $(function () {
    $("#content").wysihtml5();
  });
</script>
<?php
if($type=='post') ViewHelper::getView('posts','select_image');
ViewHelper::getFooter();
?>