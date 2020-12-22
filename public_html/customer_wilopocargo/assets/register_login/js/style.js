$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });

  // Password Meter //
  jQuery(document).ready(function () {
    "use strict";
    var options = {};
    options.ui = {
        container: "#password-container",
        viewports: {
            progress: ".progress-password"
        },
        
        showPopover: true,
        showErrors: true,
        progressBarExtraCssClasses: "progress-bar-striped progress-bar-animated"
    };
    options.common = {
        debug: true,
        onLoad: function () {
            $('#pesan').text('Masukkan password anda');
        }
    };
    $('#idPassword').pwstrength(options);
});

// Kecocokan Password //
function cekUlangiPassword() {
    var password = $("#idPassword").val();
    var confirmPassword = $("#konfirmasiPassword").val();

    if (password != confirmPassword)
        $("#kecocokanPassword").html('<span class="text-danger">Password tidak cocok.</span>');
    else
        $("#kecocokanPassword").html('<span class="text-success"><i class="fa fa-check"></i> Password cocok.</span>');
}

$(document).ready(function () {
   $("#idPassword, #konfirmasiPassword").keyup(cekUlangiPassword);
});

// Select2js //
$('#idProvinsi').select2({
    ajax: {
      url: 'https://api.github.com/search/repositories',
      processResults: function (data) {
        // Transforms the top-level key of the response object from 'items' to 'results'
        return {
          results: data.items
        };
      }
    }
  });

//   // KTP 
//   $('input[name="idKTP"]').ezdz();
//   var defaults = {
//     className:     '',
//     text:          'Upload Foto KTP',
//     previewImage:  true,
//     value:         null,
//     classes: {
//       main:      'ezdz-dropzone',
//       enter:     'ezdz-enter',
//       reject:    'ezdz-reject',
//       accept:    'ezdz-accept',
//       focus:     'ezdz-focus'
//     },
//     validators: {
//       maxSize:   3,
//       width:     null,
//       maxWidth:  null,
//       minWidth:  null,
//       height:    null,
//       maxHeight: null,
//       minHeight: null
//     },
//     init:   function() {},
//     enter:  function() {},
//     leave:  function() {},
//     reject: function() {},
//     accept: function() {},
//     format: function(filename) {
//       return filename;
//     }
// };

// Open close tombol Whatsapp
$(".call-wa").click(function(){
      $(this).toggleClass("aktif");
  });
// end Open Close tombol Whatsapp