<?php 
    global $obj;
    global $groupList;
    global $MODULES;
    $objGroups=json_decode($obj->groups);
    $objModules=json_decode($obj->modules,true);
?>
<div class="modal fade" id="editViewLevelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=view_levels&do=edit" id="editViewLevelForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Edit View Level"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <label><?php T::__('Title'); ?><span class="text-red">*</span></label>
                <input type="text" class="form-control" id="editViewLevelFormTitle" value="<?php echo $obj->title; ?>" name="editViewLevelFormTitle" />
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Groups'); ?></label>
                <div class="form-group">
                  <?php foreach($groupList as $groupObj): ?>
                  <div class="checkbox"><label><input type="checkbox" name="editViewLevelFormGroups[]" value="<?php echo $groupObj->pk_group_id; ?>" <?php echo in_array($groupObj->pk_group_id,$objGroups) ? "checked" : "" ?>><?php echo $groupObj->name; ?></label></div>
                  <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Modules'); ?></label>
                <div class="form-group">
                  <?php foreach($MODULES as $moduleObj=>$moduleVal): ?>
                  <div class="input-group">
                  <div class="checkbox"><label><input data-toggle="select-change" type="checkbox" name="editViewLevelFormModules[]" value="<?php echo $moduleVal["module_key"]; ?>" <?php echo array_key_exists($moduleObj,$objModules) ? "checked" : "" ?>><?php echo $moduleVal["name"]; ?></label></div>
                    <ul class="sub-list-vertical">
                    <?php
                    $does=!empty(json_decode($moduleVal['does'])) ? json_decode($moduleVal['does']) : [];
                    foreach($does as $doe):
                    $checkedStr=array_key_exists($moduleObj,$objModules) && in_array($doe,$objModules[$moduleObj]) ? 'checked' : '';
                    ?>
                    <li><div class="checkbox"><label><input type="checkbox" name="editViewLevelFormModule[<?php echo $moduleVal["module_key"]; ?>][]" value="<?php echo $doe; ?>" <?php echo $checkedStr; ?>><?php echo $doe; ?></label></div></li>
                    <?php endforeach; ?>
                    </ul>
                  </div>
                  <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('View Level ID'); ?></label>
                <input type="text" class="form-control" value="<?php  echo $obj->pk_view_level_id; ?>" disabled />
                <input type="hidden" id="editViewLevelFormId" value="<?php  echo $obj->pk_view_level_id; ?>" name="editViewLevelFormId" />
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
            <a class="btn btn-danger" href="index.php?controller=module&action=view_levels&do=remove&id=<?php echo $obj->pk_view_level_id; ?>"><?php T::__("Delete View Level"); ?></a>
            <button type="submit" name="editViewLevelForm" class="btn btn-primary"><?php T::__("Save View Level"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>
<script type="text/javascript">
$('input[data-toggle="select-change"]').on('change',function(){
    if(this.checked==true){
        $(this).parentsUntil('.form-group').find('input[type="checkbox"]').prop('checked',true);
    }
    else{
        $(this).parentsUntil('.form-group').find('input[type="checkbox"]').prop('checked',false);
    }
});
</script>
<script type='text/javascript'>
    setTimeout(function(){ $('#editViewLevelModal').modal('show');},250);
    $('#editViewLevelModal').on('hide.bs.modal', function (e) {
        window.location.href="index.php?controller=module&action=view_levels";
    });
</script>
