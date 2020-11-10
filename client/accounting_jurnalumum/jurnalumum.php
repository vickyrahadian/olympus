<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : jurnalumum.php                                                                                        *
 * DESC     : Digunakan untuk melihat jurnal umum pada aplikasi                                                     *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////    

    var title = 'Accounting \u00BB Jurnal Umum';
    var headerTitle = ['No', 'Tanggal', 'Kode Akun', 'Nama Akun', 'Debit', 'Kredit'];

    var kode;
    var hal = 0;
    var totalHalaman;
    var limit = 20;

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

        $('#tanggal_mulai').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        $('#tanggal_akhir').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        $('#tanggal_mulai').val(getTodayDate());
        $('#tanggal_akhir').val(getTodayDate());

        loadHeader(headerTitle);
        sendReq(1, '1111');
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
        datasend[0][3] = convertDateToDatabse($('#tanggal_mulai').val());
        datasend[0][4] = convertDateToDatabse($('#tanggal_akhir').val());
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/accounting_jurnalumum/get_data_jurnalumum.php',
            data: {myJson: datasend},
            beforeSend: function() {
                $('#loadpage').show();
            },
            complete: function() {
                $('#loadpage').hide();
            }
        }).success(function(response) {
            var jumlahData = response.data[0].totalrow;
            if (jumlahData <= 0) {
                $('#isi_tabel').html('');
                $('#pagination').html(fillPagination(1, 1));
            } else {
                for (i = 0; i < jumlahData; i++) {
                    data[i][0] = response.data[i].id_jurnalumum;
                    data[i][1] = response.data[i].id_periode;
                    data[i][2] = response.data[i].id_daftarakun;
                    data[i][3] = response.data[i].tanggal;
                    data[i][4] = response.data[i].debit;
                    data[i][5] = response.data[i].kredit;
                    data[i][6] = response.data[i].kode_akun;
                    data[i][7] = response.data[i].nama_akun; 

                    //dont change this is for pagination
                    data[i][98] = response.data[i].totalrow;
                    data[i][99] = response.data[i].totaldata;
                }
                totalHalaman = Math.ceil((parseInt(data[0][99]) / limit));
                $('#isi_tabel').html(fillTable(data));
                $('#pagination').html(fillPagination(hal, totalHalaman));
                $('#sendKode').val(kode);
            }
        });
    }

    ///////////////////////////////////////////////////////
    // PART B - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART C - PENGATURAN FORM ///////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
    ///////////////////////////////////////////////////////

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

    function fillTable(data) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data[0][98]; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center" width="25">' + i + '</td>';
            
            if (j > 0) {
                reValueTable += '<td align="center">' + (data[j][3] == data[j - 1][3] ? '' : dateToString(data[j][3])) + '</td>';
            } else {
                reValueTable += '<td align="center" width="90">' + dateToString(data[j][3]) + '</td>';
            } 

            
            if (data[j][5] > 0) {
                reValueTable += '<td align="center" width="90">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data[j][6] + '</td>';
                reValueTable += '<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + data[j][7] + '</td>';
            } else {
                reValueTable += '<td align="center" width="90">' + data[j][6] + '</td>';
                reValueTable += '<td align="left">' + data[j][7] + '</td>';
            }
            reValueTable += '<td align="right" width="130">' + (data[j][4] == 0 ? '' : toRp(data[j][4])) + '</td>';
            reValueTable += '<td align="right" width="130">' + (data[j][5] == 0 ? '' : toRp(data[j][5])) + '</td>';
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

    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    ///////////////////////////////////////////////////////

    function showPerDate() {
        $('#perdate').show();
    }

    function showAll() {
        $('#perdate').hide();
        sendReq(1, '1111');
    }

    function searchSimple() {
        if (!checkDate($('#tanggal_akhir').val(), $('#tanggal_mulai').val())) {
            alertify.error('Tanggal akhir tidak boleh kurang dari tanggal mulai! <br /> &nbsp;');
        } else {
            sendReq(1, '5555');
        }
    }
    
    function cetakNota() {
        var type = 1;
        var startdate = convertDateToDatabse($('#tanggal_mulai').val());
        var enddate = convertDateToDatabse($('#tanggal_akhir').val());

        if ($('#showall').is(':checked')) {
            type = 1;
        } else {
            type = 2;
        }

        printLaporan('index.php?cetak=aa58fe302cd47e9db1154285af8cb8d2', type, startdate, enddate, 0, 0, 0, 0, 0, 0, 0);
    }
    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

</script>

<div id="loadpage"> 
    <p align="center" style="font-size: large;">
        <img src="asset/images/spin.gif" />
        <br /><b>Loading ... Please wait!</b>
    </p>
</div>

<h1 id="title"></h1>

<div id="top_command">
    <div id="cari">
        <input type="radio" name="rb_filter" id="showall" checked="checked" onclick="showAll()"/>Semua 
        <input type="radio" name="rb_filter" id="showperdate" onclick="showPerDate()" />Per Tanggal &nbsp;
        <span id="perdate" style="display:none">
            <input type="text" id="tanggal_mulai" readonly="readonly" class="text"/> s/d
            <input type="text" id="tanggal_akhir" readonly="readonly" class="text"/>
            <span class='tombol' id="bcetak" onclick="searchSimple();">CARI</span>
        </span>
    </div>
</div>

<div id="datagrid">
    <table style="width: 100%;" id='content_table'>
        <thead id="judul_tabel"></thead>
        <tbody id="isi_tabel"></tbody>
    </table>        

    <br />

    <p style="text-align: right;" id="pagination"></p>

</div>

<div style="text-align: center;"> 
    <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 
</div>
