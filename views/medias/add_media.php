<?php 
    global $teamList;
    global $languages;
?>
<div class="modal fade" id="addMediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=medias&do=add" id="addMediaForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("New Media"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="form-group has-feedback">
                <label><?php T::__('Media URL'); ?><span class="text-red">*</span></label>
                <input type="text" class="form-control" id="addMediaFormUrl" placeholder="<?php T::__('E.g.:'); ?> https://www.youtube.com/watch?v=5DUCKGyojpE" name="addMediaFormUrl">
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Media Language'); ?><span class="text-red">*</span></label>
                <select class="form-control" id="addMediaFormLanguage" name="addMediaFormLanguage">
                    <option value="" selected><?php T::__('-Media language is-'); ?></option>
                    <optgroup label="<?php T::__('Populars') ?>">
                    <?php foreach($languages as $language): ?>
                        <?php if($language['lang_status']=="popular"): ?>
                        <option value="<?php echo $language['lang_code']; ?>"><?php echo $language['lang_name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="<?php T::__('Others') ?>">
                    <?php foreach($languages as $language): ?>
                        <?php if($language['lang_status']=="normal"): ?>
                        <option value="<?php echo $language['lang_code']; ?>"><?php echo $language['lang_name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Media Name'); ?></label>
                <input type="text" class="form-control" id="addMediaFormName" placeholder="<?php T::__('Leave blank if you want to get from video'); ?>" name="addMediaFormName">
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Media Description'); ?></label>
                <textarea class="form-control" id="addMediaFormDescription" placeholder="<?php T::__('Leave blank if you want to get from video'); ?>" name="addMediaFormDescription"></textarea>
            </div>
            <div class="form-group has-feedback">
                <label><?php T::__('Team'); ?></label>
                <select class="form-control" id="addMediaFormTeam" placeholder="<?php T::__('Description'); ?>" name="addMediaFormTeam">
                <option value="" selected><?php T::__('-Select Team If You Want-'); ?></option>
                <?php foreach($teamList as $teamObj): ?>
                <option value="<?php echo $teamObj->pk_team_id; ?>"><?php echo $teamObj->name; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-default pull-left" data-dismiss="modal"><?php T::__("Close"); ?></a>
            <button type="submit" name="addMediaForm" class="btn btn-primary"><?php T::__("Save Media"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>
