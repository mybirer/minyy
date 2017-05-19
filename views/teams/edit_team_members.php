<div class="modal fade" id="editUsersModel" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Edit Users"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane" id="editMembers">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Members'); ?></label>
                        <ul class="member-list">
                        <?php //foreach($obj->members as $memberObj): ?>
                        <li><input type='hidden' name='editTeamFormMemberNameList[]' value='<?php //echo $memberObj->user_id; ?>' /><input type='hidden' name='editTeamFormMemberTypeList[]' value='<?php //echo $memberObj->type; ?>' /> <?php //echo $memberObj->fullname; ?> (<?php //echo ModuleHelper::getNameByValue($groupList,$memberObj->type); ?>) <a href='#' onclick='$(this).parent().remove()' class='red-text'>x</a></li>
                        <?php //endforeach; ?>
                        </ul>
                    </div>
                    <hr />
                    <div class="box no-border">
                        <div class="box-header">
                        <h3 class="box-title"><?php T::__('Add Member'); ?></h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label><?php T::__('Member name or email'); ?><span class="text-red">*</span></label>
                                <input type="text" class="form-control" id="editTeamFormAddName" placeholder="<?php T::__('Type member name or email for search'); ?>" />
                                <input type="hidden" id="editTeamFormAddNameHidden" name="editTeamFormAddName" value="">
                            </div>
                            <div class="form-group">
                                <label><?php T::__('Member type'); ?></label>
                                <select name="editTeamFormAddType" id="editTeamFormAddType" class="form-control">
                                <?php //foreach($groupList as $groupObj): ?>
                                <option value="<?php //echo $groupObj['value']; ?>" <?php //echo in_array($groupObj['value'],$obj->members) ? "selected" : "" ?>> <?php //echo $groupObj['name']; ?></option>
                                <?php //endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <a class="btn btn-success" href="#" id="add-member"><?php T::__("Add Member"); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
        </div>
    </div>
    </div>
</div>