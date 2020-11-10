<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : laporan_penjualan.php                                                                                 *
 * DESC     : Digunakan untuk menampilkan laporan penjualanbarang                                                   *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Laporan \u00BB Laporan Penjualan';
    var headerTitle = ['No', 'No Faktur', 'Tanggal Penjualan', 'Pelanggan', 'Total'];
    var kode;
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
        sendReq(1, '1111');

        $('#tanggal_mulai').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        $('#tanggal_akhir').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        $('#tanggal_mulai').val(getTodayDate());
        $('#tanggal_akhir').val(getTodayDate());
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
        datasend[0][3] = convertDateToDatabse($('#tanggal_mulai').val());
        datasend[0][4] = convertDateToDatabse($('#tanggal_akhir').val());
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;


        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/laporan_penjualan/get_data_penjualan.php',
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

                    data[i][0] = response.data[i].id_penjualan;
                    data[i][2] = response.data[i].no_faktur;
                    data[i][3] = response.data[i].subtotal;
                    data[i][4] = response.data[i].biaya_kirim; 
                    data[i][7] = response.data[i].total;
                    data[i][8] = response.data[i].bayar;
                    data[i][17] = response.data[i].kembali;
                    data[i][9] = response.data[i].status_pembayaran;
                    data[i][10] = response.data[i].keterangan;
                    data[i][11] = response.data[i].id_pelanggan;
                    data[i][12] = response.data[i].tanggal_penjualan;
                    data[i][13] = response.data[i].jatuh_tempo;
                    data[i][14] = response.data[i].islunas;
                    data[i][15] = response.data[i].nama;
                    data[i][16] = response.data[i].alamat;

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
            reValueTable += '<td align="center">' + i + '</td>';
            reValueTable += '<td align="center">' + data[j][2] + '</td>';
            reValueTable += '<td align="center">' + dateToString(data[j][12]) + '</td>';
            reValueTable += '<td align="center">' + data[j][15] + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][7]) + '</td>';
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

    function showListPelanggan() {
        winRef = openWindow('index.php?page=a1d65ca2b4f53fa1e0131bba95686d24');
    }

    function getDataPelanggan(id, nama, alamat, kota) {
        $('#id').val(id);
        $('#perpelanggan').html(nama);
    }

    function cetakNota() {
        var type = 1;
        var startdate = convertDateToDatabse($('#tanggal_mulai').val());
        var enddate = convertDateToDatabse($('#tanggal_akhir').val());
        var id = $('#id').val();

        if ($('#showall').is(':checked')) {
            type = 1;
        } else {
            type = 2;
        }

        cetakLaporan('index.php?cetak=0a660f4c7cac6c65667f6acdd4605e5d', type, startdate, enddate, id);
    }

    function showPerDate() {
        $('#perdate').show();
    }

    function showAll() {
        $('#perdate').hide();
    }

    function showPerPelanggan() {
        $('#perpelanggan').html('');
        $('#id').val(0);
        $('#perpelanggan').show();
        showListPelanggan();
    }

    function showAllPelanggan() {
        $('#id').val(0);
        $('#perpelanggan').hide();
    }

    function entryValidate() {
        if ($('#showperdate').is(':checked')) {
            if (!checkDate($('#tanggal_akhir').val(), $('#tanggal_mulai').val())) {
                alertify.error('Tanggal akhir tidak boleh kurang dari tanggal mulai! <br /> &nbsp;');
            } else {
                sendReq(1, '1112');
            }
        } else {
            sendReq(1, '1111');
        }

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
<span style="display: none">
    <tr>
        <td>
            <input type="text" id="formtype" value="INS"  />
            <input type="text" id="id" value="0" />
            <input type="text" id="sendKode" />
        </td>
    </tr>
</span>
<!-----------------> 

<div id="forminput" style="display:">
    <form id="forminputs" method="post" enctype="multipart/form-data">

        <table id="content_form" style="width: 100%;" border="0">   
            <tr>
                <td width="5%">
                    Periode
                </td>
                <td width="40%">
                    <input type="radio" name="rb_filter" id="showall" checked="checked" onclick="showAll()"/>Semua 
                    <input type="radio" name="rb_filter" id="showperdate" onclick="showPerDate()" />Per Tanggal &nbsp;
                    <span id="perdate" style="display:none">
                        <input type="text" id="tanggal_mulai" readonly="readonly" class="text"/> s/d
                        <input type="text" id="tanggal_akhir" readonly="readonly" class="text"/>
                    </span> 
                </td>
                <td width="5%">
                    Pelanggan
                </td>
                <td width="40%">
                    <input type="radio" name="rb_filter_pelanggan" id="showall" checked="checked" onclick="showAllPelanggan()"/>Semua 
                    <input type="radio" name="rb_filter_pelanggan" id="showperdate" onclick="showPerPelanggan()" />Per Pelanggan &nbsp;
                    <span id="perpelanggan" style="display:none">
                        
                    </span> 
                </td>
            </tr> 
            <tr>
                <td align="center" style="padding:15px;" colspan="4">
                    <span class='tombol' id="bcetak" onclick="entryValidate();">TAMPILKAN</span> &nbsp;
                    <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 
                </td>
            </tr>
        </table> 
        <hr />
    </form>
</div>

<div id="datagrid">
    <table style="width: 100%;" id='content_table'>
        <thead id="judul_tabel"></thead>
        <tbody id="isi_tabel"></tbody>
    </table>        

    <br />

    <p style="text-align: right;" id="pagination"></p>
</div> 