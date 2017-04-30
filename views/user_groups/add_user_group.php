<div class="modal fade" id="addUserGroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=user_groups&do=add" id="addUserGroupForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Add User Group"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <label><?php T::__('Group Name'); ?><span class="text-red">*</span></label>
                <input type="text" class="form-control" id="addUserGroupFormName" name="addUserGroupFormName">
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
            <button type="submit" name="addUserGroupForm" class="btn btn-primary"><?php T::__("Save Group"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>