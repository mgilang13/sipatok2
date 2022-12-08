<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Data Harga Patokan</h3>
              <a class="btn btn-success" style="float:right;" href="<?php echo site_url('admin_harga_patokan/sk/input'); ?>"><i class="fa fa-edit"></i> Tambah SK</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NOMOR SK</th>
                        <th>KETERANGAN</th>
                        <th>FILE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no_urut = 1;
                    foreach ($peraturan as $sk): ?>
                    <tr>
                        <td width="20">
                            <?php echo $no_urut++; ?>
                        </td>
                        <td width="150">
                            <?php echo $sk->nomor_sk ?>
                        </td>
                        <td>
                            <?php echo $sk->keterangan ?>
                        </td>
                        <td width="250">
                            <a href="<?php echo site_url('harga_patokan/data/detail/'.$sk->id) ?>"
                                class="btn btn-warning"><i class="fa fa-download"></i> Unduh</a>
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