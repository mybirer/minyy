<?php
    ViewHelper::setBodyClasses('sidebar-collapse');
    ViewHelper::setAfterHeader('<link href="assets/videojs/video-js.min.css" rel="stylesheet" />');
    ViewHelper::setAfterHeader('<link href="assets/css/editor.css" rel="stylesheet" />');
    ViewHelper::getHeader(); 
    // global $media;
    global $subtitle;
?>
<section class="content">
    <form id="sentences-form">
    <div class="row">
        <div class="col-xs-12 col-md-4 up-block">
            <div class="title-container">
                <h3 class="video-title">
                    <span><?php echo $subtitle->media_name; ?></span> <a href="#" data-toggle="openModal" data-target="#editSubtitleTitleModal"><i class="fa fa-pencil"></i></a>
                    <input type="hidden" name="media_title" value="<?php echo $subtitle->media_name; ?>" />
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
            <div class="video-js vjs-default-skin vjs-fluid vjs-nofull" id="player" controls width="640" height="264" data-setup='{ "inactivityTimeout": 0, "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "<?php echo $subtitle->media_url; ?>"}] }'>
            <video style="width:100%" id="video">
                Your browser does not support HTML5 video.
            </video>
            </div>
        </div>
        <div class="col-xs-12 col-md-3 up-block">
            <div class="button-container">
                <a href="index.php?controller=module&action=medias&do=show&id=<?php echo $subtitle->media_id; ?>" class="btn btn-sm bg-black exit-button"><?php T::__('Exit'); ?></a>
                <a href="#" class="btn btn-sm btn-primary save-button"><?php T::__('Save'); ?></a>
                <a href="index.php?controller=module&action=medias&do=show&id=<?php echo $subtitle->media_id; ?>" class="btn btn-sm btn-success save-and-exit-button"><?php T::__('Save and Exit'); ?></a>
            </div>
            <div class="steps-container">
                <div class="step step-1">
                    <h4>1. <?php T::__('Type What You Hear'); ?></h4>
                    <small>Is all the content subtitled?</small>
                </div>
                <div class="step step-2">
                    <h4>2. <?php T::__('Sync Timing'); ?></h4>
                    <small>Sync subtitles</small>
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
            <?php foreach($subtitle->sentences as $sentence): ?>
            <li class="sub">
                <span class="timing">--</span>
                <span class="subtitle-text"><?php echo $sentence['text']; ?></span>
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
                <textarea class="subtitle-edit" name="texts[]"><?php echo $sentence['text']; ?></textarea>
                <input type="hidden" name="starts[]" value="<?php echo $sentence['start_time']; ?>">
                <input type="hidden" name="ends[]" value="<?php echo $sentence['end_time']; ?>">
            </li>
            <?php endforeach; ?>
            <?php if(empty($subtitle->sentences)): ?>
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
                <textarea class="subtitle-edit" name="texts[]" placeholder="<?php T::__('Type a subtitle and press Enter'); ?>"></textarea>
                <input type="hidden" name="starts[]" value="19.191494040054323">
                <input type="hidden" name="ends[]" value="22.881494040054656">
            </li>
            <?php endif; ?>
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
$token=Functions::getToken($_SESSION['user_id']);
$userid=$_SESSION['user_id'];
$mediaId=$subtitle->media_id;
$subtitleId=$subtitle->pk_subtitle_id;

$script=<<<EOT
<script src="assets/videojs/video.min.js"></script>
<script src="assets/videojs/Youtube.js"></script>
<script src="assets/js/editor.js"></script>
<script>
  $(function() {
	$('#sentences-form').on('submit',function(){
        var values = $(this).serialize();
        $.ajax({
            url: "webservices/ajax.php?ot=ssb&ui={$userid}&token={$token}&mi={$mediaId}&si={$subtitleId}",
            type: "post",
            data: values ,
            success: function (response) {
                console.log(response);
                saved=true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                saved=false;
                console.log(textStatus, errorThrown);
            }
        });
        return false;
	});
  });
</script>
EOT;
ViewHelper::setAfterBody($script);
ViewHelper::getView('medias','edit_subtitle_title');
ViewHelper::getFooter();
?>

