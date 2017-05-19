<?php 
    global $groupList;
    global $MODULES;
?>
<div class="modal fade" id="addViewLevelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=view_levels&do=add" id="addViewLevelForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Add View Level"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <label><?php T::__('Title'); ?><span class="text-red">*</span></label>
                <input type="text" class="form-control" id="addViewLevelFormTitle" name="addViewLevelFormTitle">
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Groups'); ?></label>
                <div class="form-group">
                  <?php foreach($groupList as $groupObj): ?>
                  <div class="checkbox"><label><input type="checkbox" name="addViewLevelFormGroups[]" value="<?php echo $groupObj->pk_group_id; ?>"><?php echo $groupObj->name; ?></label></div>
                  <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Modules'); ?></label>
                <div class="form-group">
                  <?php foreach($MODULES as $moduleObj=>$moduleVal): ?>
                  <div class="input-group">
                  <div class="checkbox"><label><input data-toggle="select-change" type="checkbox" name="addViewLevelFormModules[]" value="<?php echo $moduleVal["module_key"]; ?>"><?php echo $moduleVal["name"]; ?></label></div>
                    <ul class="sub-list-vertical">
                    <?php $does=!empty(json_decode($moduleVal['does'])) ? json_decode($moduleVal['does']) : []; foreach($does as $doe): ?>
                    <li><div class="checkbox"><label><input type="checkbox" name="addViewLevelFormModule[<?php echo $moduleVal["module_key"]; ?>][]" value="<?php echo $doe; ?>"><?php echo $doe; ?></label></div></li>
                    <?php endforeach; ?>
                    </ul>
                  </div>
                  <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
            <button type="submit" name="addViewLevelForm" class="btn btn-primary"><?php T::__("Save View Level"); ?></button>
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