<!-- Main content -->
<section class="content">

      <!-- Small boxes (Stat box) -->
      <div class="row">
            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $user['hasil']; ?></h3>

                  <p>Belum Diverifikasi</p>
                </div>
                <div class="icon">
                  <i class="fa fa-id-badge"></i>
                </div>
                <a href="<?php echo site_url('user') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $siswa['hasil']; ?></h3>

                  <p>Ditolak</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="<?php echo site_url('siswa') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $guru['hasil']; ?></h3>

                  <p>Terverifikasi</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-circle"></i>
                </div>
                <a href="<?php echo site_url('guru') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

      </div>
      <!-- /.row -->

</section>
<!-- /.content -->