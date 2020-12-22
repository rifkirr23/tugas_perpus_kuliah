<head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

  <link href="<?php echo base_url().'assets/ignited/css/jquery.datatables.min.css'?>" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/bootstrap.min.css'?>">
</head>

            <?php if($this->session->flashdata('msg')=='success'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>Input buku Success
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

        <?php if($this->session->flashdata('msg')=='updated'){ ?>

       <p><div style="display: none;" class="alert alert-info alert-dismissable"><i class="icon fa fa-check"></i>buku data Updated
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      </div></p>

        <?php } ?>

<div class="row">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><b>Data Buku </b></h3>
      <span class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd"><i class="fa fa-plus"> Buku</i></button>
      </span>
    </div>

    <div class="box-body">
    <div class="box-body table-responsive">

    <table class="table table-bordered table-striped no-margin" id="mytable">
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Kategori</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Penerbit</th>
          <th>Tahun Terbit</th>
          <th>ISBN</th>
          <th>Jumlah Buku</th>
          <th>Lokasi</th>
          <th>Status</th>
          <th>Pilihan</th>
        </tr>
      </thead>
    </table>

  <!-- Modal Add Customer-->
    <form id="add-row-form" action="<?php echo base_url().'admin/buku/save'?>" method="post" enctype="multipart/form-data">
       <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Form Input buku</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                     <label>Judul Buku</label>
                         <input type="text" name="judul_buku" class="form-control" placeholder="Judul Buku" required>
                     </div>
                     <div class="form-group">
                     <label>Kategori</label>
                     <select class="form-control" name="id_kategori">
                       <?php foreach($kategori as $kg){ ?>
                         <option value="<?php echo $kg->id_kategori ?>"><?php echo $kg->nama_kategori ?></option>
                       <?php } ?>
                     </select>
                         <!-- <input type="text" name="gender" class="form-control" placeholder="Gender" required> -->
                     </div>
                     <div class="form-group">
                     <label>Pengarang</label>
                         <input type="text" name="pengarang" class="form-control" placeholder="Pengarang" required>
                     </div>
                     <div class="form-group">
                     <label>Penerbit</label>
                         <input type="text" name="penerbit" class="form-control" placeholder="Penerbit" required>
                     </div>
                     <div class="form-group">
                     <label>Tahun Terbit</label>
                         <input type="text" name="thn_terbit" class="form-control" placeholder="Tahun terbit" required>
                     </div>
                     <div class="form-group">
                     <label>ISBN</label>
                         <input type="text" name="isbn" class="form-control" placeholder="Isbn" required>
                     </div>
                     <div class="form-group">
                     <label>Lokasi</label>
                         <select class="form-control" name="lokasi">
                           <option>Rak 1</option>
                           <option>Rak 2</option>
                           <option>Rak 3</option>
                         </select>
                     </div>
                     <div class="form-group">
                          <label>Gambar</label>
                          <input type="file" name="gambar[]" class="btn btn-primary">
                     </div>
                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Save</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <!-- Modal Update Produk-->
    <form id="add-row-form" action="<?php echo base_url().'admin/buku/update'?>" method="post">
       <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Update buku</h4>
                 </div>
                 <div class="modal-body">

                 <input type="hidden" name="id_buku" class="form-control" required>

                 <div class="form-group">
                 <label>Judul Buku</label>
                     <input type="text" name="judul_buku" class="form-control" placeholder="Judul Buku" required>
                 </div>

                 <div class="form-group">
                 <label>Pengarang</label>
                     <input type="text" name="pengarang" class="form-control" placeholder="Pengarang" required>
                 </div>
                 <div class="form-group">
                 <label>Penerbit</label>
                     <input type="text" name="penerbit" class="form-control" placeholder="Penerbit" required>
                 </div>
                 <div class="form-group">
                 <label>Tahun Terbit</label>
                     <input type="text" name="thn_terbit" class="form-control" placeholder="Tahun terbit" required>
                 </div>
                 <div class="form-group">
                 <label>ISBN</label>
                     <input type="text" name="isbn" class="form-control" placeholder="Isbn" required>
                 </div>
                 <div class="form-group">
                 <label>Lokasi</label>
                     <select class="form-control" name="lokasi">
                       <option>Rak 1</option>
                       <option>Rak 2</option>
                       <option>Rak 3</option>
                     </select>
                 </div>
                 <div class="form-group">
                      <label>Gambar</label>
                      <input type="file" name="gambar[]" class="btn btn-primary">
                 </div>


                 </div>
                 <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="add-row" class="btn btn-primary">Update</button>
                 </div>
              </div>
          </div>
       </div>
   </form>

   <div id="view_image"></div>
   <div id="edit_buku"></div>


<script src="<?php echo base_url().'assets/ignited/js/jquery-2.1.4.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/jquery.datatables.min.js'?>"></script>
<script src="<?php echo base_url().'assets/ignited/js/dataTables.bootstrap.js'?>"></script>
<script src="<?php echo base_url().'assets/jquery/jquery.mask.min.js'?>"?>></script>
<script src="<?php echo base_url() ?>assets/jquery/loadingoverlay.min.js"></script>

<script type="text/javascript">
        $(document).ready(function(){setTimeout(function(){$(".alert").fadeIn('fast');}, 100);});
          //angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
          setTimeout(function(){$(".alert").fadeOut('fast');}, 5000);
</script>

<script>
    $(document).ready(function(){

                // Format mata uang.
                $( '.uang' ).mask('000.000.000.000', {reverse: true});

            })
</script>

<script>
  $(document).ready(function(){
    // Setup datatables
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };

      var table = $("#mytable").dataTable({
          initComplete: function() {
              var api = this.api();
              $('#mytable_filter keyup')
                  .off('.DT')
                  .on('keyup.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
              sProcessing: "loading..."
          },
              scrollX: true,
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url()?>/admin/buku/get_buku_json", "type": "POST"},
                  columns: [

                        {"data": "gambar"},
                        {"data": "nama_kategori"},
                        {"data": "judul_buku"},
                        {"data": "pengarang"},
                        {"data": "penerbit"},
                        {"data": "thn_terbit"},
                        {"data": "isbn"},
                        {"data": "jumlah_buku"},
                        {"data": "lokasi"},
                        {"data": "status_buku" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status_buku == 0){
                              strStatus = "Tersedia";
                            }else if(row.status_buku == 1){
                              strStatus = "Sedang dipinjam";
                            }
                            return strStatus ;
                          }},
                        {"data": "view"}
                  ],
              order: [[1, 'asc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }

      });
      // end setup datatables


  });
</script>

<script type="text/javascript">
  function view_image(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/buku/view_image/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#view_image").html(html).show();
        $('#modvm').modal('show');
      }
    })
  }
</script>

<script type="text/javascript">
  function edit_buku(id)
  {
    console.log(id);
    $.ajax({
      type : "GET",
      url : "<?php echo base_url() ?>admin/buku/edit_buku/"+id,
      cache : false,
      async : false,
      success : function(html){
        $("#edit_buku").html(html).show();
        $('#moded').modal('show');
      }
    })
  }
</script>
