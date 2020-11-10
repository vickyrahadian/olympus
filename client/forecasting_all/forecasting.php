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
    var headerTitle = ['No', 'Nama Barang', 'Single', 'Double', 'Triple'];
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
        datasend[0][3] = $('#alpha').val();
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/forecasting_all/get_data_barang.php',
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
                    data[i][2] = response.data[i].single;
                    data[i][3] = response.data[i].double;
                    data[i][4] = response.data[i].triple;

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
         sendReq(1, '1111');
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


    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    /////////////////////////////////////////////////////// 

    function changealphaview() {
        $('#alphaview').html($('#alpha').val());
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
            <td width="10%">Nilai Alpha (&alpha;)</td>
            <td id="tdalpha">
                <input id="alpha" type="hidden" size="3" class="text" value="0.01" readonly="readonly"/> 
                <input id="alphaslider" type="range" min="0.01" max="0.99" step="0.01" value="0.01"/> 
                <span id="alphaview">0,01</span>
            </td> 
        </tr>  

        <tr>
            <td colspan="2" align="center" style="padding:15px;">
                <span class='tombol' id="bsimpan" onclick="entryValidate();">TAMPILKAN PERAMALAN</span>  
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