<?php ViewHelper::getHeader(); ?>
<?php 
    global $objList;
    global $paginationHTML;
    global $params;
    $type;
    if($_GET['action']=='posts' || $_GET['action']=='pages')
        $type=$_GET['action'];
    else die();
?>
<section class="content-header">
    <h1>
    <?php if($type=='posts') T::__("Posts"); else if($type=='pages') T::__("Pages"); ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> <?php T::__("Dashboard"); ?></a></li>
    <li class="active"> <?php if($type=='posts') T::__("Posts"); else if($type=='pages') T::__("Pages"); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
    <div class="col-xs-12">
    <?php echo MessageHelper::getMessageHTML(); ?>
        <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php if($type=='posts') T::__("All Posts"); else if($type=='pages') T::__("All Pages"); ?></h3>
            <div class="box-toolbox">
            <form id="search-form">
            <div class="input-group input-group-sm pull-left search-form">
                <input type="text" name="table_search" class="form-control pull-right" placeholder="<?php T::__("Search.."); ?>" <?php echo !empty(Functions::getUrlVariableValue("search_term")) ? "value='".htmlspecialchars(urldecode(Functions::getUrlVariableValue("search_term")))."'" : ""; ?> />
                <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
            </form>
            <a href="index.php?controller=module&action=<?php echo $type;?>&do=add" class="btn btn-success pull-right">
                <i class="fa fa-plus"></i> <?php if($type=='posts') T::__("New Post"); else if($type=='pages') T::__("New Page"); ?>
            </a>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover table-bordered" >
            <thead >
                <tr>
                    <th style="width:60px;">#</th>
                    <th><?php T::__("Author"); ?></th>
                    <th><?php T::__("Title"); ?></th>
                    <th><?php T::__("Status"); ?></th>
                    <th><?php T::__("Post Date"); ?></th>
                    <th><?php T::__("Comments"); ?></th>
                    <th><?php T::__("ID"); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php $i=$params['offset']+1; foreach($objList as $post): ?>
            <tr data-id="<?php echo $post->pk_post_id; ?>">
                <td>
                    <a data-toggle="tooltip" title="<?php T::__("Edit"); ?>" class="text-red" href="index.php?controller=module&action=<?php if($type=='posts') T::__("posts"); else if($type=='pages') T::__("pages"); ?>&do=edit&id=<?php echo $post->pk_post_id; ?>"><i class="fa fa-edit"></i></a>
                    <a data-toggle="tooltip" title="<?php T::__("Go to Link"); ?>" class="text-blue pull-right" <?php echo $post->post_status == 'published' ? 'href="'.$post->post_alias.'"' : ''; ?>><i class="fa fa-external-link"></i></a>
                </td>
                <td ><?php echo $post->author_name; ?></td>
                <td ><?php echo $post->post_title; ?></td>
                <td ><?php echo $post->post_status; ?></td>
                <td ><?php echo $post->created_at; ?></td>
                <td ><?php echo $post->comment_count; ?></td>
                <td ><?php echo $post->pk_post_id; ?></td>
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
<?php
ViewHelper::getFooter();
?>