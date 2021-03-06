<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : forecasting.php                                                                                       *
 * DESC     : Digunakan untuk melakukan peramalan kebutuhan stok barang                                             *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////    

    var title = 'Forecasting \u00BB Peramalan Kebutuhan Stok Barang';
    var headerTitle = ['No', 'Bulan', 'Penjualan'];
    var headerTitle2 = ['Bulan', 'Penjualan (Y)', 'Ramalan (S)', 'Error', 'Error^2'];
    var monthname = new Array("Undifined", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
    var monthname2 = new Array("Undifined", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    var kode;
    var hal = 0;
    var totalHalaman;
    var limit = 10;

    var data = new Array(limit);
    for (i = 0; i < 100; i++) {
        data[i] = new Array(100);
    }

    var datasend = new Array(100);
    for (i = 0; i < 100; i++) {
        datasend[i] = new Array(100);
    }

    $(document).ready(function() {
        $(document).attr('title', title);
        $('#title').html(title);
        loadHeader(headerTitle);
        loadHeader2(headerTitle2);
        showInputForm();

        $('#metode_single').qtip({
            style: {classes: 'myCustomClass'}, 
            content: '<table><tr><td><img src="asset/images/pola_horizontal.JPG" height="100" width="150" /></td><td>Metode ini juga dikenal sebagai simple exponential smoothing yang digunakan pada peramalan jangka pendek, biasanya hanya satu bulan ke depan.  Makridakis mendefinisikan  single exponential smoothnig  sebagai \'Model ini mengasumsikan data berfluktuasi di sekitar nilai rata-rata yang tetap, tanpa mengikuti pola atau tren\'.</td></tr></table>'
        });
        
        $('#metode_double').qtip({
            style: {classes: 'myCustomClass'}, 
            content: '<table><tr><td><img src="asset/images/pola_tren.JPG" height="100" width="150" /></td><td>Metode ini merupakan model linear yang dikemukakan oleh Brown. Didalam metode <em>Double Exponential Smoothing</em> dilakukan proses smoothing dua kali. Metode double exponential smoothing ini biasanya lebih tepat untuk meramalkan data yang mengalami trend naik</td></tr></table>'
        });
        
        $('#metode_triple').qtip({
            style: {classes: 'myCustomClass'}, 
            content: '<table><tr><td><img src="asset/images/pola_musiman.JPG" height="100" width="150" /></td><td>Metode ini merupakan metode forecast yang dikemukakan oleh Brown, dengan menggunakan persamaan kwadrat. Metode ini lebih cocok kalau dipakai untuk membuat forecast yang berfluktuasi atau mengalami gelombang pasang surut. (Pangestu Subagyo, 1986: 26).</td></tr></table>'
        });
        
        $('#alphaslider').qtip({
            style: {classes: 'myCustomClass'}, 
            content: '<table><tr><td><img src="asset/images/alpha.png" height="100" width="100" /></td><td> Nilai konstanta pemulusan dapat dipilih di antara nilai 0 dan 1 karena berlaku 0 < α < 1. Bagaimanapun juga, untuk penetapan nilai α yang diperkirakan tepat, dapat digunakan panduan berikut:<br/>• Apabila pola historis dari data aktual permintaan sangat bergejolak atau tidak stabil dari waktu ke waktu, dipilih nilai α = 0,9; namun dapat juga dicoba nilai-nilai α lain yang mendekati satu. <br/>• Apabila pola historis dari data aktual permintaan cenderung stabil dari waktu ke waktu, dipilih nilai α = 0,1; namun dapat juga dicoba nilai-nilai α yang lain yang mendekati nol.</td></tr></table>'
        });

        $("#alphaslider").mousemove(function(e) {
            $("#alphaview").html($(this).val());
            $("#alpha").val($(this).val());
        });
    });

    ///////////////////////////////////////////////////////
    // PART A - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART B - MENGAMBIL DATA DARI DATABASE///////////////
    ///////////////////////////////////////////////////////

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
            url: 'client/forecasting/get_data_barang.php',
            data: {myJson: datasend},
            beforeSend: function() {
                $('#loading').show();
            },
            complete: function() {
                $('#loading').hide();
            }
        }).success(function(response) {
            var jumlahData = response.data[0].totalrow;
            if (jumlahData <= 0) {
                $('#isi_tabel').html('');
                $('#pagination').html(fillPagination(1, 1));
            } else {
                for (i = 0; i < jumlahData; i++) {
                    data[i][0] = response.data[i].id_barang;
                    data[i][1] = response.data[i].nama;
                    data[i][2] = response.data[i].bulan;
                    data[i][3] = response.data[i].tahun;
                    data[i][4] = response.data[i].jumlah;

                    //dont change this is for pagination
                    data[i][98] = response.data[i].totalrow;
                    data[i][99] = response.data[i].totaldata;
                }
                totalHalaman = Math.ceil((parseInt(data[0][99]) / limit));

                $('#isi_tabel').html(fillTable(data));
                $('#pagination').html(fillPagination(hal, totalHalaman));
                $('#sendKode').val(kode);
                $('#nama_view').html(data[0][1]);

                $('#grafik').show();
                renderGraph();
            }
        });
    }

    ///////////////////////////////////////////////////////
    // PART B - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART C - PENGATURAN FORM ///////////////////////////
    ///////////////////////////////////////////////////////

    function hiddenField() {
        $('#tdkode').css('display', 'none');
        $('#kodeview').css('display', '');
        $('#tdnama').css('display', 'none');
        $('#namaview').css('display', '');
    }

    function unHiddenField() {
        $('#tdkode').css('display', '');
        $('#kodeview').css('display', 'none');
        $('#tdnama').css('display', '');
        $('#namaview').css('display', 'none');
    }

    function showInputForm() {
        unHiddenField();
        if ($('#forminput').css('display') == 'none') {
            toggleForm('forminput');
        }
        clearForm();
        $('#kode').focus();
        $('#formtype').val('INS');
    }

    function clearForm() {
        $('#id').val('');
        $('#kode').val('');
        $('#kode').css('background-color', '');
        $('#nama').val('');
        $('#nama').css('background-color', '');
        $('#teks_cari').val('');
        $('#teks_cari').css('background-color', '');
        $('#pesankode').html('');
        $('#kode').removeAttr('readonly');
    }

    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
    ///////////////////////////////////////////////////////

    function entryValidate() {
        if ($('#id').val() == '') {
            alertify.error('masukan barang <br /> &nbsp;');
        } else if ($('#alpha').val() == '') {
            alertify.error('masukan nilai (&alpha;) <br /> &nbsp;');
        } else if ($('#alpha').val() >= 1 || $('#alpha').val() <= 0) {
            alertify.error('&alpha; harus berada diantara 1 dan 0 <br /> &nbsp;');
        } else {
            $('#datagrid2').show();
            if ($('#metode_single').is(':checked')) {
                singleES(data);
            } else if ($('#metode_double').is(':checked')) {
                doubleES(data);
            } else if ($('#metode_triple').is(':checked')) {
                tripleES(data);
            }
        }
    }

    ///////////////////////////////////////////////////////
    // PART D - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART E - PENGATURAN TABEL///////////////////////////
    ///////////////////////////////////////////////////////

    function loadHeader(titles) {
        var title = "<tr>";
        for (i = 0; i < titles.length; i++) {
            title += "<th>" + titles[i] + "</th>";
        }
        title += "</tr>";
        $('#judul_tabel').html(title);
    }

    function loadHeader2(titles) {
        var title = "<tr>";
        for (i = 0; i < titles.length; i++) {
            title += "<th>" + titles[i] + "</th>";
        }
        title += "</tr>";
        $('#judul_tabel2').html(title);
    }

    function fillTable(data) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data[0][98]; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center" width="25">' + i + '</td>';
            reValueTable += '<td align="center">' + monthname[data[j][2]] + ' ' + data[j][3] + '</td>';
            reValueTable += '<td align="center">' + data[j][4] + '</td>';
            reValueTable += '</tr>';
            i++;
        }

        return reValueTable
    }

    function pagingCLick(hal) {
        sendReq(hal, kode);
    }

    function resetTable() {
        sendReq(1, '1111');
        clearForm();
        $('#forminput').hide();
    }

    function fillTable2(data) {
        var reValueTable = '';
        var i = 1;
        var Se = 0;
        var Se2 = 0;
        var rSe = 0;
        var rSe2 = 0;

        for (j = 0; j < data.length; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center" width="100">' + monthname[data[j][5]] + ' - ' + data[j][6] + '</td>';
            reValueTable += '<td align="center">' + data[j][1] + '</td>';
            reValueTable += '<td align="center">' + (data[j][2]).toFixed(2) + '</td>';
            if (j > 0) {
                reValueTable += '<td align="center">' + (data[j][3]).toFixed(2) + '</td>';
                reValueTable += '<td align="center">' + (data[j][4]).toFixed(2) + '</td>';
            } else {
                reValueTable += '<td align="center">-</td>';
                reValueTable += '<td align="center">-</td>';
            }
            reValueTable += '</tr>';
            i++;

            Se += data[j][3];
            Se2 += data[j][4];
        }

        rSe = (Se / (data.length - 1));
        rSe2 = (Se2 / (data.length - 1));

        reValueTable += '<tr>';
        reValueTable += '<td colspan="3" align="right"><strong>Total</strong></td>';
        reValueTable += '<td align="center">' + Se.toFixed(2) + '</td>';
        reValueTable += '<td align="center">' + Se2.toFixed(2) + '</td>';
        reValueTable += '</tr>';

        reValueTable += '<tr>';
        reValueTable += '<td colspan="3" align="right"><strong>Rata - rata</strong></td>';
        reValueTable += '<td align="center">' + rSe.toFixed(2) + '</td>';
        reValueTable += '<td align="center">' + rSe2.toFixed(2) + '</td>';
        reValueTable += '</tr>';

        reValueTable += '<tr>';
        reValueTable += '<td colspan="5"><strong>Ramalan Periode Berikutnya = </strong><span id="rumus"></span></td>';
        reValueTable += '</tr>';

        return reValueTable
    }

    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    /////////////////////////////////////////////////////// 

    function changealphaview() {
        $('#alphaview').html($('#alpha').val());
    }

    function showListBarang() {
        winRef = openWindow('index.php?page=992aadacd760fa01e53fc9f4ca3610d8');
    }

    function getDataBarang(id, kode, nama, harga) {
        $('#id').val(id);
        $('#barangview').html(nama);
        sendReq(1, '1111');
        $('#datagrid2').hide();
    }

    function renderGraph() {
        $('#chartdiv').html('');
        var sineRenderer = function() {
            var datas = [[]];
            for (var i = 0; i < data[0][99]; i++) {
                var str = data[i][3];
                var res = str.substring(2, 4);
                datas[0].push([monthname[data[i][2]] + '-' + res, parseInt(data[i][4])]);
            }
            return datas;
        };

        var plot1 = $.jqplot('chartdiv', [], {
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

    function singleES() {
        var alpha = parseFloat($('#alpha').val());
        var jumlahData = data[0][99];
        var Y = new Array(jumlahData + 1); //data
        var S = new Array(jumlahData + 1); //peramalan
        var Se = new Array(jumlahData + 1);

        var datas = new Array(jumlahData);
        for (i = 0; i < jumlahData; i++) {
            datas[i] = new Array(5);
        }

        for (i = 0; i < jumlahData; i++) {
            Y[i + 1] = data[i][4];
            datas[i][1] = Y[i + 1];
            datas[i][5] = data[i][2];
            datas[i][6] = data[i][3];
        }

        S[0] = data[0][4];
        Y[0] = 0;

        for (i = 0; i < jumlahData; i++) {
            S[i + 1] = (alpha * Y[i + 1]) + ((1 - alpha) * S[i]);
            datas[i][2] = S[i + 1];
        }

        Se[0] = 0;
        Se[1] = 0;
        datas[0][3] = Se[1];
        datas[0][4] = (Se[1] * Se[1]);

        for (i = 0; i < jumlahData; i++) {
            Se[i + 2] = S[i + 1] - Y[i + 2];
            if (i < jumlahData - 1) {
                datas[i + 1][3] = Se[i + 2];
                datas[i + 1][4] = (Se[i + 2] * Se[i + 2]);
            }
        }

        $('#isi_tabel2').html(fillTable2(datas));
        $('#rumus').html(S[jumlahData].toFixed(2) + ' &asymp; ' + Math.round(S[jumlahData]));
    }

    function doubleES() {
        var alpha = parseFloat($('#alpha').val());
        var jumlahData = data[0][99];
        var Y = new Array(jumlahData + 1); //data
        var S = new Array(jumlahData + 1); //pemulusan
        var S2 = new Array(jumlahData + 1); //pemulusan kedua
        var Se = new Array(jumlahData + 1);

        var datas = new Array(jumlahData);
        for (i = 0; i < jumlahData; i++) {
            datas[i] = new Array(5);
        }

        for (i = 0; i < jumlahData; i++) {
            Y[i + 1] = data[i][4];
            datas[i][1] = Y[i + 1];
            datas[i][5] = data[i][2];
            datas[i][6] = data[i][3];
        }

        S[0] = data[0][4];
        Y[0] = 0;

        for (i = 0; i < jumlahData; i++) {
            S[i + 1] = (alpha * Y[i + 1]) + ((1 - alpha) * S[i]);
        }

        S2[0] = data[0][4];
        S2[1] = data[0][4];

        for (i = 0; i < jumlahData; i++) {
            S2[i + 1] = (alpha * S[i + 1]) + ((1 - alpha) * S2[i]);
            //alert('S2[' + (i + 1) + '] = (' + alpha + ' * ' + S[i + 1] + ') + (' + (1 - alpha) + ' * ' + S2[i] + ') = ' + S2[i + 1]);
            datas[i][2] = S2[i + 1];
        }

        Se[0] = 0;
        Se[1] = 0;
        datas[0][3] = Se[1];
        datas[0][4] = (Se[1] * Se[1]);

        for (i = 0; i < jumlahData; i++) {
            Se[i + 2] = S2[i + 1] - Y[i + 2];
            if (i < jumlahData - 1) {
                datas[i + 1][3] = Se[i + 2];
                datas[i + 1][4] = (Se[i + 2] * Se[i + 2]);
            }
        }

        var at = (2 * S[jumlahData]) - S2[jumlahData];
        var bt = (alpha / (1 - alpha)) * (S[jumlahData] - S2[jumlahData]);
        var St = at + bt;

        $('#isi_tabel2').html(fillTable2(datas));
//        $('#rumus').html(
//                        '<br />at = (2 x S\'t) - S"t<br />at = (2 x ' + S[jumlahData] + ') - ' + (S2[jumlahData] >= 0 ? S2[jumlahData] : '(' + S2[jumlahData] + ')') + ' = ' + at + '<br />bt = (&alpha; / (1 - &alpha;)) x (S\'t - S"t)<br />' + 'bt = (' + alpha + ' / (1 - ' + alpha + ')) x (' + S[jumlahData] + ' - ' + (S2[jumlahData] >= 0 ? S2[jumlahData] : '(' + S2[jumlahData] + ')') + ') = ' + bt + '<br />St = at + bt<br/>'
//                    );

        $('#rumus').html(St.toFixed(2) + ' &asymp; ' + Math.round(St));
    }

    function tripleES() {
        var alpha = parseFloat($('#alpha').val());
        var jumlahData = data[0][99];
        var Y = new Array(jumlahData + 1); //data
        var S = new Array(jumlahData + 1); //pemulusan
        var S2 = new Array(jumlahData + 1); //pemulusan kedua
        var S3 = new Array(jumlahData + 1); //pemulusan ketiga
        var Se = new Array(jumlahData + 1);

        var datas = new Array(jumlahData);
        for (i = 0; i < jumlahData; i++) {
            datas[i] = new Array(5);
            datas[i][5] = data[i][2];
            datas[i][6] = data[i][3];
        }

        for (i = 0; i < jumlahData; i++) {
            Y[i + 1] = data[i][4];
            datas[i][1] = Y[i + 1];
        }

        S[0] = data[0][4];
        Y[0] = 0;

        for (i = 0; i < jumlahData; i++) {
            S[i + 1] = (alpha * Y[i + 1]) + ((1 - alpha) * S[i]);
        }

        S2[0] = data[0][4];

        for (i = 0; i < jumlahData; i++) {
            S2[i + 1] = (alpha * S[i + 1]) + ((1 - alpha) * S2[i]);
        }

        S3[0] = data[0][4];

        for (i = 0; i < jumlahData; i++) {
            S3[i + 1] = (alpha * S2[i + 1]) + ((1 - alpha) * S3[i]);
            datas[i][2] = S3[i + 1];
        }

        Se[0] = 0;
        Se[1] = 0;
        datas[0][3] = Se[1];
        datas[0][4] = (Se[1] * Se[1]);

        for (i = 0; i < jumlahData; i++) {
            Se[i + 2] = S3[i + 1] - Y[i + 2];
            if (i < jumlahData - 1) {
                datas[i + 1][3] = Se[i + 2];
                datas[i + 1][4] = (Se[i + 2] * Se[i + 2]);
            }
        }

        var at = (3 * S[jumlahData]) - (3 * S2[jumlahData]) + S3[jumlahData];
        var bt = (alpha / (2 * Math.pow((1 - alpha), 2))) * (((6 - (5 * alpha)) * S[jumlahData]) - ((10 - (8 * alpha)) * S2[jumlahData]) + ((4 - (3 * alpha)) * S3[jumlahData]));
        var ct = ((Math.pow(alpha, 2)) / Math.pow((1 - alpha), 2)) * (S[jumlahData] - (2 * S2[jumlahData]) + S3[jumlahData]);
        var St = at + bt + (ct / 2);

        $('#isi_tabel2').html(fillTable2(datas));
        $('#rumus').html(St.toFixed(2) + ' &asymp; ' + Math.round(St));
    }
    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

</script>

<style type="text/css">
    .myCustomClass{
        width: 600px;
        background-color: white;
        border: 1px solid black;
    }

</style>

<span style="display:none">
    <tr>
        <td>
            <input type="text" id="formtype" value="INS"  />
            <input type="text" id="id" value="1" />
            <input type="text" id="sendKode" />
        </td>
    </tr>
</span>  

<h1 id="title"></h1>

<div id="forminput" style="display: none;">
    <table id="content_form" style="width: 100%;" border="0">        

        <tr>
            <td width="200px">Barang</td>
            <td width="200px">
                <span id="barangview"></span>&nbsp;<a href="#" class="detail" onclick="showListBarang();"></a>
            </td>
            <td></td>
        </tr> 

        <tr>
            <td>Nilai Alpha (&alpha;)</td>
            <td width="250px" id="tdalpha">
                <input id="alpha" type="hidden" size="3" class="text" value="0.1" readonly="readonly"/> 
                <input id="alphaslider" type="range" min="0.01" max="0.99" step="0.01" value="0.01"/> 
                <span id="alphaview">0,1</span>
            </td>
            <td></td>
        </tr> 

        <tr>
            <td>Metode Exponential Smoothing</td>
            <td id="tdmetode">
                <input id="metode_single" type="radio" name="rbmetode" checked="true"/> Single 
                <input id="metode_double" type="radio" name="rbmetode" /> Double
                <input id="metode_triple" type="radio" name="rbmetode" /> Triple
            </td>
            <td id="metodeview"></td>
        </tr> 

        <tr>
            <td colspan="3" align="center" style="padding:15px;">
                <span class='tombol' id="bsimpan" onclick="entryValidate();">TAMPILKAN PERAMALAN</span>  
            </td>
        </tr>
    </table>

</div>

<br />

<div id="datagrid2">
    <table style="width: 100%;" id='content_table'>
        <thead id="judul_tabel2"></thead>
        <tbody id="isi_tabel2"></tbody>
    </table>    
    <br />
</div>

<div id="grafik" style="display: none">
    <table id="content_form" style="width: 100%" border="0">        

        <tr id="trbarang" >
            <td style="width: 100px;">Nama Barang</td>
            <td id="nama_view"></td>
        </tr> 

        <tr id="trgrafik" >
            <td colspan="2"> 
                <div id="chartdiv" style="height:350px;width:100%;"></div>
            </td>
        </tr> 

    </table>
</div>

<br />

<div id="datagrid">
    <table style="width: 100%;" id='content_table'>
        <thead id="judul_tabel"></thead>
        <tbody id="isi_tabel"></tbody>
    </table>        

    <br />

<!--    <p style="text-align: right;" id="pagination"></p>-->
</div>