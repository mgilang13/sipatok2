<?php
    echo form_open('admin_harga_patokan/data/verifikasi', 'role="form" class="form-horizontal"');
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Harga Patokan <b><?php echo $detail['penjual']; ?></b></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            

                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">No. Invoice</label>
                            <div class="col-sm-9">
                                <input type="hidden" value="<?php echo $detail['id'];?>" name="id_invoice">
                                <input type="text" value="<?php echo $detail['nomor_invoice'];?>" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">Tempat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" disabled value="<?php echo $detail['tempat_invoice'];?>">
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">PBPH (Pembeli)</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" disabled value="<?php echo $detail['pembeli'];?>">
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="" class="col-sm-3 control-label">Tgl. Invoice</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" disabled value="<?php echo $detail['tgl_invoice'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" disabled value="<?php echo $detail['provinsi'];?>">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" disabled value="<?php echo $detail['KOTA'];?>">
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="" class="col-sm-3 control-label">Total Volume</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" disabled value="<?php echo $detail['total_volume'];?>">
                            </div>
                            <label for="" class="col-sm-3 control-label">Total Harga</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" disabled value="<?php echo $detail['total_harga'];?>">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">File Invoice</label>
                            <div class="col-sm-9">
                                <input type="file" name="file_upload" class="form-control" placeholder = "Masukkan Tempat Invoice Dibuat" accept="application/pdf">
                            </div>
                        </div>
                    </div> -->
                    <br>
                    <div>
                        <div class="col-sm-6">
                        <?php  foreach($rincian as $row){ ?>
                        <div class="info-box bg-green">
                        <span class="info-box-icon">
                            <i class="ion ion-leaf"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $row['jenis_kayu'];?></span>
                            <span class="info-box-number"><?php echo $row['volume'].' M3';?><?php echo ' (@Rp'.number_format($row['harga']).')';?></span>
                            <div class="progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description"><?php echo $row['kelompok_kayu'];?>
                            <span class="progress-description" style="float:right;"><?php echo $row['diameter'];?></span>
                            </span>
                        </div>
                        </div>
                        <?php } ?>
                        
                    <?php
                        if ($user['nama_role'] == "Verifikator" || $user['nama_role'] == "Admin") {
                    ?>
                    <div class="row">                        <div class="form-group col-xs-6">
                            <label class="col-sm-4 control-label">Verifikasi Data</label>
                            <div class="col-sm-2" style="width:50%">
                                <select name="verifikasi" id="" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="1">Verifikasi</option>
                                    <option value="2">Kembalikan</option>
                                </select>
                            </div>
                        </div>
                            </div>
                        <div class="row">
                        <div class="form-group col-xs-12">
                            <textarea name="alasan" class="form-control" cols="100" row="10" placeholder="Masukkan alasan dikembalikan..."></textarea>
                        </div>
                    </div>
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
                    <?php
                        } else {
                    ?>
                        <div class="col-sm-2">
                            <?php
                                echo anchor('admin_harga_patokan/data', 'Kembali', array('class'=>'btn btn-danger btn-flat btn-lg'));
                            ?>
                        </div>
                    <?php
                        }
                    ?>
                
                    </div>
                    <div class="col-sm-6">
                        <embed src="<?php echo base_url()."uploads/invoices/".$detail['file_upload'].".pdf";?>" width="100%" height="794px" />
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