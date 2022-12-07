<section class="content">
    <!-- <div class="alert alert-danger">
        <h3 class="text-bold">Periode Bulan Januari - Maret akan berakhir dalam 2 hari!</h3>
        <p class="text-bold">Silahkan input data anda</p>
    </div> -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $belum['hasil']; ?></h3>

                  <p>Belum Diverifikasi</p>
                </div>
                <div class="icon">
                  <i class="fa fa-id-badge"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $kembali['hasil']; ?></h3>

                  <p>Dikembalikan</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-xs-4">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $verif['hasil']; ?></h3>

                  <p>Terverifikasi</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-circle"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6">
        <!-- <a href="<?= base_url('harga_patokan/input')?>" class="btn btn-success btn-lg">Input Data</a> -->
    </div>
      </div>
      <!-- /.row -->

</section>