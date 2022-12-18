<section class="content">
    <!-- <div class="alert alert-danger">
        <h3 class="text-bold">Periode Bulan Januari - Maret akan berakhir dalam 2 hari!</h3>
        <p class="text-bold">Silahkan input data anda</p>
    </div> -->
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
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-3 panel">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $kembali['hasil']; ?></h3>

                  <p>Dikembalikan</p>
                </div>
                <div class="icon">
                  <i class="fa fa-undo"></i>
                </div>
              </div>
              <div class="list-group" style="max-height:100px; overflow: auto">
                <?php
                foreach($notifikasi_dikembalikan->result() as $nd) {
                ?>
                <a href="<?php echo site_url('harga_patokan/data/detail/'.$nd->id) ?>" class="list-group-item">
                  <h4 class="list-group-item-heading"><?= $nd->NAMA_PERUSAHAAN; ?></h4>
                  <p class="list-group-item-text">Nomor Invoice: <b><?= $nd->nomor_invoice; ?></b></p>
                </a>
                <?php } ?>
              </div>
              <!-- <a href="#" class="btn btn-danger btn-lg" style="float:right"><i class="fa fa-list"></i> &nbsp; Detail</a> -->
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $verif['hasil']; ?></h3>

                  <p>Terverifikasi (diproses)</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-circle"></i>
                </div>
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
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6">
        <!-- <a href="<?= base_url('harga_patokan/input')?>" class="btn btn-success btn-lg">Input Data</a> -->
    </div>
      </div>
      <!-- /.row -->

</section>