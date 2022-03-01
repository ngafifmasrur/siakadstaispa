@extends('layouts.default')

@section('bodyclass', 'h-100vh d-flex align-items-center bg-light')

@section('main')
    <div class="d-none">
        @yield('content')
    </div>
    <div class="container">
        <div class="row justify-content-center my-3">
            <div class="col-lg-5 col-md-8 col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title"> Berkas terunduh! </h2>
                        <p>Berkas <strong>@yield('filename').xls</strong> berhasil di ekspor</p>
                        <hr>
                        <p class="mb-0">Halaman akan ditutup otomatis setelah <span id="counter">4</span> detik <br> <a href="javascript:window.close()">Tutup sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(function() {
        var counter = 4
        var def = counter * 1000
        setInterval(function() {
            $('#counter').html(counter)
            if(counter <= 0) 
                window.close()
            else
                counter--;
        }, 1000)

        var tableToXls = (function() {
            var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '\x3Chtml xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"> \x3Chead>\x3Cmeta http-equiv="Content-Type" content="text/html; charset=utf-8" />\x3Cxml> \x3Cx:ExcelWorkbook> \x3Cx:ExcelWorksheets> \x3Cx:ExcelWorksheet> Sheet1 \x3Cx:WorksheetOptions> \x3Cx:Panes> \x3C/x:Panes> \x3C/x:WorksheetOptions> \x3C/x:ExcelWorksheet> \x3C/x:ExcelWorksheets> \x3C/x:ExcelWorkbook> \x3C/xml>\x3C/head> \x3Cbody> \x3Ctable border="1">{table}\x3C/table> \x3C/body> \x3C/html>'
            , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
                , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
                return function (table, filename, sheet) {
                    var ctx = { worksheet: sheet || 'Sheet1', table: table}

                    var link = document.createElement("a");
                        link.setAttribute('href', uri + base64(format(template, ctx)));
                        link.setAttribute('download', (filename || 'output') + '.xls');
                        link.click();
            }
        })()

        return tableToXls($($('table')[0]).html(), '@yield('filename')');
    })
</script>
@endpush