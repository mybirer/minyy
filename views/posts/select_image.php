<div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=users&do=add" id="addUserForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Add User"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#account" aria-controls="account" role="tab" data-toggle="tab"><?php T::__("Account"); ?></a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php T::__("Profile"); ?></a></li>
                    <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab"><?php T::__("Groups"); ?></a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="account">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Full Name'); ?><span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="addUserFormName" name="addUserFormName">
                        <i class="fa fa-user form-control-feedback"></i>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Username'); ?><span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="addUserFormUsername" name="addUserFormUsername">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Email'); ?><span class="text-red">*</span></label>
                        <input type="email" class="form-control" id="addUserFormEmail" name="addUserFormEmail">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Password'); ?><span class="text-red">*</span></label>
                        <input type="password" class="form-control" id="addUserFormPassword" name="addUserFormPassword">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Retype Password'); ?><span class="text-red">*</span></label>
                        <input type="password" class="form-control" id="addUserFormPassword2" name="addUserFormPassword2">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Country'); ?></label>
                        <input type="text" class="form-control" placeholder="<?php T::__('Country'); ?>" id="addUserFormCountry" name="addUserFormCountry">
                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('City'); ?></label>
                        <input type="text" class="form-control" placeholder="<?php T::__('City'); ?>" id="addUserFormCity" name="addUserFormCity">
                        <span class="glyphicon glyphicon-home form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Phone'); ?></label>
                        <input type="text" class="form-control" placeholder="<?php T::__('Phone'); ?>" id="addUserFormPhone" name="addUserFormPhone">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Picture'); ?></label>
                        <input type="text" class="form-control" placeholder="<?php T::__('Picture'); ?>" id="addUserFormPicture" name="addUserFormPicture">
                        <span class="glyphicon glyphicon-picture form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('About'); ?></label>
                        <textarea class="form-control" placeholder="<?php T::__('About'); ?>" id="addUserFormAbout" name="addUserFormAbout"></textarea>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="groups">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Groups'); ?></label>
                        <div class="form-group">
                        <?php foreach($groupList as $groupObj): ?>
                        <div class="checkbox"><label><input type="checkbox" name="addUserFormGroups[]" value="<?php echo $groupObj->pk_group_id; ?>"><?php echo $groupObj->name; ?></label></div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
            <button type="submit" name="addUserForm" class="btn btn-primary"><?php T::__("Save User"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>