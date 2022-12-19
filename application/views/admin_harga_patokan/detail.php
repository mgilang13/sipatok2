<?php
    echo form_open('admin_harga_patokan/data/verifikasi', 'role="form" class="form-horizontal"');
?>

<section class="content">

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">

            <div class="box-body">
                <?php echo '<b>Penjual</b><br><h4>'.$detail['penjual'].'</h4>'; ?>
                <!-- <?php echo $detail['kabupaten_penjual'].', '.$detail['provinsi_penjual'].'<br>'; ?> -->
                <?php echo '<b>Pembeli</b><h4>'.$detail['pembeli'].'</h4>'; ?>
                <!-- <?php echo $detail['kabupaten_pembeli'].', '.$detail['provinsi_pembeli']; ?> -->
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">

            <div class="box-body">
                <?php echo 'No. '.$detail['jenis_dok'].' : '.$detail['nomor_invoice'].'<br>'; ?>
                <?php echo 'Tanggal : '.$detail['tgl_invoice'].'<br>'; ?>
                <?php echo '<br><b>Total Harga</b><br><h4>Rp'.number_format($detail['total_harga']).'</h4>'; ?>
                <?php echo '<b>Total Volume</b><br><h4>'.$detail['total_volume'].' M3</h4>'; ?>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-xs-6">
            <embed src="<?php echo base_url()."uploads/invoices/".$detail['file_upload'].".pdf";?>" width="100%" height="700px" />
        </div>
        <div class="col-xs-6">
        <?php  foreach($rincian as $row){ ?>
        <div class="box box-primary">
            <div class="box-body">
                <span class="info-box-text"><?php echo $row['jenis_kayu'];?></span>
                <span class="info-box-number"><?php echo $row['volume'].' M3';?><?php echo ' (@Rp'.number_format($row['harga']).')';?></span>
                
                <span class="progress-description"><?php echo $row['kelompok_kayu'];?>
                <span class="progress-description" style="float:right;"><?php echo $row['diameter'];?></span>
                </span>
            </div>
        </div>
        <?php } ?>
        
          <div class="box box-primary">
            
                <div class="box-body">
                    
                        
                    <div class="row">

                        <div class="form-group">
                            <input type="hidden" value="<?php echo $detail['id'];?>" name="id_invoice">

                            <label class="col-sm-3 control-label">Verifikasi Data</label>
                            <div class="col-sm-9">
                                <select name="verifikasi" id="" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="1">Verifikasi (Diproses lebih lanjut)</option>
                                    <option value="3">Verifikasi (Tidak dapat diproses)</option>
                                    <option value="2">Kembalikan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Pilih Alasan</label>
                            <div class="col-sm-9">
                                <select name="keterangan" class="form-control" id="keterangan">
                                    <option value="">--Pilih--</option>
                                    <option value="Detail Tidak Sesuai Invoice">Detail tidak sesuai invoice</option>
                                    <option value="Data tidak lengkap">Data tidak lengkap</option>
                                    <option value="Lain-lain" id="lain">Lain-lain</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-10">
                            <textarea id="teks-alasan" disabled name="keterangan" class="form-control" cols="100" row="10" placeholder="Masukkan alasan dikembalikan..."></textarea>
                        </div>
                    </div>
                    <script>
                        $('#keterangan').on('change', function() {
                            let keterangan = this.value;
                            if(keterangan === "Lain-lain") {
                                $('#teks-alasan').attr("disabled", false)
                                $('#teks-alasan').value("");
                            } else {
                                $('#teks-alasan').attr("disabled", true);
                            }
                        });
                    </script>
                    <div class="row">
                        <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-1">
                            <button type="submit" name="submit" class="btn btn-primary btn-flat" style="float: right;">Simpan</button>
                        </div>

                        <div class="col-sm-1">
                            <?php
                            echo anchor('admin_harga_patokan/data', 'Kembali', array('class'=>'btn btn-danger btn-flat'));
                            ?>
                        </div>
                        </div>
                    </div>

                        </div>
                        
                        
                    </div>
                    
                    
                  

                </div>
                <!-- /.box-body -->
                <?php 
                //echo form_close(); ?>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>