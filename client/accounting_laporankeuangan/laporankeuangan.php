<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : laporankeuangan.php                                                                                   *
 * DESC     : Digunakan untuk menampilkan laporan keuangan                                                          *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Accounting \u00BB Laporan Keuangan';
    var headerTitle = ['No', 'Tanggal Mulai', 'Tanggal Akhir', 'Lihat'];
    var kode;
    var hal = 0;
    var totalHalaman;
    var limit = 10;
    var idPeriode = 0;

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
        hal = inhal;
        kode = inkode;
        datasend[0][1] = USERID;
        datasend[0][2] = $('#idperiode').val();
        datasend[0][3] = convertDateToDatabse($('#tanggal_mulai').val());
        datasend[0][4] = convertDateToDatabse($('#tanggal_akhir').val());
        datasend[0][97] = kode;
        datasend[0][98] = hal;
        datasend[0][99] = limit;      
        
        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/accounting_laporankeuangan/get_data_laporankeuangan.php',
            data: {myJson: datasend}
        }).success(function(response) {
            
            pendapatan = 0;
            biayaangkutpenjualan = 0;
            returpenjualan = 0;
            penjualanbersih = 0;
            hpp = 0;
            biayaangkutpembelian = 0;
            labarugi = 0;
            kasdebit = 0;
            kaskredit = 0;
            piutangdagangdebit = 0;
            piutangdagangkredit = 0;
            persediaanbarangdagangandebit = 0;
            persediaanbarangdagangankredit = 0;
            utangdagangdebit = 0;
            utangdagangkredit = 0;
            modaldebit = 0;
            modalkredit = 0;
            jumlahdebit = 0;
            jumlahkredit = 0; 
            
            if(response.data[0].totalrow > 0){
                pendapatan = parseInt(response.data[4].sumkredit);
                biayaangkutpenjualan = parseInt(response.data[6].sumkredit);
                returpenjualan = parseInt(response.data[5].sumdebit);
                penjualanbersih = pendapatan + biayaangkutpenjualan - returpenjualan;

                hppdebit = parseInt(response.data[10].sumdebit);
                hppkredit = parseInt(response.data[10].sumkredit);

                hpp = (hppdebit - hppkredit);
                biayaangkutpembelian = parseInt(response.data[9].sumdebit); 

                labarugi = penjualanbersih - hpp;

                kasdebit = parseInt(response.data[0].sumdebit);
                kaskredit = parseInt(response.data[0].sumkredit);
                piutangdagangdebit = parseInt(response.data[1].sumdebit);
                piutangdagangkredit = parseInt(response.data[1].sumkredit);
                persediaanbarangdagangandebit = parseInt(response.data[2].sumdebit);
                persediaanbarangdagangankredit = parseInt(response.data[2].sumkredit);

                utangdagangdebit = parseInt(response.data[3].sumdebit);
                utangdagangkredit = parseInt(response.data[3].sumkredit);

                modalkredit = labarugi;
                modaldebit = 0;
                
                jumlahdebit = kasdebit + piutangdagangdebit + utangdagangdebit + persediaanbarangdagangandebit + modaldebit + biayaangkutpembelian;
                jumlahkredit = kaskredit + piutangdagangkredit + utangdagangkredit + persediaanbarangdagangankredit + modalkredit;
            } 
            
            $('#pendapatanpenjualan').html(toRp(pendapatan));
            $('#biayaangkutpenjualan').html(toRp(biayaangkutpenjualan));
            $('#returpenjualan').html(toRp(returpenjualan));
            $('#penjualanbersih').html(toRp(penjualanbersih));
            
            $('#hpp').html(toRp(hpp));            
            $('#biayaangkutpembelian').html(toRp(biayaangkutpembelian));            
            $('#labarugi').html(toRp(labarugi));
            
            $('#kasdebit').html(toRp(kasdebit));
            $('#kaskredit').html(toRp(kaskredit));
            
            $('#piutangdagangdebit').html(toRp(piutangdagangdebit));
            $('#piutangdagangkredit').html(toRp(piutangdagangkredit));
            
            $('#persediaanbarangdagangandebit').html(toRp(persediaanbarangdagangandebit));
            $('#persediaanbarangdagangankredit').html(toRp(persediaanbarangdagangankredit));
            
            $('#utangdagangdebit').html(toRp(utangdagangdebit));
            $('#utangdagangkredit').html(toRp(utangdagangkredit));
            
            $('#modaldebit').html(toRp(modaldebit));
            $('#modalkredit').html(toRp(modalkredit));
            
            $('#jumlahdebit').html(toRp(jumlahdebit));
            $('#jumlahkredit').html(toRp(jumlahkredit));
            
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
            reValueTable += '<td align="center">' + dateToString(data[j][1]) + '</td>';
            reValueTable += '<td align="center">' + (data[j][2] == null ? '-' : dateToString(data[j][2])) + '</td>';
            reValueTable += '<td align="center"><a href="#" class="detail" onclick="gridView(' + j + ')"></a> ';
            i++;
        }

        return reValueTable
    }

    function pagingCLick(hal) {
        sendReq(hal, kode);
    }

    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    ///////////////////////////////////////////////////////
    function searchSimple() {
        if (!checkDate($('#tanggal_akhir').val(), $('#tanggal_mulai').val())) {
            alertify.error('Tanggal akhir tidak boleh kurang dari tanggal mulai! <br /> &nbsp;');
        } else {
            sendReq(1, '5555');
        }
    }
    
    function showPerDate() {
        $('#perdate').show();
    }

    function showAll() {
        $('#perdate').hide();
        sendReq(1, '1111');
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

        printLaporan('index.php?cetak=257a3007200d55d50bfef4dbec3d5082', type, startdate, enddate, 0, 0, 0, 0, 0, 0, 0);
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
<span style="display: none ">
    <tr>
        <td>
            <input type="text" id="formtype" value="INS"  />
            <input type="text" id="idperiode" value="0" />
            <input type="text" id="idlabarugi" value="1" />
            <input type="text" id="sendKode" />
        </td>
    </tr>
</span>
<!-----------------> 

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

<div id="forminput">
    <form id="forminputs" method="post" enctype="multipart/form-data">

        <table id="content_form" style="width: 100%;" border="0">                           
            
            <tr>
                <td align="center" colspan="3"><strong>Laporan Laba Rugi</strong></td>                 
            </tr> 

            <tr>
                <td>Pendapatan Penjualan</td>
                <td width="30%"></td>
                <td width="30%" align="right"><span id="pendapatanpenjualan">Rp. 0</span></td>
            </tr>
            <tr>
                <td>Biaya Angkut Penjualan</td>
                <td></td>
                <td align="right"><span id="biayaangkutpenjualan">Rp. 0</span></td>
            </tr>
            <tr>
                <td>Retur dan Pengurangan Penjualan</td>
                <td align="right"><span id="returpenjualan">Rp. 0</span></td>
                <td></td>
            </tr>         
            
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Penjualan Bersih</td>
                <td></td>
                <td align="right"><span id="penjualanbersih">Rp. 0</span></td>
            </tr>
            <tr>
                <td>HPP</td>
                <td align="right"><span id="hpp">Rp. 0</span></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Laba / Rugi Bersih</td>
                <td></td>
                <td align="right"><span id="labarugi">Rp. 0</span></td>
            </tr>
        </table>
        
        <br />
        
        <table id="content_form" style="width: 100%;">                           
            
            <tr>
                <td align="center" colspan="3"><strong>Neraca</strong></td>                 
            </tr> 

            <tr>
                <td align="center"><strong>Keterangan</strong></td>
                <td width="30%" align="center"><strong>Debit</strong></td>
                <td width="30%" align="center"><strong>Kredit</strong></td>
            </tr>
            
            <tr>
                <td>Aktiva</td>
                <td></td>
                <td></td>
            </tr>
            
            <tr>
                <td>&nbsp;&nbsp;Kas</td>
                <td align="right"><span id="kasdebit"></span></td>
                <td align="right"><span id="kaskredit"></span></td> 
            </tr>
            
            <tr>
                <td>&nbsp;&nbsp;Piutang Dagang</td>
                <td align="right"><span id="piutangdagangdebit"></span></td>
                <td align="right"><span id="piutangdagangkredit"></span></td>
            </tr>
            
            <tr>
                <td>&nbsp;&nbsp;Persediaan Barang Dagangan</td>
                <td align="right"><span id="persediaanbarangdagangandebit"></span></td>
                <td align="right"><span id="persediaanbarangdagangankredit"></span></td>
            </tr>
            
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
            
            <tr>
                <td>Kewajiban</td>
                <td></td>
                <td></td>
            </tr>
                                   
            <tr>
                <td>&nbsp;&nbsp;Utang Dagang</td>
                <td align="right"><span id="utangdagangdebit">0</span></td>
                <td align="right"><span id="utangdagangkredit">0</span></td>
            </tr>
            
            <tr>
                <td>&nbsp;&nbsp;Biaya Angkut Pembelian</td>
                <td align="right"><span id="biayaangkutpembelian">Rp. 0</span></td>
                <td></td>
            </tr>
            
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
            
            <tr>
                <td>Ekuitas</td>
                <td></td>
                <td></td>
            </tr>
                                   
            <tr>
                <td>&nbsp;&nbsp;Laba Rugi</td>
                <td align="right"><span id="modaldebit"></span></td>
                <td align="right"><span id="modalkredit"></span></td>
            </tr>
            
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
            
            <tr>
                <td><strong>Jumlah</strong></td>
                <td align="right"><span id="jumlahdebit"><strong>Rp. 0</strong></span></td>
                <td align="right"><span id="jumlahkredit"><strong>Rp. 0</strong></span></td>
            </tr>
        </table>
        
    </form>
</div>
<br /><br />
<div style="text-align: center;"> 
    <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 
</div>
