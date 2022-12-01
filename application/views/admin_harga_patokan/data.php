<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Data Harga Patokan</h3>
            </div>

            
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-lg-6">
                    <h6>Filter Tanggal : </h6>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <input type="text" class="form-control" id="min" name="min" placeholder="Masukkan Tanggal Awal">
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" class="form-control" id="max" name="max" placeholder="Masukkan Tanggal Akhir">
                        </div>
                    </div>
                </div>
              <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NO. INVOICE</th>
                        <th>TGL. INVOICE</th>
                        <th>PIHAK PENJUAL</th>
                        <th>PIHAK PEMBELI</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no_urut = 1;
                    
                    
                    foreach ($hargapatokan as $hp): 
                    ?>
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
                            <?php echo $hp->id_pbph_penjual ?>
                        </td>
                        <td>
                            <?php echo $hp->id_pbph_pembeli ?>
                        </td>
                        <td>
                            <?php
                                if($hp->is_verified == '0') {
                                    echo '<small class="label label-info"><i class="fa fa-clock-o"></i> Belum diverifikasi</small>';
                                } else if ($hp->is_verified == '1') {
                                    echo '<small class="label label-success"><i class="fa fa-check-circle"></i>Terverifikasi</small>';
                                } else if ($hp->is_verified == '2') {
                                    echo '<small class="label label-danger"><i class="fa fa-close"></i> Dikembalikan</small>';
                                }
                            ?>
                        </td>
                        <td width="250">
                            <a href="<?php echo site_url('admin_harga_patokan/data/detail/'.$hp->id) ?>"
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.min.css">

  <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script> 
  <script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>


<script>
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date( data[2] );
        
                if (
                    ( min === null && max === null ) ||
                    ( min === null && date <= max ) ||
                    ( min <= date   && max === null ) ||
                    ( min <= date   && date <= max )
                ) {
                    return true;
                }
                return false;
            }
        );
        
        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });

            var t = $('#mytable').DataTable( {
                "order": [[ 1, 'asc' ]],
            } );
               
            // t.on( 'order.dt search.dt', function () {
            //     t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            
            // } ).draw();
 
            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').on('change', function () {
                t.draw();
            });
        } );
</script>