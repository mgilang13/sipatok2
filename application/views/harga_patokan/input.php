<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Input Harga Patokan <b><?= $pbph['NAMA_PERUSAHAAN']; ?></b></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php
                echo form_open('harga_patokan/input/add', 'role="form" class="form-horizontal"');
            ?>

                <div class="box-body">

                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">No. Invoice</label>
                            <div class="col-sm-9">
                                <input type="text" name="nomor_invoice" class="form-control" placeholder="Masukkan Nomor Invoice">
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="" class="col-sm-3 control-label">Tgl. Invoice</label>

                            <div class="col-sm-9">
                                <input type="date" name="tgl_invoice" class="form-control" placeholder="Masukkan Tanggal Invoice">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">PBPH (Pembeli)</label>
                            <div class="col-sm-9">
                                <select name="id_pbph_pembeli" class="form-control pbph-pembeli">    
                                    <option>Masukkan Nama PBPH Terdaftar</option>
                                    <?php
                                        $data_pbph = $this->db->get('m_pbph')->result();
                                        foreach($data_pbph as $row) {
                                            echo "<option value=".$row->NPWSHUT_NO.">".$row->NAMA_PERUSAHAAN."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control provinsi" placeholder="Provinsi">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control kabupaten" placeholder="Kabupaten">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">Tempat</label>
                            <div class="col-sm-9">
                                <input type="text" name="tempat_invoice" class="form-control" placeholder = "Masukkan Tempat Invoice Dibuat">
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label class="col-sm-3 control-label">File Invoice</label>
                            <div class="col-sm-9">
                                <input type="file" name="file_upload" class="form-control" placeholder = "Masukkan Tempat Invoice Dibuat" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">
                            Tabel Invoice
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
                                    <th>Volume (m<sup>3</sup>)</th>
                                    <th>Diameter</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="id_jenis_kayu[]" class="form-control jenis-kayu">    
                                            <option value="">Masukkan Jenis Kayu</option>
                                            <?php          
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
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <p class="kel-jenis-kayu">-</p>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-addon">Rp.</div>
                                            <input type="number" name="harga[]" class="form-control" placeholder="Masukkan Harga Kayu">
                                            <div class="input-group-addon">.00</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" name="volume[]" class="form-control" placeholder="Masukkan Volume Kayu">
                                            <div class="input-group-addon">m <sup>3</sup></div>
                                        </div>
                                    </td>
                                    <td>
                                        <select   select name="id_diameter[]" class="form-control">    
                                            <option>Pilih Diameter Kayu</option>
                                            <?php
                                                $data_diamter = $this->db->get('m_diameters');
                                                foreach($data_diamter->result() as $row) {
                                                    echo "<option value=".$row->id.">".$row->diameter."</option>";
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                    ?>"+
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
                                    '<div class="input-group-addon">m <sup>3</sup></div>'+
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
        let kabupaten = data_kab.find(p => p.KODE_CDK === kode_kab);

        $('.provinsi').val(provinsi.KETERANGAN);
        $('.kabupaten').val(kabupaten.KETERANGAN);
    })
</script>