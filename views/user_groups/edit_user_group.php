<?php 
    global $obj;
?>
<div class="modal fade" id="editUserGroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=user_groups&do=edit" id="editUserGroupForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Edit User Group"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <label><?php T::__('Group Name'); ?><span class="text-red">*</span></label>
                <input type="text" class="form-control" id="editUserGroupFormName" value="<?php echo $obj->name; ?>" name="editUserGroupFormName" />
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Group ID'); ?></label>
                <input type="text" class="form-control" value="<?php  echo $obj->pk_group_id; ?>" disabled />
                <input type="hidden" id="editUserGroupFormId" value="<?php  echo $obj->pk_group_id; ?>" name="editUserGroupFormId" />
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
            <a class="btn btn-danger" href="index.php?controller=module&action=user_groups&do=remove&id=<?php echo $obj->pk_group_id; ?>"><?php T::__("Delete Group"); ?></a>
            <button type="submit" name="editUserGroupForm" class="btn btn-primary"><?php T::__("Save Group"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>
<script type='text/javascript'>
    setTimeout(function(){ $('#editUserGroupModal').modal('show');},250);
    $('#editUserGroupModal').on('hide.bs.modal', function (e) {
        window.location.href="index.php?controller=module&action=user_groups";
    });
</script>
