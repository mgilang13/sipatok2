<section class="content">
    <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <div class="box-header  with-border">
              <h3 class="box-title">Daftar Harga Patokan</h3>
            </div>

            
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="mytable" class="table table-striped table-bordered table-hover table-full-width dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>WILAYAH</th>
                        <th>JENIS KAYU</th>
                        <th>SORTIMEN</th>
                        <th>HARGA PATOKAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no_urut = 1;
                    foreach ($kalkulasi_data as $kd): 
                    ?>
                    <tr>
                        <td width="20">
                            <?php echo $no_urut++; ?>
                        </td>
                        <td width="150">
                            <?php echo $kd->wilayah ?>
                        </td>
                        <td>
                          <?php echo $kd->jenis_kayu ?>
                        </td>
                        <td width="150">
                          <?php echo $kd->sortimen ?>
                        </td>
                        <td width="150" align="right">
                          <?php echo str_replace(",",".",number_format($kd->harga_patokan)) ?>
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
        
        $(document).ready(function() {
            var t = $('#mytable').DataTable( {
                "order": [[ 0, 'asc' ]],
            } );
        } );
</script>