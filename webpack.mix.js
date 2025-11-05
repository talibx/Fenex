const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/datatables.net-zf/css/dataTables.foundation.min.css', 'public/css')
    .copy('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js');
    
// Copy DataTables files from node_modules to public folder
mix.copy('node_modules/datatables.net-zf/css/dataTables.foundation.min.css', 'public/css/dataTables.foundation.min.css')
   .copy('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js/jquery.dataTables.min.js')
   .copy('node_modules/datatables.net-zf/js/dataTables.foundation.min.js', 'public/js/dataTables.foundation.min.js')
   .copy('node_modules/datatables.net-buttons/js/dataTables.buttons.min.js', 'public/js/dataTables.buttons.min.js')
   .copy('node_modules/jszip/dist/jszip.min.js', 'public/js/jszip.min.js')
   .copy('node_modules/pdfmake/build/pdfmake.min.js', 'public/js/pdfmake.min.js')
   .copy('node_modules/datatables.net-buttons/js/buttons.html5.min.js', 'public/js/buttons.html5.min.js')
   .copy('node_modules/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js', 'public/js/dataTables.fixedHeader.min.js')
   .copy('node_modules/datatables.net-responsive/js/dataTables.responsive.min.js', 'public/js/dataTables.responsive.min.js');
