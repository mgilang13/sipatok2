<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Data Harga Patokan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NOMOR INVOICE</th>
                        <th>TANGGAL INVOICE</th>
                        <th>NAMA PERUSAHAAN PEMBELI</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no_urut = 1;
                    foreach ($hargapatokan as $hp): ?>
                    <tr>
                        <td width="20">
                            <?php echo $no_urut++; ?>
                        </td>
                        <td width="150">
                            <?php echo $hp->nomor_invoice ?>
                        </td>
                        <td>
                            <?php echo $hp->tgl_invoice ?>
                        </td>
                        <td>
                            <?php echo $hp->NAMA_PERUSAHAAN ?>
                        </td>
                        <td>
                            <center>
                                <?php
                                if(isset($hp->is_verified) == 0){
                                ?>
                                    <small class="label label-info"><i class="fa fa-clock-o"></i> Belum Verifikasi</small>
                                <?php
                                } else if(isset($hp->is_verified) == 1){
                                ?>
                                    <small class="label label-success"><i class="fa fa-check-circle"></i> Terverifikasi</small>
                                <?php
                                } else if(isset($hp->is_verified) == 2) {
                                ?>
                                    <small class="label label-danger"><i class="fa fa-close"></i> Dikembalikan</small>
                                <?php
                                }
                                ?>
                            </center>    
                        </td>
                        <td width="250">
                            <a href="<?php echo site_url('harga_patokan/data/detail/'.$hp->id) ?>"
                                class="btn btn-warning"><i class="fa fa-eye"></i> Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<!-- punya lama -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.0/jquery.dataTables.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.js"></script> -->

<!-- baru tapi cdn -->
<!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"> -->

<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<script>
        $(document).ready(function() {
            var t = $('#mytable').DataTable( {
                "order": [[ 1, 'asc' ]],
            } );
               
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        } );
</script>