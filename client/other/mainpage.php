<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : mainpage.php                                                                                          *
 * DESC     : Halaman utama pada sistem informasi                                                                   *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<style type="text/css">
    
    #TOP{
        margin: 10px 0px;
        padding: 10px 0px;
    }  
    
    #MID{ 
        margin: 10px 0px;
        padding: 10px 0px;
    }  
    
    #BOT{ 
        margin: 10px 0px;
        padding: 10px 0px;
    }  
    
</style>

<script type="text/javascript">
    var title = 'Sistem Informasi Pembelian dan Penjualan';
    var monthname = new Array("Undifined", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    var headerTitle = ['No', 'Nama Barang', 'Kode Barang', 'Total Penjualan'];
    var headerTitle2 = ['No', 'Nama Barang', 'Kode Barang', 'Stok'];
    
    var kode;
    var hal = 0;
    var totalHalaman;
    var limit = 10;

    var data = new Array(limit);
    for (i = 0; i < 100; i++) {
        data[i] = new Array(100);
    }
    
    var data2 = new Array(limit);
    for (i = 0; i < 100; i++) {
        data2[i] = new Array(100);
    }

    var data3 = new Array(limit);
    for (i = 0; i < 100; i++) {
        data3[i] = new Array(100);
    }

    var datasend = new Array(100);
    for (i = 0; i < 100; i++) {
        datasend[i] = new Array(100);
    }

    $(document).ready(function() {
        $(document).attr('title', title);
        loadHeader(headerTitle); 
        loadHeader2(headerTitle2); 
        sendReq(1, '1111');
        sendReq2(1, '1111');
        sendReq3(1, '1111');
    });
    
    function sendReq(inhal, inkode) {
        //DONT CHANGE THIS 6 LINES
        hal = inhal;
        kode = inkode;
        datasend[0][1] = USERID;
        datasend[0][2] = $('#id').val();
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/other/get_data_penjualan.php',
            data: {myJson: datasend} 
        }).success(function(response) {
            var jumlahData = response.data[0].totalrow;
            if (jumlahData <= 0) {
                $('#isi_tabel').html('');
                $('#pagination').html(fillPagination(1, 1));
            } else {
                for (i = 0; i < jumlahData; i++) {
                    data[i][0] = response.data[i].month;
                    data[i][1] = response.data[i].year;
                    data[i][2] = response.data[i].total; 
                    
                    data[i][99] = response.data[i].totalrow; 
                }  
                renderGraph();
            }
        });
    }
    
    function renderGraph() {
        $('#TOPCONTENT').html('');
        var sineRenderer = function() {
            var datas = [[]];
            for (var i = 0; i < data[0][99]; i++) {
                datas[0].push([monthname[data[i][0]] + ' ' + data[i][1], parseInt(data[i][2])]);
            }
            return datas;
        };

        var plot1 = $.jqplot('TOPCONTENT', [], {
            title: 'Grafik Penjualan',
            dataRenderer: sineRenderer,
            axesDefaults: {
                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                tickOptions: {
                    fontSize: '10pt'
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer
                }
            }
        });
    }

    function sendReq2(inhal, inkode) {
        //DONT CHANGE THIS 6 LINES
        hal = inhal;
        kode = inkode;
        datasend[0][1] = USERID;
        datasend[0][2] = $('#id').val();
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/other/get_data_barang_terlaris.php',
            data: {myJson: datasend} 
        }).success(function(response) {
            var jumlahData = response.data[0].totalrow;
            if (jumlahData <= 0) {
                $('#isi_tabel').html('');
                $('#pagination').html(fillPagination(1, 1));
            } else {
                for (i = 0; i < jumlahData; i++) {
                    data2[i][0] = response.data[i].nama;
                    data2[i][1] = response.data[i].kode;
                    data2[i][2] = response.data[i].jumlah; 
                    
                    data2[i][99] = response.data[i].totalrow; 
                }
            }
            $('#isi_tabel').html(fillTable(data2));
        });
    }
    
    function loadHeader(titles) {
        var title = "<tr>";
        for (i = 0; i < titles.length; i++) {
            title += "<th>" + titles[i] + "</th>";
        }
        title += "</tr>";
        $('#judul_tabel').html(title);
    }
    
    function fillTable(data) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data2[0][99]; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center" width="25">' + i + '</td>';
            reValueTable += '<td align="left">' + data[j][0] + '</td>';
            reValueTable += '<td align="center">' + data[j][1] + '</td>';
            reValueTable += '<td align="center">' + data[j][2] + '</td>';
            reValueTable += '</tr>';
            i++;
        }

        return reValueTable
    }
    
    function sendReq3(inhal, inkode) {
        //DONT CHANGE THIS 6 LINES
        hal = inhal;
        kode = inkode;
        datasend[0][1] = USERID;
        datasend[0][2] = $('#id').val();
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/other/get_data_barang_habis.php',
            data: {myJson: datasend} 
        }).success(function(response) {
            var jumlahData = response.data[0].totalrow;
            if (jumlahData <= 0) {
                $('#isi_tabel').html('');
                $('#pagination').html(fillPagination(1, 1));
            } else {
                for (i = 0; i < jumlahData; i++) {
                    data3[i][0] = response.data[i].nama;
                    data3[i][1] = response.data[i].kode;
                    data3[i][2] = response.data[i].jumlah; 
                    
                    data3[i][99] = response.data[i].totalrow; 
                }
            }
            $('#isi_tabel2').html(fillTable2(data3));
        });
    }
    
    function loadHeader2(titles) {
        var title = "<tr>";
        for (i = 0; i < titles.length; i++) {
            title += "<th>" + titles[i] + "</th>";
        }
        title += "</tr>";
        $('#judul_tabel2').html(title);
    }
    
    function fillTable2(data) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data3[0][99]; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center" width="25">' + i + '</td>';
            reValueTable += '<td align="left">' + data[j][0] + '</td>';
            reValueTable += '<td align="center">' + data[j][1] + '</td>';
            reValueTable += '<td align="center">' + data[j][2] + '</td>';
            reValueTable += '</tr>';
            i++;
        }

        return reValueTable
    }
</script>

<div id="datagrid">
    <div id="TOP">
        <h1>Grafik Penjualan</h1>
        <div id="TOPCONTENT"></div>
    </div>
    <div id="BOT">
        <h1>Barang Terlaris</h1>
        <div id="datagrid">
            <table style="width: 100%;" id='content_table'>
                <thead id="judul_tabel"></thead>
                <tbody id="isi_tabel"></tbody>
            </table>
        </div>        
    </div>
    <div id="MID">
        <h1>Barang Stok Kosong</h1>
        <div id="datagrid">
            <table style="width: 100%;" id='content_table'>
                <thead id="judul_tabel2"></thead>
                <tbody id="isi_tabel2"></tbody>
            </table>
        </div>  
    </div>
</div>