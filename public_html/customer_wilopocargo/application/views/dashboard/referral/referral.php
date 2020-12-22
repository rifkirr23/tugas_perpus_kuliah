<title>Wilopo Cargo - Referal</title>
<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/Chart.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashboard/css/jquery.dataTables.min.css">
</head>
<section class="main-konten">
    <div class="container-fluid ">
        <!--Start Jumbotron -->
        <div class="jumbotron-default gradient-referal">
            <div class="judul-jumbotron">
                <h3><img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-refer.svg" alt="">Referral Program</h3>
            </div>
        </div>
        <!--End Jumbotron-->
        <!--Start Main Konten-->
        <div class="top-minus">
            <div class="row kolom-row">
                <div class="col-lg-7">
                    <div class="kartu mb-4">
                        <div class="row-kartu min-150">
                            <div class="item">
                                <div class="figur">
                                    <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-24.svg" alt="">
                                </div>
                                <div class="report">
                                    <label class="text-danger" for="">Komisi Pending</label>
                                    <h1>IDR <?php echo number_format($pending->jumlahnya); ?>,-</h1>
                                </div>
                            </div>
                            <div class="item">
                                <div class="figur">
                                    <img src="<?php echo base_url(); ?>assets/dashboard/gambar/icw-transaksi.svg" alt="">
                                </div>
                                <div class="report">
                                    <label class="text-primary" for="">Saldo Aktif</label>
                                    <h1>IDR <?php echo number_format($proccess->jumlahnya);?>,-</h1>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="kartu">
                        <div class="head-kartu">
                            <div class="kiri">
                                <h3><i class="fa fa-chart-line text-primary"></i>Statistik Bulanan</h3>
                            </div>
                            <div class="kanan">
                                <a href="#"><i class="fa fa-sync text-secondary"></i></a>
                            </div>
                        </div>
                        <div class="body-kartu p-0">
                            <canvas id="statistikBulanan" height="135" width="auto"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="jumbotron-menu tab-kartu">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" href="<?php echo base_url(); ?>referral" aria-controls="nav-home" aria-selected="true">Daftar Komisi</a>
                    <a class="nav-item nav-link" href="<?php echo base_url(); ?>referral/referrallist" aria-controls="nav-titip" aria-selected="false">List Referral</a>
                    <a class="nav-item nav-link" href="<?php echo base_url(); ?>referral/resilist" aria-controls="nav-titip" aria-selected="false">List Resi</a>
                </div>
            </nav>

            <div class="row kolom-row">
                <div class="col-12">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-semua" role="tabpanel">

                        <div class="kartu">
                            <div class="head-kartu">
                                <div class="kiri">
                                    <h3><i class="fa fa-money-check"></i> Daftar Komisi</h3>
                                </div>
                                <div class="kanan">
                                    <a href="#" onclick="reFresh()"><i class="fa fa-circle-notch"></i> Refresh</a>
                                </div>
                            </div>
                            <div class="body-kartu">
                                <table id="komisilist" class="stripe hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Kode Komisi</th>
                                            <th>Referal</th>
                                            <th>Customer</th>
                                            <th>Kode Invoice</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="nav-titip" role="tabpanel">
                            <div class="kartu">
                                <div class="head-kartu">
                                    <div class="kiri">
                                        <h3><i class="fa fa-user"></i>Semua Referral</h3>
                                    </div>
                                    <div class="kanan">
                                        <a href="#" class="text-secondary"><i class="fa fa-sync"></i></a>
                                    </div>
                                </div>
                                <div class="body-kartu">
                                    <table id="customerlist" class="stripe hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Kode Marking</th>
                                                <th>Nama</th>
                                                <th>No. Telf</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!--End Main Konten-->
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/dashboard/js/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>assets/dashboard/js/Chart.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dashboard/js/jquery.dataTables.min.js"></script>
<script>
var ctx = document.getElementById('statistikBulanan');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sept', 'Okt', 'Nop', 'Des'],
        datasets: [{
            label: 'Total Referral',
            data: [
                <?php
                    $idcust=$this->session->userdata('id_cust');
                    $tahunskr=date('Y');
                    for ($i= 1; $i <= 12; $i++)
                    {
                        $jumlahnya=$this->db->select('sum(komisi_referal.nilai) as jumlahnya')->from('komisi_referal')
                        ->join('invoice', 'invoice.id_invoice = komisi_referal.id_invoice','left')
                        ->where('komisi_referal.id_cust',$idcust)
                        ->where('komisi_referal.status',2)
                        ->where('year(invoice.tanggal_invoice)',$tahunskr)
                        ->where('month(invoice.tanggal_invoice)',$i)
                        ->group_by('month(invoice.tanggal_invoice)')
                        ->get()->row();
                        echo $jumlahnya->jumlahnya.',';
                    }
                ?>
                ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        layout: {
          borderWidth: 0
        }
    }
});
</script>
<script>
    function reFresh(){
        location.reload();
    }
    $(document).ready(function() {
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

        var table = $("#komisilist").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#komisilist_filter keyup')
                    .off('.DT')
                    .on('keyup.DT', function() {
                        api.search(this.value).draw();
                });
            },
                oLanguage: {
                sProcessing: "loading..."
            },
            "language": {
                    "url" : "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
                },
                //   scrollX: true,
                processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url()?>/referral/get_komisi_referal_json", "type": "POST"},
                  columns: [
                        {"data": "kode_komisi"},
                        {"data": "kode"},
                        {"data": "customer"},
                        {"data": "kode_invoice"},
                        {"data": "nilai",  render: $.fn.dataTable.render.number(',', '.','','Rp. ')},
                        {"data": "keterangan"},
                        {"data": "status" ,
                          render : function(data,type,row){
                            var strStatus = "";
                            if(row.status == 1){
                              strStatus = "Pending";
                            }else if(row.status == 2){
                              strStatus = "Process";
                            }else if(row.status == 3){
                              strStatus = "Complete";
                            }else if(row.status == 4){
                              strStatus = "cancel";
                            }
                            return strStatus ;
                          }
                        },
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
