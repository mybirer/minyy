<?php 
    global $groupList;
?>
<div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=teams&do=add" id="addTeamForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Create a New Team"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <label><?php T::__('Team Name'); ?><span class="text-red">*</span></label>
                <input type="text" class="form-control" id="addTeamFormName" placeholder="<?php T::__('Team Name'); ?>" name="addTeamFormName">
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Team Description'); ?><span class="text-red"></span></label>
                <textarea class="form-control" id="addTeamFormDescription" placeholder="<?php T::__('Description'); ?>" name="addTeamFormDescription"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
            <button type="submit" name="addTeamForm" class="btn btn-primary"><?php T::__("Save Team"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>