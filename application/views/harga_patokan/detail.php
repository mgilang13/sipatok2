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
                <?php echo '<b>Total Volume</b><br><h4>'.$detail['total_volume'].' M<sup>3</sup></h4>'; ?>
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
                <span class="info-box-number"><?php echo $row['volume'].' M<sup>3</sup>';?><?php echo ' (@Rp'.number_format($row['harga']).')';?></span>
                
                <span class="progress-description"><?php echo $row['kelompok_kayu'];?>
                <span class="progress-description" style="float:right;"><?php echo $row['diameter'];?></span>
                </span>
            </div>
        </div>
        <?php } ?>

        <div class="box-body">
        <?php 
            if($detail['is_verified'] == '0') {
                echo '<b>Status : </b><small class="label label-info"><i class="fa fa-clock-o"></i> Belum diverifikasi</small>';
            } else if ($detail['is_verified'] == '1') {
                echo '<b>Status : </b><small class="label label-success"><i class="fa fa-check-circle"></i> Terverifikasi</small><br>';
                echo '<small class="label label-success"></i>(diproses)</small>';
            } else if ($detail['is_verified'] == '3') {
                echo '<b>Status : </b><small class="label label-success"><i class="fa fa-ban"></i> Terverifikasi</small><br>';
                echo '<small class="label label-success"></i>(tidak diproses)</small>';
            } else if ($detail['is_verified'] == '2') {
                echo '<b>Status : </b><small class="label label-danger"><i class="fa fa-close"></i> Dikembalikan</small>';
            }
        ?>
        </div>
        <?php
            if ($detail['is_verified'] == '2') {
        ?>
            <div class="box box-danger">
            <div class="box-body">
                <span class="info-box-text">Alasan dikembalikan :
                    <a href="#" class="btn btn-danger btn-sm" style="float:right" data-target="#modal-form-edit" data-toggle="modal">
                        <i class="fa fa-edit"></i> Open Form Edit
                    </a>
                </span>
                
                <script>
                    $('#open-form-edit').on('click',function() {
                        window.open ("<?= site_url()."/harga_patokan/data/edit/".$detail['id'] ?>","editWindow","width=1928, height=720,scrollbars=1");
                    });
                </script>
                <span class="progress-description"><?php echo $row['alasan'];?>
                </span>
            </div>
        </div>
        <?php } ?>

        <?php
            if ($user['nama_role'] == "Verifikator" || $user['nama_role'] == "Admin") {
        ?>
        <?php
            echo form_open('harga_patokan/data/verifikasi', 'role="form" class="form-horizontal"');
        ?>
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
            <!-- /.box-body -->
        <?php 
            echo form_close(); 
        ?>
        <?php } ?>
      </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<!-- Modal -->
<div class="modal fade" id="modal-form-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-full" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalFormEditLabel">Form Edit Data</h4>
      </div>
      <div class="modal-body">
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
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?= base_url();?>harga_patokan/data/detail" role="form" enctype="multipart/form-data" class="form-horizontal" method="post" accept-charset="utf-8">
        
                    <input type="hidden" name="id_invoice" value="<?= $detail['id_invoice']; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label class="col-sm-3 control-label">Sumber Dokumen*</label>
                                    <div class="col-sm-9">
                                        <?php
                                            echo cmb_dinamis('id_jenis_dok', 'm_jenis_dok', 'nama', 'id',$detail['id_jenis_dok'],'','','Pilih Jenis Dokumen');
                                        ?>
                                    </div>
                                    </div>
                                <div class="form-group col-xs-6">
                                    <label class="col-sm-3 control-label">Total Harga*</label>
                                    <div class="col-sm-9">
                                        <input type="number" required class="form-control" name="total_harga" placeholder="Masukkan Total Harga" value="<?= $detail['total_harga'] ? $detail['total_harga'] : set_value('nomor_invoice');  ?>" step="0.01">
                                        <span class="text-danger text-bold"><?= form_error('total_harga') ?></span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                
                                <div class="form-group col-xs-6">
                                    <label class="col-sm-3 control-label">Nomor Dokumen*</label>
                                    <div class="col-sm-9">
                                        <input required type="text" name="nomor_invoice" class="form-control" placeholder="Masukkan Nomor Dokumen" value="<?= $detail['nomor_invoice'] ? $detail['nomor_invoice'] : set_value('nomor_invoice') ; ?>">
                                        <span class="text-danger text-bold"><?= form_error('nomor_invoice') ?></span>
                                    </div>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label class="col-sm-3 control-label">Total Volume*</label>
                                    <div class="col-sm-9">
                                        <input type="number" required class="form-control col-sm-6" name="total_volume" placeholder="Masukkan Total Volume Kayu" value="<?= $detail['total_volume'] ? $detail['total_volume'] : set_value('nomor_invoice') ; ?>">
                                        
                                        <span class="text-danger text-bold"><?= form_error('total_volume') ?></span>
                                    </div>
        
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="" class="col-sm-3 control-label">Tanggal Dokumen*</label>
        
                                    <div class="col-sm-9">
                                        <input required type="date" name="tgl_invoice" value="<?= $detail['tgl_invoice'] ? $detail['tgl_invoice'] : set_value('tgl_invoice') ; ?>" class="form-control" placeholder="Masukkan Tanggal Dokumen">
                                    </div>
                                </div>
                                <div class="form-group col-xs-6 control-label">
                                    <div class="col-sm-3">
                                        <label class="control-label">File Dokumen*</label><br>
                                        <small>(Max 10 Mb)</small>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="file" name="file_upload" class="form-control" placeholder = "Masukkan File" accept="application/pdf">
                                        <?php if ($this->session->flashdata('error')) : ?>
                                            <span class="text-danger text-bold"><?= $this->session->flashdata('error'); ?></span>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label class="col-sm-3 control-label"> Pihak Pembeli*</label>
                                    <div class="col-sm-9">
                                        <?php
                                            echo cmb_pbphh('id_pbph_pembeli', 'm_pbph', 'NAMA_PERUSAHAAN', 'NPWSHUT_NO', $detail['id_pbph_pembeli'], '', 'pbph-pembeli', 'PIlih Pihak Pembeli');
                                        ?>
                                        <span class="text-danger text-bold"><?= form_error('id_pbph_pembeli') ?></span>
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
                                
                                
                            </div>
                            <div class="row">
                                <!-- <div class="form-group col-xs-6">
                                    <div class="col-sm-3 control-label">
                                        <label class="control-label">Tempat</label><br>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" name="tempat_invoice" class="form-control" placeholder= "Masukkan Lokasi Penerbitan Dokumen">
                                    </div>
                                </div> -->
                                
                            </div>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">
                                    Tabel Rincian
                                    <a href="#" style="float:right" id="tambah-baris" class="btn btn-sm btn-success">
                                        <i class="fa fa-plus"></i> 
                                        &nbsp; Baris
                                    </a>
                                </div>
                                <!-- Table -->
                                <table class="table table-striped" id="rincian">
                                    <thead>
                                        <tr>
                                            <th>Nama Jenis/Spesies</th>
                                            <th>Kelompok Jenis</th>
                                            <th>Harga Kayu</th>
                                            <th>Volume (M<sup>3</sup>)</th>
                                            <!-- <th>Satuan</th> -->
                                            <th>Sortimen</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($rincian as $r) {?>
                                        <tr>
                                            <td>
                                                <select required name="id_jenis_kayu[]" class="form-control jenis-kayu">    
                                                    <option value="">Masukkan Jenis Kayu</option>
                                                    <?php          
                                                        $data_kayu = $this->db->get('m_jenis_kayu');
                                                        $data_kel_kayu = $this->db->get('m_kelompok_jenis_kayu');
                                                        foreach ($data_kel_kayu->result() as $row) {
                                                            echo "<optgroup label= '$row->KETERANGAN' data-ket= '$row->KETERANGAN'>";
                                                            foreach($data_kayu->result() as $kayu) {
                                                                if($kayu->KEL_NO == $row->KEL_NO) {
                                                                    echo "<option value='".$kayu->KAYU_NO."' ". ($r['id_jenis_kayu'] == $kayu->KAYU_NO ? 'selected' : '') ." >".$kayu->KETERANGAN."</option>";
                                                                }
                                                            }
                                                            echo '</optgroup>';
                                                        }  
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <?php $data_kel_kayu = $this->db->get_where('m_kelompok_jenis_kayu', array('KEL_NO' => $r['KEL_NO']))->row(); ?>
                                                <p class="kel-jenis-kayu"><?= $data_kel_kayu->KETERANGAN; ?></p>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">Rp.</div>
                                                    <input required type="number" name="harga[]" class="form-control" placeholder="Masukkan Harga Kayu" value="<?= $r['harga']; ?>">
                                                    <div class="input-group-addon">.00</div>
        
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input required type="number" name="volume[]" class="form-control" placeholder="Masukkan Volume Kayu" value="<?= $r['volume']; ?>">
                                                </div>
                                            </td>
                                            <!-- <td>
                                                <div class="input-group">
                                                    <?php
                                                        echo cmb_dinamis('id_satuan', 'm_satuan', 'nama', 'id', '', '', 'text-uppercase', 'Pilih Satuan');
                                                    ?>
                                                </div>
                                            </td> -->
                                            <td>
                                                <select select name="id_diameter[]" class="form-control" required>    
                                                    <option>Pilih Sortimen Kayu</option>
                                                    <?php
                                                        $data_diamter = $this->db->get('m_diameters');
                                                        foreach($data_diamter->result() as $row) {
                                                            echo "<option value='".$row->id."' ".($row->id == $r['id_diameter'] ? 'selected' : '').">".$row->diameter."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-danger hapus-baris">
                                                    <i class="fa fa-trash"></i>                                        </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
        
                            <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
        
                            <div class="col-sm-1">
                                <button type="submit" name="submit" class="btn btn-primary btn-flat">Update</button>
                            </div>
        
                            <div class="col-sm-1">
                                <?php
                                echo anchor('tampilan_operator', 'Tutup', array('class'=>'btn btn-danger btn-flat window-close'));
                                ?>
                            </div>
                            </div>
                            <script>
                                $('.window-close').click(function() {
                                    window.close();
                                });
                            </script>
                        </div>
                        <!-- /.box-body -->
                        </form>
                    
                    </form>
                </div>
                <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <script>
            $('#tambah-baris').click(function() {
                let rincian_html = '<tr>'+
                                    '<td>'+
                                        '<select name="id_jenis_kayu[]" class="form-control jenis-kayu">'+    
                                            '<option value="">Masukkan Jenis Kayu</option>'+
                                            "<?php
                                                $data_kayu = $this->db->get('m_jenis_kayu');
                                                $data_kel_kayu = $this->db->get('m_kelompok_jenis_kayu');
                                                foreach ($data_kel_kayu->result() as $row) {
                                                    echo "<optgroup label= '$row->KETERANGAN' data-ket= '$row->KETERANGAN'>";
                                                    foreach($data_kayu->result() as $kayu) {
                                                        if($kayu->KEL_NO == $row->KEL_NO) {
                                                            echo "<option value=".$kayu->KAYU_NO.">".$kayu->KETERANGAN."</option>";
                                                        }
                                                    }
                                                    echo '</optgroup>';
                                                } 
                                            ?>" +
                                        '</select>'+
                                    '</td>'+
                                    '<td>'+
                                        '<p class="kel-jenis-kayu">-</p>' +
                                    '</td>'+
                                    '<td>'+
                                        '<div class="input-group">'+
                                            '<div class="input-group-addon">Rp.</div>'+
                                            '<input type="number" name="harga[]" class="form-control" placeholder="Masukkan Harga Kayu">'+
                                            '<div class="input-group-addon">.00</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+
                                        '<div class="input-group">'+
                                            '<input type="number" name="volume[]" class="form-control" placeholder="Masukkan Volume Kayu">'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+
                                        '<select name="id_diameter[]" class="form-control">'+    
                                            '<option>Pilih Diameter Kayu</option>'+
                                            '<?php
                                                $data_diamter = $this->db->get('m_diameters');
                                                foreach($data_diamter->result() as $row) {
                                                    echo "<option value=".$row->id.">".$row->diameter."</option>";
                                                }
                                            ?>' +
                                        '</select>'+
                                    '</td>'+
                                    '<td>'+
                                        '<a href="#" class="btn btn-sm btn-danger hapus-baris">'+
                                            '<i class="fa fa-trash"></i>'+
                                        '</a>'+
                                    '</td>'+
                                '</tr>';
        
                $('#rincian > tbody:last-child').append(rincian_html);
                $('.hapus-baris').click(function() {
                    $(this).parents("tr").remove();
                });
        
                $('.jenis-kayu').select2({
                    width:'100%'
                });
                $('.jenis-kayu').change(function() {
                    let data_ket = $('.jenis-kayu :selected').parents().attr('data-ket');
                    let row = $(this).closest('tr');
                    row.find('.kel-jenis-kayu').text(data_ket);
                });
            });

            $('.hapus-baris').click(function() {
                    $(this).parents("tr").remove();
                });
        
            $('.jenis-kayu, .pbph-pembeli').select2({
                width:'100%',
                theme:'classic'
            });
            $('.jenis-kayu').change(function() {
                let data_ket = $('.jenis-kayu :selected').parent().attr('data-ket');
                let row = $(this).closest('tr');
                row.find('.kel-jenis-kayu').text(data_ket);
            });
            $('.pbph-pembeli').change(function() {
                let id = $(this).val();
                let kode_prov = id.slice(0,2);
                let kode_kab = id.slice(2,4);
                
                let data_provinsi = <?php echo json_encode($this->db->get('m_provinsi')->result()); ?>;
                let data_kab = <?php echo json_encode($this->db->get('m_kabupaten')->result()); ?>;
                
                let provinsi = data_provinsi.find(p => p.KODE_PROP === kode_prov);
                let kabupaten = data_kab.find(p => p.KODE_CDK === kode_kab && p.KODE_PROP === kode_prov);
        
                $('.provinsi').val(provinsi.KETERANGAN);
                $('.kabupaten').val(kabupaten.KETERANGAN);
            });
            // $('input.harga').on('blur', function() {
            //     const value = this.value.replace(/,/g, '');
            //     this.value = parseFloat(value).toLocaleString('en-US', {
            //         style: 'decimal'
            //     });
            // });
        </script>
      </div>
    </div>
  </div>
</div>