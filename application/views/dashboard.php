<!-- Main content -->
<section class="content">

      <!-- Small boxes (Stat box) -->
      <div class="row">
            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $belum['hasil']; ?></h3>

                  <p>Belum Diverifikasi</p>
                </div>
                <div class="icon">
                  <i class="fa fa-id-badge"></i>
                </div>
                <!-- <a href="<?php echo site_url('admin_harga_patokan/data') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $kembali['hasil']; ?></h3>

                  <p>Dikembalikan</p>
                </div>
                <div class="icon">
                  <i class="fa fa-undo"></i>
                </div>
                <!-- <a href="<?php echo site_url('Tampilan_admin') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $verif1['hasil']; ?></h3>

                  <p>Terverifikasi (diproses)</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-circle"></i>
                </div>
                <!-- <a href="<?php echo site_url('admin_harga_patokan/data') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>

            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $verif2['hasil']; ?></h3>

                  <p>Terverifikasi (tidak diproses)</p>
                </div>
                <div class="icon">
                  <i class="fa fa-ban"></i>
                </div>
                <!-- <a href="<?php echo site_url('admin_harga_patokan/data') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>
            <!-- ./col -->

      </div>
      <!-- /.row -->

</section>
<!-- /.content -->