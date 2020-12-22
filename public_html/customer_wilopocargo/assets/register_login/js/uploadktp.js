 // Drag foto
 $('input[type="file"]').ezdz();
 var defaults = {
     className:     '',
     text:          'Upload File',
     previewImage:  true,
     value:         null,
     classes: {
     main:      'ezdz-dropzone',
     enter:     'ezdz-enter',
     reject:    'ezdz-reject',
     accept:    'ezdz-accept',
     focus:     'ezdz-focus'
     },
     validators: {
     maxSize:   3,
     width:     null,
     maxWidth:  null,
     minWidth:  null,
     height:    null,
     maxHeight: null,
     minHeight: null
     },
     init:   function() {},
     enter:  function() {},
     leave:  function() {},
     reject: function() {},
     accept: function() {},
     format: function(filename) {
     return filename;
     }
};
