<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : hutang_pembayaran.php                                                                                 *
 * DESC     : Digunakan untuk melakukan transaksi pembayaran hutang kepada pemasok                                  *
 * CREATED  : 14/1/2014                                                                                             *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Transaksi \u00BB Pembayaran Hutang';
    var headerTitle = ['No', 'No Referensi<br />Pembelian', 'Total', 'Uang Muka', 'Total<br />Pembayaran Hutang', 'Total Retur', 'Sisa Hutang', 'Jatuh Tempo', 'Jumlah Bayar', 'Aksi'];
    var nomer = 1;
    var totalHarga = 0;
    var jumlahBarang = 0;
    var limit = 10;
    var idHutang;

    var data = new Array(limit);
    for (i = 0; i < 100; i++) {
        data[i] = new Array(100);
    }

    var datasend = new Array(100);
    for (i = 0; i < 100; i++) {
        datasend[i] = new Array(100);
    }

    $(document).ready(function() {
        //$(document).bind("keydown", disableF5);
        $(document).attr('title', title);
        $('#title').html(title);
        $('#id').val(0);
        loadHeader(headerTitle);
        clearForm();
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
            url: 'client/hutang/get_data_hutang.php',
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

                    data[i][0] = response.data[i].id_pemasok;
                    data[i][1] = response.data[i].id_pembelian;
                    data[i][2] = response.data[i].no_faktur;
                    data[i][3] = response.data[i].nama;
                    data[i][4] = response.data[i].total;
                    data[i][5] = response.data[i].bayar;
                    data[i][6] = response.data[i].jumlah_bayar_hutang;
                    data[i][7] = response.data[i].jumlah_retur;
                    data[i][8] = response.data[i].kontak;
                    data[i][9] = response.data[i].telepon;
                    data[i][10] = response.data[i].alamat;
                    data[i][11] = response.data[i].kota;
                    data[i][12] = response.data[i].kodepos;

                    //dont change this is for pagination
                    data[i][98] = response.data[i].total_row;
                    data[i][99] = response.data[i].total_data;
                }
            }

            $('#namapemasokview').html(data[0][3]);
            $('#alamatpemasokview').html(data[0][10] + ', ' + data[0][11] + ' ' + data[0][12]);

            sendReq2(1, '1112');

        });
    }

    function sendReq2(inhal, inkode) {
        hal = inhal;
        kode2 = inkode;
        datasend[0][1] = USERID;
        datasend[0][2] = $('#id').val();
        datasend[0][97] = kode2;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/hutang/get_data_hutang.php',
            data: {myJson: datasend},
            beforeSend: function() {
                $('#loading').show();
            },
            complete: function() {
                $('#loading').hide();
            }
        }).success(function(response) {
            var jumlahData = response.data[0].totaldata;

            var data2 = new Array(jumlahData);
            for (i = 0; i < 100; i++) {
                data2[i] = new Array(100);
            }

            for (i = 0; i < jumlahData; i++) {
                data2[i][0] = response.data[i].id_pemasok;
                data2[i][1] = response.data[i].id_pembelian;
                data2[i][2] = response.data[i].no_faktur;
                data2[i][3] = response.data[i].nama;
                data2[i][4] = response.data[i].total;
                data2[i][5] = response.data[i].bayar;
                data2[i][6] = response.data[i].jumlah_bayar_hutang;
                data2[i][7] = response.data[i].jumlah_retur;
                data2[i][8] = response.data[i].kontak;
                data2[i][9] = response.data[i].telepon;
                data2[i][10] = response.data[i].alamat;
                data2[i][11] = response.data[i].kota;
                data2[i][12] = response.data[i].jatuh_tempo;
                data2[i][13] = response.data[i].no_nota;

                //dont change this is for pagination
                data2[i][98] = response.data[i].totalrow;
                data2[i][99] = response.data[i].totaldata;

            }
            $('#isi_tabel').html(fillTable(data2));

            $('#trinputpemasok').hide();
            $('#trnamapemasok').show();
            $('#tralamatpemasok').show();

            $('#loadpage').hide();
        });
    }

    ///////////////////////////////////////////////////////
    // PART B - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART C - PENGATURAN FORM ///////////////////////////
    ///////////////////////////////////////////////////////

    function clearForm() {
        $('#content_table tbody').html('');
        $('#id').val(0);
        $('#keterangan').val('');
        $('#totalBayar').html('Rp. 0');
        $('#totalview').html('<strong>Rp. 0</strong>');

        unHiddenField();
    }

    function hiddenField() {
        $("#content_table th:last-child, #content_table td:last-child").hide();
        $('.vjumlahbayar').show();

        $('#tdketerangan').hide();
        $('#keteranganview').show();

        $('#bbayar').hide();
        $('#bcetak').show();
    }

    function unHiddenField() {
        $('#trinputpemasok').show();
        $('#trnamapemasok').hide();
        $('#tralamatpemasok').hide();

        $('#tdketerangan').show();
        $('#keteranganview').hide();

        $("#content_table th:last-child, #content_table td:last-child").show();

        $('#bbayar').show();
        $('#bcetak').hide();
    }

    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
    ///////////////////////////////////////////////////////

    function entryValidate() {

        var totalBayar = 0;
        var reValue = true;

        if ($('#id').val() == 0) {
            alertify.error('Masukan Data Pemasok <br /> &nbsp;');
            reValue = false;
        } else if ($('#totalBayar').html() == 'Rp. 0') {
            alertify.error('Total pembayaran tidak boleh 0 <br /> &nbsp;');
            reValue = false;
        } else {
            totalBayar = parseInt(toAngka($('#totalBayar').html()));
            reValue = true;
        }

        if (reValue) {
            datasend[0][1] = USERID;
            datasend[0][2] = $('#id').val();
            datasend[0][3] = totalBayar;
            datasend[0][4] = $('#keterangan').val();
            datasend[0][97] = '4444';

            $.ajax({
                type: 'post',
                cache: false,
                dataType: 'json',
                url: 'client/hutang/get_data_hutang_pembayaran.php',
                data: {myJson: datasend},
                beforeSend: function() {
                    //$('#loadpage').fadeIn(500);
                }
            }).success(function(response) {
                idHutang = response.data[0].id_hutang;
                //alert(idHutang);
                saveDetail();
            });
        }

    }

    function saveDetail() {
        var totaldata = 0;

        $('input[id="jumlahbayar[]"]').each(function() {
            totaldata++;
        });

        var datasend = new Array(totaldata);
        for (i = 0; i <= totaldata; i++) {
            datasend[i] = new Array(100);
        }

        var i = 1;
        $('input[id="idpembelian[]"]').each(function() {
            datasend[i][0] = $(this).val();
            i++;
        });


        var i = 1;
        $('input[id="jumlahbayar[]"]').each(function() {
            if ($(this).val() == '') {
                datasend[i][1] = 0;
            } else {
                datasend[i][1] = parseInt(toAngka($(this).val()));
            }

            var sisahutang = parseInt(toAngka($(this).parent().prev().prev().html()));
            
            if (sisahutang - datasend[i][1] == 0) {
                datasend[i][2] = 1;
            } else {
                datasend[i][2] = 0;
            }
            
            datasend[i][3] = sisahutang - datasend[i][1];
            
            $(this).hide();
            i++;
        });

        datasend[0][1] = USERID;
        datasend[0][2] = idHutang;
        datasend[0][97] = '4444';

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/hutang/get_data_hutang_pembayaran_detail.php',
            data: {myJson: datasend},
            beforeSend: function() {
            }
        }).success(function(response) {
            $('#keteranganview').html($('#keterangan').val());
            hiddenField();
            $('#loadpage').hide();
            alertify.success('Pembayaran Hutang Berhasil Disimpan <br /> &nbsp;');
        });

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

        var total = 0;
        var uangmuka = 0;
        var totalretur = 0;
        var totalpembayaran = 0;
        var sisa = 0;

        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data[0][98]; j++) {

            total += parseInt((data[j][4] == null ? 0 : data[j][4]));
            uangmuka += parseInt((data[j][5] == null ? 0 : data[j][5]));
            totalretur += parseInt((data[j][6] == null ? 0 : data[j][6]));
            totalpembayaran += parseInt((data[j][7] == null ? 0 : data[j][7]));
            sisa += parseInt((data[j][4] - data[j][5] - data[j][6] - data[j][7]));

            reValueTable += '<tr>';
            reValueTable += '<td align="center" width="25">' + i + '</td>';
            reValueTable += '<td align="center">' + data[j][13] + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][3] == null ? 0 : data[j][4]) + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][4] == null ? 0 : data[j][5]) + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][6] == null ? 0 : data[j][6]) + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][5] == null ? 0 : data[j][7]) + '</td>';

            if (data[j][4] - data[j][5] - data[j][6] - data[j][7] < 0) {
                reValueTable += '<td align="right" style="color:red; font-weight:bold">' + toRp(data[j][4] - data[j][5] - data[j][6] - data[j][7]) + '</td>';
            } else {
                reValueTable += '<td align="right">' + toRp(data[j][4] - data[j][5] - data[j][6] - data[j][7]) + '</td>';
            }

            if (checkDate(convertDatabaseToDate(data[j][12]), getTodayDate())) {
                reValueTable += '<td align="center">' + dateToString(data[j][12]) + '</td>';
            } else {
                reValueTable += '<td align="center" style="color:red; font-weight:bold">' + dateToString(data[j][12]) + '</td>';
            }
            reValueTable += '<td align="right">';
            reValueTable += '<input type="hidden" value=' + data[j][1] + ' id="idpembelian[]"/>';
            reValueTable += '<span class="vjumlahbayar" style="display:none">Rp. 0</span>';
            reValueTable += '<input type="text" class="text" id="jumlahbayar[]" onkeypress="return IsAngka(event);" size="15" onfocus="changeToAngka(this);" onblur="changeToRp(this);" onkeyup="cekNilai(this);" />';
            reValueTable += '</td>';
              reValueTable += '<td align="center"><input type="checkbox" id="lunasFaktur[]" onclick="lunasFaktur(this)" />Lunas <a href="#" id="resetFaktur[]" class="back" onclick="resetFaktur(this)">Reset</a></td>';
            reValueTable += '</td></tr>';
            i++;
            
        }

        reValueTable += '<tr>';
        reValueTable += '<td align="center" width="25" colspan=2><strong>TOTAL</strong></td>';
        reValueTable += '<td align="right">' + toRp(total) + '</td>';
        reValueTable += '<td align="right">' + toRp(uangmuka) + '</td>';
        reValueTable += '<td align="right">' + toRp(totalretur) + '</td>';
        reValueTable += '<td align="right">' + toRp(totalpembayaran) + '</td>';

        if (sisa < 0) {
            reValueTable += '<td align="right" style="color:red; font-weight:bold">' + toRp(sisa) + '</td>';
        } else {
            reValueTable += '<td align="right">' + toRp(sisa) + '</td>';
        }

        reValueTable += '<td align="right"></td>';
        reValueTable += '<td align="right"><strong><span id="totalBayar">Rp. 0</span></strong></td>';
        reValueTable += '<td align="center"><input type="checkbox" id="lunasAll" onclick="lunasAll()" />Lunas <a href="#" id="resetAll" class="back" onclick="resetAll()">Reset</a></td>';
        reValueTable += '</tr>';

        return reValueTable
    }

    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    ///////////////////////////////////////////////////////

    function hitungTotal() {
        var jumlahBayar = 0;

        $('input[id="jumlahbayar[]"]').each(function() {
            var bayar = $(this).val();
            if (bayar.substr(0, 1) == 'R') {
                jumlahBayar += parseInt(toAngka(bayar));
            } else if (bayar != '') {
                jumlahBayar += parseInt(bayar);
            }
        });

        $('#totalBayar').html(toRp(jumlahBayar));
    }

    function cekNilai(element) {
        var sisa = 0;
        var pembayaran = 0;
        sisa = parseInt(toAngka($(element).parent().prev().prev().html()));
        pembayaran = ($(element).val() == "") ? 0 : parseInt($(element).val());

        if (pembayaran > sisa) {
            alertify.error("Jumlah pembayaran tidak bisa melebihi jumlah hutang <br /> &nbsp;");
            $(element).val(sisa);
            $(element).prev().html(toRp(sisa));
            $(element).parent().next().children().prop('checked', true);
        } else if (pembayaran == sisa) {
            $(element).prev().html(toRp(pembayaran));
            $(element).parent().next().children().prop('checked', true);
        } else {
            $(element).prev().html(toRp(pembayaran));
        }

        hitungTotal();
    }

    function lunasAll() {
        if ($('#lunasAll').prop('checked') == true) {
            $('input[id="lunasFaktur[]"]').each(function() {
                $(this).prop('checked', true);
            });

            $('input[id="jumlahbayar[]"]').each(function() {
                $(this).val($(this).parent().prev().prev().html());
                $(this).prev().html($(this).val());
            });
        }

        $('input[id="jumlahbayar[]"]').each(function() {
            $(this).css('background-color', 'white');
        });
        hitungTotal();
    }

    function lunasFaktur(element) {
        if ($(element).prop('checked') == true) {
            $(element).parent().prev().children().next().val($(element).parent().prev().prev().prev().html());
            $(element).parent().prev().children().html($(element).parent().prev().prev().prev().html());
        }
        hitungTotal();
    }

    function resetFaktur(element) {
        $(element).parent().prev().children().prev().html('Rp. 0');
        $(element).parent().prev().children().val('');
        $(element).prev().prop('checked', false);
        $('#lunasAll').prop('checked', false);

        hitungTotal();
    }

    function resetAll() {
        $('#lunasAll').prop('checked', false);
        $('input[id="lunasFaktur[]"]').each(function() {
            $(this).prop('checked', false);
        });

        $('input[id="jumlahbayar[]"]').each(function() {
            $(this).val('');
        });

        $('.vjumlahbayar').html('Rp. 0');

        hitungTotal();
    }

    function cetakNota() {
        cetak('index.php?cetak=29b63e558b09ce6d0898459ea5ed9b27', idHutang);
    }

    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART G - FUNGSI ADDROW///////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART G - END/////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART H - FUNGSI POPUP//////////////////////////////// 
    ///////////////////////////////////////////////////////

    function showListPemasok() {
        winRef = openWindow('index.php?page=99ee36095c8580cdc6ec6a3b55eac16f');
    }

    function getDataPemasok(id) {
        $('#id').val(id);
        sendReq(1, '1112');
    }

    ///////////////////////////////////////////////////////
    //PART H - END///////////////////////////////////////// 
    ///////////////////////////////////////////////////////

</script>

<div id="loadpage"> 
    <p align="center" style="font-size: large;">
        <img src="asset/images/spin.gif" />
        <br /><b>Loading ... Please wait!</b>
    </p>
</div>

<span style="display: none ;">
    <tr>
        <td>
            <input type="text" id="formtype" value="INS"  />
            <input type="text" id="id" value="0" />
            <input type="text" id="sendKode" />
        </td>
    </tr>
</span>

<h1 id="title"></h1>

<table width="100%" id="content_table2" border="0">

    <tr id="trinputpemasok">
        <td style="width:60px;">Pemasok</td>
        <td style="width:10px;">:</td> 
        <td><a href="#" id="bShowListPemasok" class="detail" onclick="showListPemasok();"></a></td>     
    </tr>			    
    <tr id="trnamapemasok">
        <td style="width:60px;">Pemasok</td> 
        <td style="width:10px;">:</td> 
        <td><span id="namapemasokview"></span></td>
        <td></td>
    </tr>
    <tr id="tralamatpemasok">
        <td></td> 
        <td></td>
        <td><span id="alamatpemasokview"></span></td>
        <td></td>
    </tr> 
</table>

<br/>

<table id="content_table" width="100%">
    <thead id="judul_tabel"></thead>
    <tbody id="isi_tabel"></tbody>       
</table>         

<br />   

<div id="tabel_bayar">
    <table style="width:100%;" border="0"  id="content_table2">		

        <tr id="trketerangan">
            <td style="width:80px;">Keterangan</td>
            <td style="width:10px;">:</td>
            <td id="tdketerangan">
                <input type="text" class="text" id="keterangan" size="50" />
            </td>
            <td id="keteranganview">tesket</td>
        </tr>

    </table>                       
</div>
<div style="text-align: center;">
    <br />
    <span class='tombol' id="bbayar" onclick="entryValidate();">SIMPAN</span> 
    <span class='tombol' id="breset" value='Reset' onclick="clearForm();" >RESET</span>  
    <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 
</div>