<?php 
    global $subtitle;
?>
<div class="modal fade" id="editSubtitleTitleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="editSubtitleTitleForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Edit Subtitle Title & Description"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <label><?php T::__('Title'); ?><span class="text-red">*</span></label>
                <input type="text" class="form-control" id="editSubtitleTitleFormName" value="<?php echo $subtitle->media_title; ?>" />
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Description'); ?><span class="text-red">*</span></label>
                <textarea class="form-control" id="editSubtitleTitleFormDescription"><?php echo $subtitle->media_description; ?></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Cancel"); ?></a>
            <button type="submit" class="btn btn-primary"><?php T::__("Save"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>
<script type="text/javascript">
$('#editSubtitleTitleForm').on('submit',function(){
    $('.video-title span').html($('#editSubtitleTitleFormName').val());
    $('[name="media_title"]').val($('#editSubtitleTitleFormName').val());
    $('[name="media_description"]').val($('#editSubtitleTitleFormDescription').val());
    $('#editSubtitleTitleModal').modal('hide');
    return false;
});

</script>