<?php 
    global $team;
?>
<!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                    <h3><?php echo $team->media_count ?></h3>

                    <p>Total Medias</p>
                    </div>
                    <div class="icon">
                    <i class="fa fa-cloud-upload"></i>
                    </div>
                    <!--<a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                    </a>-->
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3><?php echo $team->subtitle_count ?></h3>

                    <p>Total Translations</p>
                    </div>
                    <div class="icon">
                    <i class="fa fa-cc"></i>
                    </div>
                    <!--<a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                    </a>-->
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                    <h3><?php echo $team->member_count; ?></h3>

                    <p>Total Users</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <!--<a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                    </a>-->
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                    <h3><?php echo $team->topic_count ?></h3>

                    <p>Total Topics</p>
                    </div>
                    <div class="icon">
                    <i class="fa fa-commenting"></i>
                    </div>
                    <!--<a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                    </a>-->
                </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->