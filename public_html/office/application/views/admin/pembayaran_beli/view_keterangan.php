<div class="modal fade" id="modview_keterangan">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">

        <h4>Keterangan Pembayaran <?php echo $gk1['kode_pembel'] ?></h4>
        </div>

        <div class="modal-body">

        <div class="box-body table-responsive">

    <table class="table table-bordered table-striped " id="mytable">
      <thead>
        <tr>
          <th>No.</th>
          <th>Keterangan</th>


        </tr>
      </thead>
      <tbody>
               <?php $no=1; foreach($gk as $r){ ?>
              <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $r->keterangan_pembayaran ?></td>

              </tr>
              <?php $no++; } ?>
      </tbody>
    </table>
   </div>




          <p><br/></p>
        <div class="modal-footer">

          <a href="#" class="btn btn-default" data-dismiss="modal">Tutup</a>
        </div>

      </div>
   </div>
</div>
