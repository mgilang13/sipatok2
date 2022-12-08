<section class="content">
    <div class="row">
        <div class="col-xs-12">

        <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success" role="alert"><?= $this->session->flashdata('success'); ?></div>
        <?php endif;?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">Data Gagal Disimpan!</div>
        <?php endif; ?>
        
          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Input SK</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('admin_harga_patokan/sk/add', 'role="form" enctype="multipart/form-data" class="form-horizontal"');
            ?>

                <div class="box-body">

                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">Sumber Dokumen</label>
                            <div class="col-sm-9">
                                <select name="jenis_dokumen" id="" class="form-control">
                                    <option value="">Pilih Jenis Dokumen</option>
                                    <option value="invoice">Invoice</option>
                                    <option value="kwitansi">Kwitansi</option>
                                    <option value="kontrak">Kontrak</option>
                                    <option value="dok_jual_beli">Dokumen Jual-Beli</option>
                                    <option value="dok_sah_lain">Dokumen Sah Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">Nomor Dokumen</label>
                            <div class="col-sm-9">
                                <input type="text" name="nomor_invoice" class="form-control" placeholder="Masukkan Nomor Invoice" value="<?= set_value('nomor_invoice'); ?>">
                                <span class="text-danger text-bold"><?= form_error('nomor_invoice') ?></span>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="" class="col-sm-3 control-label">Tgl. Dokumen</label>

                            <div class="col-sm-9">
                                <input type="date" name="tgl_invoice" class="form-control" placeholder="Masukkan Tanggal Invoice">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label"> Pihak Pembeli*</label>
                            <div class="col-sm-9">
                                <select name="id_pbph_pembeli" class="form-control pbph-pembeli">    
                                    <option value="0">Masukkan Pihak Pembeli Terdaftar</option>
                                    <?php
                                        $data_pbph = $this->db->get('m_pbph')->result();
                                        foreach($data_pbph as $row) {
                                            echo "<option value=".$row->NPWSHUT_NO." ".set_select('id_pbph_pembeli', $row->NPWSHUT_NO).">".$row->NAMA_PERUSAHAAN."</option>";
                                        }
                                    ?>
                                </select>
                                <span class="text-danger text-bold"><?= form_error('id_pbph_pembeli') ?></span>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">Total Harga*</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="total_harga" placeholder="Masukkan Total Harga" value="<?= set_value('total_harga') ?>" step="0.01">
                                <span class="text-danger text-bold"><?= form_error('total_harga') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control provinsi" placeholder="Provinsi" disabled>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control kabupaten" placeholder="Kabupaten" disabled>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">Total Volume*</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="total_volume" placeholder="Masukkan Total Volume Kayu" value="<?= set_value('total_volume'); ?>">
                                <span class="text-danger text-bold"><?= form_error('total_volume') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <div class="col-sm-3">
                                <label class="control-label">File Dokumen*</label><br>
                                <small>(Max 1 Mb)</small>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" name="file_upload" class="form-control" placeholder = "Masukkan Tempat Invoice Dibuat" accept="application/pdf">
                                <?php if ($this->session->flashdata('error')) : ?>
                                    <span class="text-danger text-bold"><?= $this->session->flashdata('error'); ?></span>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    

                    <div class="form-group">
                      <label class="col-sm-2 control-label"></label>

                      <div class="col-sm-1">
                        <button type="submit" name="submit" class="btn btn-primary btn-flat">Simpan</button>
                      </div>

                      <div class="col-sm-1">
                        <?php
                          echo anchor('tampilan_operator', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
                        ?>
                      </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <?php echo form_close(); ?>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
