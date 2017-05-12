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
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#team" aria-controls="team" role="tab" data-toggle="tab"><?php T::__("Team"); ?></a></li>
                    <li role="presentation"><a href="#add_member" aria-controls="add_member" role="tab" data-toggle="tab"><?php T::__("Add Member"); ?></a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="team">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Team Name'); ?><span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="addTeamFormName" name="addTeamFormName">
                        <i class="fa fa-user form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Team Description'); ?><span class="text-red"></span></label>
                        <textarea class="form-control" id="addTeamFormDescription" placeholder="<?php T::__('Description'); ?>" name="addTeamFormDescription"></textarea>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="add_member">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Username or E-Mail'); ?><span class="text-red">*</span></label>
                        <input type="text" class="form-control" placeholder="<?php T::__('Username or E-Mail'); ?>" id="addMemberFormUsernameOrEmail" name="addMemberFormUsernameOrEmail">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Select any groups'); ?></label>
                        <div class="form-group">
                        <?php foreach($groupList as $groupObj): ?>
                        <div class="checkbox"><label><input type="checkbox" name="addMemberFormGroups[]" value="<?php echo $groupObj[0]; ?>"><?php echo $groupObj[1]; ?></label></div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <a class="btn btn-block btn-info" data-dismiss="modal"><?php T::__("Add"); ?></a>
                    </div>
                    <div class="form-group has-feedback">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php T::__("Username"); ?></th>
                                    <th><?php T::__("Group"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr data-id="#">
                                <td><a data-toggle="tooltip" title="Sil" class="text-red" href="#"><i class="fa fa-edit"></i></a></td>
                                <td class="has-link">erden</td>
                                <td class="has-link">Moderator</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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