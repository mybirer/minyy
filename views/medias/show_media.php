<?php ViewHelper::getHeader(); ?>
<?php
    global $media;
    global $paginationHTML;
?>
<section class="content-header">
    <h1>
    <?php T::__("Media Detail"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Medias"); ?></a></li>
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
                        <iframe width="100%" style="min-height:360px;" src="https://www.youtube.com/embed/VwsofiGZVn8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="box-body">
                    <div class="user-block box-header ">
                        <img class="img-circle" src="assets/img/user1-128x128.jpg" alt="User Image">
                        <button type="button" class="btn btn-danger pull-right"><?php T::__("Delete"); ?>!</button>
                        <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                        <span class="description"><?php if($media->team_name != null || trim($media->team_name) != '' ) echo '<b>Team:</b> <a href="index.php?controller=module&action=teams&do=show&id='.$media->pk_media_id.'">'.$media->team_name.'</a> - '; ?><?php echo $media->created_at; ?></span>
                    </div>
                    <h3 style="margin-top: auto;"><?php echo $media->name; ?></h3>
                    <p><?php echo $media->description; ?></p>
                    <hr style="margin-top: 10px;margin-bottom: 10px;">
                    <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> <?php T::__("Share"); ?></button>
                    <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> <?php T::__("Like"); ?></button>
                    <span class="pull-right text-muted">45 <?php T::__("likes"); ?> - 2 <?php T::__("comments"); ?></span>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">Comments • 94</h2>
                </div>
                <div class="box-body">
                    <form action="#" method="post" class="form-horizontal">
                        <div class="col-sm-1 user-block">
                            <img class="img-circle " src="assets/img/user1-128x128.jpg" alt="User Image">
                        </div>
                        <!-- .img-push is used to add margin to elements next to floating images -->
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
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="assets/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                                <a href="#"><?php echo $media->user_fullname; ?></a>
                                </span>
                            <span class="description">Shared publicly - 7:30 PM today</span>
                        </div>
                        <!-- /.user-block -->
                        <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                        </p>
                        <ul class="list-inline">
                            <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                            <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                            </li>
                            <li class="pull-right">
                            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                (5)</a></li>
                        </ul>

                        <input class="form-control input-sm" type="text" placeholder="Type a comment">
                    </div>
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="assets/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                                <a href="#"><?php echo $media->user_fullname; ?></a>
                                </span>
                            <span class="description">Shared publicly - 7:30 PM today</span>
                        </div>
                        <!-- /.user-block -->
                        <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore the hate as they create awesome
                            tools to help create filler text for everyone from bacon lovers
                            to Charlie Sheen fans.
                        </p>
                        <ul class="list-inline">
                            <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                            <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                            </li>
                            <li class="pull-right">
                            <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                (5)</a></li>
                        </ul>
                        <div class="box-footer box-comments">
                        <div class="box-comment">
                            <!-- User image -->
                            <img class="img-circle img-sm" src="assets/img/user3-128x128.jpg" alt="User Image">

                            <div class="comment-text">
                                <span class="username">
                                    Maria Gonzales
                                    <span class="text-muted pull-right">8:03 PM Today</span>
                                </span><!-- /.username -->
                            It is a long established fact that a reader will be distracted
                            by the readable content of a page when looking at its layout.
                            </div>
                            <!-- /.comment-text -->
                        </div>
                        <!-- /.box-comment -->
                        <div class="box-comment">
                            <!-- User image -->
                            <img class="img-circle img-sm" src="assets/img/user5-128x128.jpg" alt="User Image">

                            <div class="comment-text">
                                <span class="username">
                                    Nora Havisham
                                    <span class="text-muted pull-right">8:03 PM Today</span>
                                </span><!-- /.username -->
                            The point of using Lorem Ipsum is that it has a more-or-less
                            normal distribution of letters, as opposed to using
                            'Content here, content here', making it look like readable English.
                            </div>
                            <!-- /.comment-text -->
                        </div>
                        <!-- /.box-comment -->
                        </div>
                        <input class="form-control input-sm" type="text" placeholder="Type a comment">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Revisions</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <b>Translated Languages (7)</b><span style="float:right;">(<?php echo $media->lang_code; ?>)</span>
                    <ul class="list-unstyled text-muted">
                        <li>en_US (2)</li>
                        <li>tr_TR (1)</li>
                        <li>ch_CH (3)</li>
                        <li>de_DE (1)</li>
                    </ul>
                    <hr style="margin-top: 10px;margin-bottom: 10px;">
                    <botton type="button" class="btn btn-success pull-right">Translate</button>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<?php
ViewHelper::getFooter();
?>