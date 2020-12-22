<section class="seksi-konten">
        <!-- Start Top Cover -->
        <div class="seksi-top">
            <h3>Cek Resi Wilopo Cargo</h3>
            <p>Silahkan masukkan kode resi anda dibawah ini</p>
            <div class="spacer"></div>
            <!-- Start Form Cek Resi -->
            <div id="form-data" class="form-cekresi">
                <input type="hidden" value="<?php echo $_GET['nomor-resi']; ?>" id="nomor-resi" name="nomor-resi">
                <input type="hidden" value="<?php echo $_GET['nomor-resi']; ?>" id="nomor-marking" name="nomor-marking">
                <div class="form-row">
                    <div class="form-grup">
                        <label for="resi">No. Resi</label>
                        <input class="input-form is-invalid" id="resi" value="<?php echo $_GET['nomor-resi']; ?>" name="resi" type="no" placeholder="No. Resi" required>
                        <div class="s-error alert1"></div>
                    </div>
                    <div class="form-grup">
                        <label for="resi">Kode Marking</label>
                        <input class="input-form" id="marking" value="<?php echo $_GET['nomor-marking']; ?>" name="marking" type="no" placeholder="Kode Marking" required>
                        <div class="s-error alert2"></div>
                    </div>
                    <div class="form-grup">
                        <button id="submit" onClick="cekresi()" class="btn-cekresi">Cek Resi</button>
                    </div>
                </div>
            </div>
            <!-- End Form Cek Resi-->
        </div>
        <!-- End Top Cover -->
        <div class="kontainer">
            <div id="hasilresi">
                        <div id="resiNull" class="data-null">
                            <div class="data-null-img">
                                <img src="<?php echo base_url(); ?>assets/resi/gambar/data-null.png" alt="not found">
                            </div>
                            <div class="data-null-text">
                                <p>Silahkan Masukan No Resi dan kode Marking Anda!</p>
                            </div>
                        </div>
            </div>
        </div>
    <!-- Loading Statis -->
     <div class="loading-stat">
        <div class="loading-stat-bodi">
            <div class="animasi-loading">
                <img src="<?php echo base_url(); ?>assets/resi/gambar/logo-loading.png" alt="">
            </div>
            <p class="text-white text-center">Tunggu sebentar, sedang memuat data...</p>
        </div>
    </div>
    <!-- End Loading Statis -->
    </section>
     
    <script>
                           
                            setTimeout(function() {  
                                var nomorresi = '<?php echo $_GET['nomor-resi']; ?>';
                                var nomormarking = '<?php echo $_GET['nomor-marking']; ?>';
                                if (nomorresi !== '') {
                                    var el = $('.loading-stat');
                                    el.addClass('buka');
                                }
                                setTimeout(function() { 
                                    if (nomorresi !== '') {
                                        $('#hasilresi').html('<div id="hasilresi"></div>');
                                        
                                        $.ajax({
                                            url : "<?php echo base_url(); ?>api/cekresi/json", 
                                            type: "POST", 
                                            data: {resi: nomorresi, marking: nomormarking},
                                            async: true,
                                            timeout: 0,
                                            
                                            success : function(output){
                                                var el = $('.loading-stat');
                                                el.removeClass('buka');
                                                $('#hasilresi').html(output);
                                            },
                                        })
                                    } 
                                }, 1500);
                            }, 100);
                           
                            
                       
                    function cekresi(){    
                        var residata = $('#resi').val();
                        var markingdata = $('#marking').val();
                        var valid1 = $('#resi').val().length;
                        var valid2 = $('#marking').val().length;
                        $('.s-error').html('');			
 
                        if (valid1 == 0) {				
                            $('.alert1').html('<span class="s-error">* Masukkan No. Resi</span>').fadeIn(5000);
                            $('.alert2').html('<span class="s-error">&nbsp;</span>');
                            return false;
                        } else if(valid2 == 0) {
                            $('.alert2').html('<span class="s-error">* Masukkan kode marking</span>').fadeIn(5000);
                            $('.alert1').html('<span class="s-error">&nbsp;</span>');
                            return false;
                        }else{
                            $('#hasilresi').html('<div id="hasilresi"></div>');
                            var el = $('.loading-stat');
                            el.addClass('buka');
                            $.ajax({
                                url : "<?php echo base_url(); ?>api/cekresi/json", 
                                type: "POST", 
                                data: {resi: residata, marking: markingdata},
                                async: true,
                                timeout: 0,
                                
                                success : function(output){
                                    var el = $('.loading-stat');
                                    el.removeClass('buka');
                                    $('#hasilresi').html(output);
                                },
                            })
                        }
                      
                    };
    </script>