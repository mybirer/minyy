<?php
    ViewHelper::setBodyClasses('sidebar-collapse');
    ViewHelper::setAfterHeader('<link href="assets/flowplayer-7.0.4/skin/skin.css" rel="stylesheet" />');
    ViewHelper::setAfterHeader('<link href="assets/css/editor.css" rel="stylesheet" />');
    ViewHelper::getHeader(); 
    // global $media;
    global $subtitle;
    var_dump($subtitle);
?>
<section class="content">
    <form id="sentences-form">
    <div class="row">
        <div class="col-xs-12 col-md-4 up-block">
            <div class="title-container">
                <h3 class="video-title">
                    <span><?php echo $subtitle->media_title; ?></span> <a href="#" data-toggle="openModal" data-target="#editSubtitleTitleModal"><i class="fa fa-pencil"></i></a>
                    <input type="hidden" name="media_title" value="<?php echo $subtitle->media_title; ?>" />
                    <input type="hidden" name="media_description" value="<?php echo $subtitle->media_description; ?>" />
                </h3>
            </div>
            <div class="instructions-container">
                <h4><?php T::__('Keyboard Commands'); ?> <small><a href="#"><?php T::__('More Commands'); ?> <i class="fa fa-angle-double-right"></i></a></small></h4>
                <div class="tab-key button-wrapper bg-red cursor-pointer" data-toggle="play-pause">
                    <a class="bg-white btn-sm">Tab</a><span class="pull-right"><?php T::__('Play/Pause Video') ?></span>
                </div>
                <div class="tab-key button-wrapper bg-aqua cursor-pointer" data-toggle="skip-back">
                    <a class="bg-white btn-sm">Shift + Tab</a><span class="pull-right"><?php T::__('Skip Back') ?></span>
                </div>
                <div class="tab-key button-wrapper bg-primary">
                    <a class="bg-white btn-sm">Shift + Enter</a><span class="pull-right"><?php T::__('Insert a new line') ?></span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-5 up-block">
            <div class="flowplayer no-toggle" id="player" data-share="false" data-fullscreen="false">
            <video style="width:100%" id="video">
                <source type="video/mp4" src="assets/video.MP4">
                Your browser does not support HTML5 video.
            </video>
            </div>
        </div>
        <div class="col-xs-12 col-md-3 up-block">
            <div class="button-container">
                <button class="btn btn-sm bg-black exit-button"><?php T::__('Exit'); ?></button>
                <button class="btn btn-sm btn-primary save-button"><?php T::__('Save'); ?></button>
                <button class="btn btn-sm btn-success save-and-exit-button"><?php T::__('Save and Exit'); ?></button>
            </div>
            <div class="steps-container">
                <div class="step step-1">
                    <h4>1. <?php T::__('Type What You Hear'); ?></h4>
                    <small>Is all the content subtitled?</small>
                </div>
                <div class="step step-2">
                    <h4>2. <?php T::__('Sync Timing'); ?></h4>
                    <small>Is all the content subtitled?</small>
                </div>
                <div class="step step-3">
                    <h4>3. <?php T::__('Review and Complete'); ?></h4>
                    <small>Watch the video again and verify that the subtitles are complete and correct.<br/>
                    <a href="#" data-toggle="openModal" data-target="#editSubtitleTitleModal">Edit title and description.</a></small>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4 down-block">
        </div>
        <div class="col-xs-12 col-md-5 down-block">
            <div class="subtitle-container">
            <ul class="subtitle-list">
            <li class="sub">
                <span class="timing">--</span>
                <span class="subtitle-text"><?php T::__('Type a subtitle and press Enter'); ?></span>
                <div class="sub-toolbox">
                    <div class="sub-toolbox-inside">
                        <a href="#" class="sub-tools"><i class="fa fa-wrench"></i></a>
                        <ul class="sub-toolbox-menu">
                            <li><a class="jump-to" title="Seek to subtitle"><i class="fa fa-sign-in"></i></a></li>
                            <li><a class="insert-top" title="Insert subtitle above"><i class="fa fa-arrow-circle-o-up"></i></a></li>
                            <li><a class="insert-down" title="Insert subtitle below"><i class="fa fa-arrow-circle-o-down"></i></a></li>
                            <li><a class="remove" title="Delete subtitle"><i class="fa fa-close"></i></a></li>
                        </ul>
                    </div>
                </div>
                <textarea class="subtitle-edit" name="sentences[]" placeholder="<?php T::__('Type a subtitle and press Enter'); ?>"></textarea>
            </li>
            </ul>
            </div>
        </div>
        <div class="col-xs-12 col-md-3 down-block">
            <div class="suggestion-container">
                <h4><?php T::__('Suggestions'); ?></h4>
                <ul class="suggest-list">
                    <li>Gitmek</li>
                    <li>Gitti</li>
                    <li>Gidecek</li>
                </ul>
            </div>
        </div>
    </div>
    </form>
</section>

<?php
$script=<<<EOT
<script src="assets/flowplayer-7.0.4/flowplayer.min.js"></script>
<script src="assets/js/editor.js"></script>
EOT;
ViewHelper::setAfterBody($script);
ViewHelper::getView('medias','edit_subtitle_title');
ViewHelper::getFooter();
?>

