<?php ViewHelper::getHeader(); ?>
<?php 
    global $team;
    global $paginationHTML;
?>
<section class="content-header">
    <h1>
    <?php T::__("Team Dashboard"); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
        <li><a href="index.php?controller=module&action=teams"><i class="fa fa-dashboard"></i> <?php T::__("Teams"); ?></a></li>
        <li class="active"> <?php T::__("Team Dashboard"); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php echo MessageHelper::getMessageHTML(); ?>  
            <?php ViewHelper::getView('teams','header_summary'); ?>
            <div class="box  box-primary">
                <div class="box-header">
                    <h3 class="box-title">Medias</h3>
                    <div class="box-tools">
                        <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Language</th>
                                <th>Duration</th>
                                <th style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Update software</td>
                                <td>17.08.2017</td>
                                <td>Turkish</td>
                                <td>
                                    <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-red">55%</span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Update software</td>
                                <td>17.08.2017</td>
                                <td>Turkish</td>
                                <td>
                                    <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-yellow">70%</span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Update software</td>
                                <td>17.08.2017</td>
                                <td>Turkish</td>
                                <td>
                                    <div class="progress progress-xs progress-striped active">
                                    <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light-blue">30%</span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Update software</td>
                                <td>17.08.2017</td>
                                <td>Turkish</td>
                                <td>
                                    <div class="progress progress-xs progress-striped active">
                                    <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-green">90%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="box box-info container">
                <div class="box-header">
                    <h3 class="box-title">Last Active Users</h3>
                    <a href="" data-toggle="openModal" data-target="#editUsersModal" class="pull-right">Edit Users</a>
                </div>
                <div class="box-body no-padding">
                    <table id="member_table" class="display table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Since</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-7">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Topics</h3>
                    <div class="box-tools">
                        <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Last Message</th>
                                <th>Messages</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>İlk Topic</td>
                                <td>Yusuf</td>
                                <td>17.08.2017</td>
                                <td>yusuf</td>
                                <td>26</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$token=Functions::getToken($_SESSION['user_id']);
$userid=$_SESSION['user_id'];
$teamId=$team->pk_team_id;
// $groupStr=json_encode($groupList);

$script=<<<EOT
<script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(function() {
    $('#member_table').DataTable( {
        processing: true,
        serverSide: true,
        ajax: "webservices/ajax.php?ot=ltm&ui={$userid}&token={$token}&ti={$teamId}"
    } );
    $('a[data-toggle="openModal"]').on('click',function(){
        $($(this).data("target")).modal('show');
        return false;
    });
  });
</script>
EOT;
ViewHelper::setAfterBody($script);
ViewHelper::getView('teams','edit_team_members');
ViewHelper::getFooter();
?>