<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open_multipart('user/add', 'role="form" class="form-horizontal"');
            ?>

                <div class="box-body">

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Lengkap</label>

                      <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Username</label>

                      <div class="col-sm-9">
                        <input type="text" name="username" class="form-control" placeholder="Masukan Username">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Password</label>

                      <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" placeholder="Masukan Password">
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Level User</label>

                      <div class="col-sm-5">
                        <?php
                          echo cmb_dinamis('level_user', 'm_roles', 'nama_role', 'id');
                        ?>
                      </div>
                  </div>

                  <hr>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Wilayah <br><i>(Verifikator)</i></label>

                    <div class="col-sm-5">
                      <?php
                        echo cmb_dinamis('id_pulau', 'm_pulau', 'KETERANGAN', 'KODE_PULAU');
                      ?>
                    </div>
                    <p style="font-style:italic">Bisa dikosongkan</p>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Balai <br><i>(Admin Balai)</i></label>

                    <div class="col-sm-5">
                      <?php
                        echo cmb_dinamis('id_balai', 'm_bphp', 'KETERANGAN', 'KODE_BSPHH');
                      ?>
                    </div>
                    <p style="font-style:italic">Bisa dikosongkan</p>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Dinas <br><i>(Admin Dinas)</i></label>

                    <div class="col-sm-5">
                      <?php
                        echo cmb_dinamis('id_dinas', 'm_provinsi', 'KETERANGAN', 'KODE_PROP');
                      ?>
                    </div>
                    <p style="font-style:italic">Bisa dikosongkan</p>
                  </div>
                    
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Instansi / PBPH / Perhutani <br><i>(Operator)</i></label>
                    
                    <div class="col-sm-5">
                      <?php
                        echo cmb_pbphh('id_pbph', 'm_pbph', 'NAMA_PERUSAHAAN', 'NPWSHUT_NO');
                        ?>
                    </div>
                    <p style="font-style:italic">Bisa dikosongkan</p>
                  </div>



                  <div class="form-group">
                      <label class="col-sm-2 control-label"></label>

                      <div class="col-sm-1">
                        <button type="submit" name="submit" class="btn btn-primary btn-flat">Simpan</button>
                      </div>

                      <div class="col-sm-1">
                        <?php
                          echo anchor('user', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
                        ?>
                      </div>
                  </div>

                </div>
                <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<script>
    $("[name='id_pbph']").select2({
        width:'100%'
    });
</script>