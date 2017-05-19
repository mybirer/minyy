<?php ViewHelper::getHeader(); ?>
<?php
    global $objList;
    global $paginationHTML;
    global $params;
?>
<section class="content-header">
    <h1>
    <?php T::__("Medias"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li class="active"> <?php T::__("Medias"); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
    <div class="col-xs-12">
    <?php echo MessageHelper::getMessageHTML(); ?>
        <div class="box  box-primary">
                <div class="box-header">
                    <h3 class="box-title">All Medias</h3>
                    <div class="box-toolbox">
                        <form id="search-form">
                        <div class="input-group input-group-sm pull-left search-form">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="<?php T::__("Search.."); ?>" <?php echo !empty(Functions::getUrlVariableValue("search_term")) ? "value='".htmlspecialchars(urldecode(Functions::getUrlVariableValue("search_term")))."'" : ""; ?> />
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        </form>
                        <button type="button" data-toggle="openModal" data-target="#addTeamModal" class="btn btn-success pull-right">
                            <i class="fa fa-plus"></i> <?php T::__("New Media"); ?>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Media Name</th>
                                <th>Team</th>
                                <th>Date</th>
                                <th>Language</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            <?php $i=$params['offset']+1; foreach($objList as $media): ?>
                            <tr data-id="<?php echo $media->pk_media_id; ?>">
                                <td class="has-link"><?php echo $media->name; ?></td>
                                <td class="has-link"><?php echo ($media->pk_team_id == null)?'-':$media->team_name; ?></td>
                                <td class="has-link"><?php echo $media->created_at; ?></td>
                                <td class="has-link"><?php echo $media->lang_code; ?></td>
                                <td class="has-link"><?php echo 'Duration'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                <div class="table-length dataTables_length pull-left">
                    <label><?php T::__("Show:"); ?>
                        <select name="list" class="form-control input-sm" style="width: inherit;">
                            <option value="user" <?php echo Functions::getUrlVariableValue("list")=="My Uploads" ? "selected" : ""; ?>>My Uploads</option>
                            <option value="all" <?php echo Functions::getUrlVariableValue("list")=="All" ? "selected" : ""; ?>>All</option>
                        </select>
                    </label>
                </div>
                <div class="table-length dataTables_length pull-right">
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
            </div>
            </div>
            <?php
            echo $paginationHTML;
            ?>
        </div>
        </div>
    </div>
    </div>
</section>
<script type="text/javascript">
$('td.has-link').on('click',function(){
    window.location.href = "index.php?controller=module&action=medias&do=show&id=" + $(this).parent().data("id");
    return false;
});
</script>
<?php
ViewHelper::getFooter();
?>