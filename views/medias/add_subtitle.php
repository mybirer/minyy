<?php 
    global $teamList;
    global $media;
    global $languages;
?>
<div class="modal fade" id="addSubtitleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=medias&do=add_subtitle&id=<?php echo $media->pk_media_id; ?>" id="addSubtitleForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Add Language"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <p><?php T::__('This video is in ');?><b><?php echo $languages[$media->lang_code]['lang_name']; ?></b></p>
                <label><?php T::__('Subtitle into'); ?><span class="text-red">*</span></label>
                <select class="form-control" id="addSubtitleFormLanguage" name="addSubtitleFormLanguage">
                    <option value="" selected><?php T::__('-Select Language-'); ?></option>
                    <optgroup label="<?php T::__('Populars') ?>">
                    <?php foreach($languages as $language): ?>
                        <?php if($language['lang_status']=="popular" && ($language['lang_code']!=$media->lang_code) && !array_key_exists($language['lang_code'],$media->subtitles)): ?>
                        <option value="<?php echo $language['lang_code']; ?>"><?php echo $language['lang_name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="<?php T::__('Others') ?>">
                    <?php foreach($languages as $language): ?>
                        <?php if($language['lang_status']=="normal" && ($language['lang_code']!=$media->lang_code) && !array_key_exists($language['lang_code'],$media->subtitles)): ?>
                        <option value="<?php echo $language['lang_code']; ?>"><?php echo $language['lang_name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Cancel"); ?></a>
            <button type="submit" name="addSubtitleForm" class="btn btn-primary"><?php T::__("Continue"); ?></button>
            <input type="hidden" name="addSubtitleFormMediaName" value="<?php echo $media->name; ?>" />
            <input type="hidden" name="addSubtitleFormMediaDescription" value="<?php echo $media->description; ?>" />
        </div>
        </form>
    </div>
    </div>
</div>
<?php
$script=<<<EOT
<script type="text/javascript">
$(function() {
    $('#addSubtitleForm').on('submit',function(){
        var lang=$('#addSubtitleFormLanguage').val();
        if(lang.length==0){
            alert("Please select language!");
            return false;
        }
    });
});
</script>
EOT;
ViewHelper::setAfterBody($script);
?>