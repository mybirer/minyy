<?php ViewHelper::getHeader(); ?>
<?php 
    global $objList;
    global $paginationHTML;
    global $params;
?>
<section class="content-header">
    <h1>
    <?php T::__("Posts"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li class="active"> <?php T::__("Posts"); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
    <div class="col-xs-12">
    <?php echo MessageHelper::getMessageHTML(); ?>
        <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php T::__("All Posts"); ?></h3>
            <div class="box-toolbox">
            <form id="search-form">
            <div class="input-group input-group-sm pull-left search-form">
                <input type="text" name="table_search" class="form-control pull-right" placeholder="<?php T::__("Search.."); ?>" <?php echo !empty(Functions::getUrlVariableValue("search_term")) ? "value='".htmlspecialchars(urldecode(Functions::getUrlVariableValue("search_term")))."'" : ""; ?> />
                <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
            </form>
            <a href="index.php?controller=module&action=posts&do=add">
                <button type="button" class="btn btn-success pull-right">
                    <i class="fa fa-plus"></i> <?php T::__("New Post"); ?>
                </button>
            </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php T::__("Author"); ?></th>
                    <th><?php T::__("Title"); ?></th>
                    <th><?php T::__("Post Date"); ?></th>
                    <th><?php T::__("Comments"); ?></th>
                    <th><?php T::__("Alias"); ?></th>
                    <th><?php T::__("ID"); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php $i=$params['offset']+1; foreach($objList as $post): ?>
            <tr data-id="<?php echo $post->pk_post_id; ?>">
                <td><a data-toggle="tooltip" title="Düzenle" class="text-red" href="index.php?controller=module&action=posts&do=edit&id=<?php echo $post->pk_post_id; ?>"><i class="fa fa-edit"></i></a></td>
                <td class="has-link"><?php echo $post->author_name; ?></td>
                <td class="has-link"><?php echo $post->post_title; ?></td>
                <td class="has-link"><?php echo $post->post_date; ?></td>
                <td class="has-link"><?php echo $post->comment_count; ?></td>
                <td class="has-link"><?php echo $post->post_alias; ?></td>
                <td class="has-link"><?php echo $post->pk_post_id; ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody></table>
        </div>
        <div class="box-footer clearfix">
            <div class="table-length dataTables_length pull-left">
                <label><?php T::__("Show:"); ?>
                    <select name="limit" class="form-control input-sm">
                    <option value="10" <?php echo Functions::getUrlVariableValue("limit")=="10" ? "selected" : ""; ?>>10</option>
                    <option value="25" <?php echo Functions::getUrlVariableValue("limit")=="25" ? "selected" : ""; ?>>25</option>
                    <option value="50" <?php echo Functions::getUrlVariableValue("limit")=="50" ? "selected" : ""; ?>>50</option>
                    <option value="100" <?php echo Functions::getUrlVariableValue("limit")=="100" ? "selected" : ""; ?>>100</option>
                    </select>
                </label>
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
$('select[name="limit"]').on("change",function(){
    var hash = window.location.search;
    var tt=hash.split("&");
    var route="";
    $.each(tt,function(i,t){
        var q=t.split("=");
        if(q[0]!="limit" && q[0]!="page"){
            route+=t+"&";
        }
    });
    route+="limit="+encodeURIComponent($(this).val());
    location.href=route;
})
$('#search-form').on("submit",function(){
    var hash = window.location.search;
    var tt=hash.split("&");
    var route="";
    $.each(tt,function(i,t){
        var q=t.split("=");
        if(q[0]!="search_term" && q[0]!="page"){
            route+=t+"&";
        }
    });
    route+="search_term="+encodeURIComponent($('input[name="table_search"]').val());
    location.href=route;
    return false;
});
$('button[data-toggle="openModal"]').on('click',function(){
    $($(this).data("target")).modal('show');
    return false;
});
</script>
<?php
ViewHelper::getFooter();
?>