<?php 
    global $obj;
    global $groupList;
?>
<div class="modal fade" id="editTeamModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="index.php?controller=module&action=teams&do=edit" id="editTeamForm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php T::__("Edit Team"); ?></h4>
        </div>
        <div class="modal-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#editTeam" aria-controls="editTeam" role="tab" data-toggle="tab"><?php T::__("Team"); ?></a></li>
                    <li role="presentation"><a href="#editMembers" aria-controls="editMembers" role="tab" data-toggle="tab"><?php T::__("Members"); ?></a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="editTeam">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Team Name'); ?><span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="editTeamFormName" value="<?php echo $obj->name; ?>" placeholder="<?php T::__('Team Name'); ?>" name="editTeamFormName">
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Team Description'); ?><span class="text-red"></span></label>
                        <textarea class="form-control" id="editTeamFormDescription" value="<?php echo $obj->description; ?>" placeholder="<?php T::__('Description'); ?>" name="editTeamFormDescription"></textarea>
                    </div>
                    <div class="form-group has-feedback">
                        <label><?php T::__('Team ID'); ?></label>
                        <input type="text" class="form-control" value="<?php  echo $obj->pk_team_id; ?>" disabled />
                        <input type="hidden" id="editTeamFormId" value="<?php  echo $obj->pk_team_id; ?>" name="editTeamFormId" />
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="editMembers">
                    <div class="form-group has-feedback">
                        <label><?php T::__('Members'); ?></label>
                        <ul class="member-list">
                        <?php foreach($obj->members as $memberObj): ?>
                        <li><input type='hidden' name='editTeamFormMemberNameList[]' value='<?php echo $memberObj->user_id; ?>' /><input type='hidden' name='editTeamFormMemberTypeList[]' value='<?php echo $memberObj->type; ?>' /> <?php echo $memberObj->fullname; ?> (<?php echo ModuleHelper::getNameByValue($groupList,$memberObj->type); ?>) <a href='#' onclick='$(this).parent().remove()' class='red-text'>x</a></li>
                        <?php endforeach; ?>
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
                                <?php foreach($groupList as $groupObj): ?>
                                <option value="<?php echo $groupObj['value']; ?>" <?php echo in_array($groupObj['value'],$obj->members) ? "selected" : "" ?>> <?php echo $groupObj['name']; ?></option>
                                <?php endforeach; ?>
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
            <button type="submit" name="editTeamForm" class="btn btn-primary"><?php T::__("Save Team"); ?></button>
        </div>
        </form>
    </div>
    </div>
</div>
<?php
$token=Functions::getToken($_SESSION['user_id']);
$userid=$_SESSION['user_id'];
$groupStr=json_encode($groupList);

$script=<<<EOT
<script>
  $( function() {
      
      function getNameByValue(val){
        var groupList={$groupStr};
        for(var group in groupList){
            var groupObj=groupList[group];
            if(groupObj.value==val){
                return groupObj.name;
            }
        }
        return val;
      }
    $('#editTeamModal').modal('show');
    $('#add-member').on('click',function(){
        var name=$('#editTeamFormAddName').val();
        var type=$('#editTeamFormAddType').val();
        var id=$('#editTeamFormAddNameHidden').val();
        if(!id || id.length==0){
            alert("Please choose a user from list");
            return false;
        }
        var currents=$('.member-list').find('input[value="'+id+'"]');
        if(currents.length>0){
            alert("This user already choosen. Please choose another user");
            return false;
        }
        $('.member-list').append("<li><input type='hidden' name='editTeamFormMemberNameList[]' value='"+id+"' /><input type='hidden' name='editTeamFormMemberTypeList[]' value='"+type+"' />"+ name +" ("+ getNameByValue(type) +")"+" <a href='#' onclick='$(this).parent().remove()' class='red-text'>x</a></li>");
        
        $('#editTeamFormAddName').val("");
        $('#editTeamFormAddNameHidden').val("");
    });
    var cache = {};
    var isSelect=false;
    $("#editTeamFormAddName").autocomplete({
        source: function (request, response) {
            var term = request.term;
            if ( term in cache ) {
                response( cache[ term ] );
                return;
            }
            $.getJSON("webservices/ajax.php?ot=fmbnoe&ui={$userid}&token={$token}&term=" + term, function (data) {
                var dataArr=$.map(data.returnedUsers, function (value, key) {
                    return {
                        label: value,
                        value: value,
                        id: key
                    };
                });
                cache[ term ] = dataArr;
                response(dataArr);
        });
      },
      change: function( event, ui ) {
            if(ui.item){
                $('#editTeamFormAddNameHidden').val(ui.item.id);
            }
            else{
                $('#editTeamFormAddName').val("");
                $('#editTeamFormAddNameHidden').val("");
            }
      },
      minLength: 2
    });
  } );
</script>
EOT;
ViewHelper::setAfterBody($script);
?>