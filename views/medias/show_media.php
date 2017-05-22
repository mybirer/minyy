<?php ViewHelper::getHeader(); ?>
<?php
    global $media;
    global $languages;
    global $comments;
?>
<section class="content-header">
    <h1>
    <?php T::__("Media Detail"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li><a href="index.php?controller=module&action=medias"><i class="fa fa-dashboard"></i> <?php T::__("Medias"); ?></a></li>
    <li class="active"> <?php T::__("Media Detail"); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-8">
        <?php echo MessageHelper::getMessageHTML(); ?>
            <div class="box no-border">
                <div class="media">
                    <div class="media-body">
                        <iframe width="100%" style="min-height:360px;" src="https://youtube.com/embed/<?php echo ModuleHelper::getYoutubeIdFromUrl($media->media_url); ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="box-body">
                    <h3 style="margin-top: auto;"><?php echo $media->name; ?></h3>
                    <p><?php echo $media->description; ?></p>
                    <div class="media-meta">
                        <a href="index.php?controller=module&action=medias&do=remove&id=<?php echo $media->pk_media_id; ?>" data-toggle="remove-button" class="btn btn-danger pull-right"><?php T::__("Delete Media"); ?></a>
                        <p><?php T::__('Added by:'); ?> <a href="#" class="username"><?php echo $media->user_fullname; ?></a> <?php echo T::__('Added at: '); echo $media->created_at; ?></p>
                        <?php if(!empty($media->team_name)): ?>
                            <span class="description">
                                <b><?php T::__('Team:'); ?></b> <a href="index.php?controller=module&action=teams&do=show&id=<?php echo $media->pk_media_id; ?>"><?php echo $media->team_name; ?></a>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">Comments • <?php echo count($comments);?></h2>
                </div>
                <div class="box-body">
                    <form action="#" method="post" class="form-horizontal">
                        <div class="col-sm-1 user-block">
                            <img class="img-circle " src="assets/img/user1-128x128.jpg" alt="User Image">
                        </div>
                        <div class="img-push col-sm-8">
                            <textarea type="text" class="form-control input-sm" placeholder="Press enter to post comment"></textarea>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary pull-right btn-block">Send</button>
                        </div>
                    </form>
                </div>
                <hr style="margin-top: 10px;margin-bottom: 10px;">
                <div class="box-body">
                    <?php foreach($comments as $comment): ?>
                    <div class="post" data-comment-id="<?php echo $comment->pk_comment_id; ?>">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="assets/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                                <a href="#"><?php echo $comment->created_by_fullname; ?></a>
                                </span>
                            <span class="description"><?php echo $comment->created_at; ?></span>
                        </div>
                        <p>
                            <?php echo $comment->content; ?>
                        </p>
                        <ul class="list-inline">
                            <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                            </li>
                            <li class="pull-right">
                            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                (<?php echo count($comment->child_comments);?>)</a></li>
                        </ul>
                        <div class="box-footer box-comments">
                        <?php foreach($comment->child_comments as $child):?>
                        <div class="box-comment">
                            <img class="img-circle img-sm" src="assets/img/user5-128x128.jpg" alt="User Image">
                            <div class="comment-text">
                                <span class="username">
                                    <?php echo $child->created_by_fullname; ?>
                                    <span class="text-muted pull-right"><?php echo $child->created_at; ?></span>
                                </span>
                            <?php echo $child->content; ?>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <form>
                            <div class="input-group">
                                <input type="hidden" name="parent_id" value="<?php echo $comment->pk_comment_id; ?>">
                                <input class="form-control input-sm" type="text" placeholder="Type a comment">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-sm">Send</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php T::__('Contribute') ?></h3>
                </div>
                <div class="box-body">
                    <div class="alert alert-dismissible bg-gray">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-info"></i><?php T::__('Contribute This Media'); ?></h4>
                        <p><?php T::__('You can improve this medias translations via click on language at below'); ?></p>
                    </div>
                    <p><?php T::__('This video is in ');?><b><?php echo $languages[$media->lang_code]['lang_name']; ?></b></p>
                    <p><a href="#" data-toggle="openModal" data-target="#addSubtitleModal"> <i class="fa fa-pencil"></i> <?php T::__('Add a new language!'); ?></a></p>
                    <p><?php echo count($media->subtitles); ?> <?php T::__('Languages'); ?></p>
                    <hr />
                    <p><b><?php T::__('Languages'); ?></b></p>
                    <ul class="list-unstyled text-muted">
                        <?php foreach($media->subtitles as $subtitle): ?>
                        <li>
                            <i class="fa fa-circle text-yellow"></i>
                            <a href="index.php?controller=module&action=medias&do=editor&id=<?php echo $media->pk_media_id; ?>&ml=<?php echo $subtitle['lang_code']; ?>">
                                <?php echo $languages[$subtitle['lang_code']]['lang_name']; ?>
                            </a> <?php echo $media->lang_code==$subtitle['lang_code'] ? '('.T::__('original',true).')' : '' ?> (<?php T::__('incomplete'); ?>)
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$script=<<<EOT
<script type="text/javascript">
$(function() {
    $('a[data-toggle="remove-button"]').on('click',function(){
        if(confirm("Are you sure for delete this media?")){
            return true;
        }
        return false;
    });
});
</script>
EOT;
ViewHelper::setAfterBody($script);
ViewHelper::getView('medias','add_subtitle');

ViewHelper::getFooter();
?>