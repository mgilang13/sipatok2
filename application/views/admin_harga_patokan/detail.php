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
                        
                    </div>
                    <!-- <div class="row">
                        
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">File Invoice</label>
                            <div class="col-sm-9">
                                <input type="file" name="file_upload" class="form-control" placeholder = "Masukkan Tempat Invoice Dibuat" accept="application/pdf">
                            </div>
                        </div>
                    </div> -->
                    <div class="panel panel-default">
                        
                        <!-- Table -->
                        <table class="table table-striped" id="rincian">
                            <thead>
                                <tr>
                                    <th>Nama Jenis/Spesies</th>
                                    <th>Kelompok Jenis</th>
                                    <th>Harga Kayu</th>
                                    <th>Volume (m<sup>3</sup>)</th>
                                    <th>Diameter</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  foreach($rincian as $row){ ?>
                                <tr>
                                    <td>
                                        <div class="col-sm-12">
                                            <input type="text" disabled value="<?php echo $row['jenis_kayu'];?>" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <input type="text" disabled value="<?php echo $row['kelompok_kayu'];?>" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <input type="text" disabled value="<?php echo $row['harga'];?>" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <input type="text" disabled value="<?php echo $row['volume'];?>" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <input type="text" disabled value="<?php echo $row['diameter'];?>" class="form-control">
                                        </div>
                                    </td>
                                   
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="box-body">

                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">Verifikasi Data</label>
                            <div class="col-sm-9">
                                <select name="verifikasi" id="" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <option value="1">Verifikasi</option>
                                    <option value="2">Kembalikan</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-group col-xs-6">
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