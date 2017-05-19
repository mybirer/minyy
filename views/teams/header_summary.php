<?php
    global $team;
?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua" style="cursor: pointer;">
        <div class="inner">
        <h3><?php echo $team->media_count ?></h3>
        <p><?php T::__('Total Medias'); ?></p>
        </div>
        <div class="icon">
        <i class="fa fa-cloud-upload"></i>
        </div>
    </div>
    </div>
    <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green" style="cursor: pointer;">
        <div class="inner">
        <h3><?php echo $team->subtitle_count ?></h3>
        <p><?php T::__('Total Translations'); ?></p>
        </div>
        <div class="icon">
        <i class="fa fa-cc"></i>
        </div>
    </div>
    </div>
    <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-yellow" style="cursor: pointer;">
        <div class="inner">
        <h3><?php echo $team->member_count; ?></h3>
        <p><?php T::__('Total Users'); ?></p>
        </div>
        <div class="icon">
        <i class="ion ion-person-add"></i>
        </div>
    </div>
    </div>
    <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-red" style="cursor: pointer;">
        <div class="inner">
        <h3><?php echo $team->topic_count ?></h3>
        <p><?php T::__('Total Topics'); ?></p>
        </div>
        <div class="icon">
        <i class="fa fa-commenting"></i>
        </div>
    </div>
    </div>
</div>