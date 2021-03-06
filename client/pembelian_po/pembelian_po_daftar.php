<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : pembelian_PO_daftar.php                                                                               *
 * DESC     : Digunakan untuk melihat daftar purchase order                                                         *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Transaksi \u00BB Daftar Purchase Order';
    var headerTitle = ['No', 'No PO', 'Tanggal Order', 'Pemasok', 'Total', 'Status'];
    var headerTitle2 = ['No', 'Kode Barang', 'Nama Barang', 'Jumlah', 'Harga Satuan', 'Total Harga'];
    var kode;
    var kode2;
    var hal = 0;
    var totalHalaman;
    var limit = 10;

    var data = new Array(limit);
    for (i = 0; i < 100; i++) {
        data[i] = new Array(100);
    }

    var data2;

    var datasend = new Array(100);
    for (i = 0; i < 100; i++) {
        datasend[i] = new Array(100);
    }

    $(document).ready(function() {
        $(document).attr('title', title);
        $('#title').html(title);

        loadHeader(headerTitle);
        loadHeader2(headerTitle2);
        sendReq(1, '1111');
    });

    ///////////////////////////////////////////////////////
    // PART A - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART B - MENGAMBIL DATA DARI DATABASE///////////////
    ///////////////////////////////////////////////////////

    function sendReq(inhal, inkode) {
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
            url: 'client/pembelian_po/get_data_pembelian_po.php',
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

                    data[i][0] = response.data[i].id_purchaseorder;
                    data[i][1] = response.data[i].no_nota; 
                    data[i][7] = response.data[i].total;  
                    data[i][10] = response.data[i].keterangan;
                    data[i][11] = response.data[i].id_pemasok;
                    data[i][12] = response.data[i].tanggal_order;
                    data[i][14] = (response.data[i].isaccepted == 1 ? 'Diterima' : 'Belum Diterima');
                    data[i][15] = response.data[i].nama;
                    data[i][16] = response.data[i].alamat;
                    data[i][17] = response.data[i].kota;
                    data[i][18] = response.data[i].kodepos;

                    //tabel standar field
                    data[i][94] = response.data[i].createddate;
                    data[i][95] = response.data[i].createdby;

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

    function sendReq2(inhal, inkode, id) {
        hal = inhal;
        kode2 = inkode;
        datasend[0][1] = USERID;
        datasend[0][2] = id;
        datasend[0][97] = kode2;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/pembelian_po/get_data_pembelian_po_detail.php',
            data: {myJson: datasend},
            beforeSend: function() {
                $('#loading').show();
            },
            complete: function() {
                $('#loading').hide();
            }
        }).success(function(response) {
            var jumlahData = response.data[0].totaldata;

            data2 = new Array(jumlahData);
            for (i = 0; i < 100; i++) {
                data2[i] = new Array(100);
            }

            for (i = 0; i < jumlahData; i++) {
                data2[i][0] = response.data[i].id_purchaseorderdetail;
                data2[i][1] = response.data[i].id_purchaseorder;
                data2[i][2] = response.data[i].id_barang;
                data2[i][3] = response.data[i].harga;
                data2[i][4] = response.data[i].jumlah;
                data2[i][5] = response.data[i].nama;
                data2[i][6] = response.data[i].kode;

                //dont change this is for pagination
                data2[i][98] = response.data[i].totalrow;
                data2[i][99] = response.data[i].totaldata;

            }

            $('#isi_tabel2').html(fillTable2(data2));
            $('#loadpage').hide();

            if ($('#forminput').css('display') == 'none') {
                toggleForm('forminput');
            }

        });
    }

    ///////////////////////////////////////////////////////
    // PART B - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART C - PENGATURAN FORM ///////////////////////////
    ///////////////////////////////////////////////////////


    function gridView(id) {

        $('#loadpage').show();
        $('#id').val(data[id][0]);

        $('#no_notaview').html(data[id][1]);
        $('#no_fakturview').html(data[id][2]);
        $('#tdnama_pemasok').html(data[id][15]);
        $('#tdalamat_pemasok').html(data[id][16] + ', ' + data[id][17] + ' ' + data[id][18]);
        $('#tanggalview').html(dateToString(data[id][12])); 
        $('#totalview').html(toRp(data[id][7]));  
        $('#keteranganview').html(data[id][10]);

        sendReq2(1, '5557', data[id][0]);

    }

    function toggleForm(param) {
        if (param == 'forminput') {
            if ($('#' + param).css('display') == 'none') {
                $('#' + param).show();
            } else {
                $('#' + param).hide();
            }
        }
    }

    function simpleSearch() {
        datasend[0][96] = $('#teks_cari').val();
        sendReq(1, '5555');
    }

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
        title += "<th>Aksi</th>";
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
            reValueTable += '<td align="center">' + i + '</td>'; 
            reValueTable += '<td align="center">' + data[j][1] + '</td>';
            reValueTable += '<td align="center">' + dateToString(data[j][12]) + '</td>';
            reValueTable += '<td align="center">' + data[j][15] + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][7]) + '</td>';
            reValueTable += '<td align="center">' + data[j][14] + '</td>';
            reValueTable += '<td align="center"><a href="#" class="detail" onclick="gridView(' + j + ')"></a> ';
            reValueTable += '</tr>';
            i++;
        }

        return reValueTable
    }

    function fillTable2(data) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data[0][98]; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center">' + i + '</td>';
            reValueTable += '<td align="center">' + data[j][6] + '</td>';
            reValueTable += '<td align="left">' + data[j][5] + '</td>';
            reValueTable += '<td align="center">' + data[j][4] + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][3]) + '</td>';
            reValueTable += '<td align="right">' + toRp(parseInt(data[j][3]) * parseInt(data[j][4])) + '</td>';
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
        $('#forminput').hide();
    }

    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    ///////////////////////////////////////////////////////    

    function cetakNota() {
        cetak('index.php?cetak=69a344a8d280d7ef8da2c73ed290ad57', $('#id').val());
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
<!--HIDDEN VALUE, DONT CHANGE THIS-->
<span style="display: none;">
    <tr>
        <td>
            <input type="text" id="formtype" value="INS"  />
            <input type="text" id="id" value="1" />
            <input type="text" id="sendKode" />
        </td>
    </tr>
</span>
<!-----------------> 

<div id="forminput" style="display: none;">

    <table style="width:100%;"id="content_table2">
        <tr>
            <td style="width:80px">No Referensi</td>
            <td style="width:10px;">:</td>
            <td id="no_notaview">tesnonota</td>
            <td align="right">
                Tanggal Order : 
                <span id="tanggalview">testp</span>
            </td>
        </tr>
        <tr>
            <td>Pemasok</td> 
            <td>:</td> 
            <td>
                <span id="tdnama_pemasok"></span> 
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td> 
            <td></td> 
            <td><span id="tdalamat_pemasok"></span></td>
            <td></td>
        </tr> 
    </table>

    <br />

    <div id="dataaddrow">
        <table style="width: 100%;" id='content_table'>
            <thead id="judul_tabel2"></thead>
            <tbody id="isi_tabel2"></tbody>
        </table>	
    </div>

    <br />

    <div id="tabel_bayar" >
        <table width="100%" id="content_table2">

            <tr>
                <td width="80px">Keterangan</td>
                <td width="10px">:</td>
                <td id="keteranganview">tesket</td>
                <td align="right" id="totalview" rowspan="6"><strong>Rp. 0,00</strong></td>
            </tr>

        </table>                       
    </div>

    <div style="text-align: center;">

        <br />
        <span class='tombol' onclick="toggleForm('forminput');">TUTUP</span> 
        <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 
        <br /><br />

    </div>

    <hr />

</div>


<!--div cari-->
<div id="top_command">
    <div id="cari">
        Cari Purchase Order : 
        <input type="text" id="teks_cari" class="text" value="" size="30" onkeypress="if (event.keyCode == 13) { simpleSearch(); }" />                 
    </div>
    <div id="loading" style="display: none;">
        <img src="asset/images/299.png" /> 
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

<a href="#" class="back" onclick="resetTable();">Reset Tabel</a>
| 
<a href="?page=a09fb5efbe1d0486945f17991b632be8" class="tambah">Tambah</a>