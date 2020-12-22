<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<center>
<div class="jumbotron text-xs-center">
  <?php if($this->session->flashdata('msg')=='okhargalama'){ ?>
    <h1 class="display-3">Terima Kasih!</h1>
    <p class="lead"><strong>Success Pilih Jalur</strong></p>

  <?php }if($this->session->flashdata('msg')=='nohargalama'){ ?>
    <h1 class="display-3">Wilopo Cargo</h1>
    <p class="lead"><strong>Anda Tidak Bisa Memilih Jalur </strong></p>
  <?php } ?>
  <hr>
  <p>
    Having trouble? <a href="https://wilopocargo.com/index.php?contact">Contact us</a>
  </p>

</div>
</center>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
