<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : pembelian_retur.php                                                                                   *
 * DESC     : Digunakan untuk melakukan transaksi retur pembelian                                                   *
 * CREATED  : 14/1/2014                                                                                             *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Transaksi \u00BB Retur Penjualan';
    var headerTitle = ['No', 'Nama Barang', 'Jumlah Jual', 'Harga Satuan', 'Total Harga Jual', 'Sisa Barang', 'Jumlah Retur', 'Total Harga Retur'];
    var nomer = 1;
    var totalHarga = 0;
    var jumlahBarang = 0;
    var limit = 10;
    var barang;
    var idReturJual;

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
        loadHeader(headerTitle);

        $('#id').val(0);
        unHiddenField();
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
        datasend[0][96] = $('#id').val();
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/penjualan_retur/get_data_penjualan.php',
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
                    data[i][9] = response.data[i].status_pembayaran;
                    data[i][10] = response.data[i].keterangan;
                    data[i][11] = response.data[i].id_pemasok;
                    data[i][12] = response.data[i].tanggal_penjualan;
                    data[i][13] = response.data[i].jatuh_tempo;
                    data[i][14] = response.data[i].islunas;
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
            }

            $('#nonotaview').html(data[0][1]);
            $('#nofakturview').html(data[0][2]);
            $('#tanggalview').html(dateToString(data[0][12]));
            $('#namapelangganview').html(data[0][15]);
            $('#alamatpelangganview').html(data[0][16] + ', ' + data[0][17] + ' ' + data[0][18]);
            $('#totalpenjualanview').html('<strong>' + toRp(data[0][3]) + '</strong>');

            $('#trinputfaktur').hide(); 
            $('#trfaktur').show();
            $('#trnamapelanggan').show();
            $('#tralamatpelanggan').show();
            
            sendReq2(1, '5557');
        });
    }

    function sendReq2(inhal, inkode) {
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
            url: 'client/penjualan_retur/get_data_penjualan_detail.php',
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
                data2[i][0] = response.data[i].id_penjualan;
                data2[i][1] = response.data[i].id_barang;
                data2[i][2] = response.data[i].harga;
                data2[i][3] = response.data[i].jumlah;
                data2[i][4] = response.data[i].nama;
                data2[i][5] = response.data[i].kode;
                data2[i][6] = response.data[i].id_persediaan;
                data2[i][7] = response.data[i].retur;

                //dont change this is for pagination
                data2[i][98] = response.data[i].totalrow;
                data2[i][99] = response.data[i].totaldata;
            }                   
            
            $('#isi_tabel').html(fillTable(data2));
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
        $('#totalpembelianview').html('Rp. 0');
        $('#totalview').html('<strong>Rp. 0</strong>');
        unHiddenField();
    }

    function hiddenField() {      
        $('#trnotaretur').show();
        $('.vjumlahretur').show();
        
        $('#tdketerangan').hide();
        $('#keteranganview').show();
        
        $('#bbayar').hide();
        $('#bcetak').show();
    }

    function unHiddenField() {
        $('#trfaktur').hide();
        $('#trnamapelanggan').hide();
        $('#tralamatpelanggan').hide();
         
        $('#trnotaretur').hide();       
        $('#trinputfaktur').show();
        
        $('#tdketerangan').show();
        $('#keteranganview').hide();  
        
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
        reValue = false;

        if ($('#id').val() == 0) {
            alertify.error('Masukan Data Pembelian <br /> &nbsp;');
            reValue = false;
        } else if ($('#total').val() == 0) {
            alertify.error('Masukan minimal 1 barang retur <br /> &nbsp;');
            reValue = false;
        } else {
            reValue = true;
        }

        if (reValue) {
            datasend[0][1] = USERID;
            datasend[0][2] = $('#id').val();
            datasend[0][97] = '4444';
            datasend[0][98] = 1;
            datasend[0][99] = 10;

            datasend[0][3] = $('#total').val();
            datasend[0][4] = $('#keterangan').val();

            $.ajax({
                type: 'post',
                cache: false,
                dataType: 'json',
                url: 'client/penjualan_retur/get_data_penjualan_retur.php',
                data: {myJson: datasend},
                beforeSend: function() {
                    $('#loadpage').fadeIn();
                }
            }).success(function(response) {
                
                idReturJual = response.data[0].id_returjual;
                idPelanggan= response.data[0].idpelanggan;
                idPenjualan = response.data[0].id_penjualan;
                
                $('#notareturview').html(response.data[0].no_nota);
                $('#tanggalreturview').html(dateToString(response.data[0].tanggal_retur));
                
                saveDetail(idReturJual, idPelanggan, idPenjualan);
            });
        }
    }

    function saveDetail(idReturJual, idPelanggan, idPenjualan) {
        var totalData = 0;
        $('input[id="idpersediaan[]"]').each(function() {
            totalData++;
        });

        var datasend = new Array(totalData);
        for (i = 0; i <= totalData; i++) {
            datasend[i] = new Array(100);
        }

        var i = 1;
        $('input[id="idpersediaan[]"]').each(function() {
            datasend[i][0] = $(this).val();
            i++;
        });

        var i = 1;
        $('input[id="jumlahretur[]"]').each(function() {
            datasend[i][1] = $(this).val();
            i++;
            $(this).hide();
        });

        var i = 1;
        $('input[id="hargasatuan[]"]').each(function() {
            datasend[i][2] = $(this).val();
            i++;
        });
        
        var i = 1;
        $('input[id="idbarang[]"]').each(function() {
            datasend[i][3] = $(this).val();
            i++;
        });

        datasend[0][1] = USERID;
        datasend[0][2] = idReturJual;
        datasend[0][3] = idPelanggan;
        datasend[0][4] = idPenjualan;
        datasend[0][97] = '4444';

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/penjualan_retur/get_data_penjualan_retur_detail.php',
            data: {myJson: datasend}
        }).success(function(response) {
            $('#keteranganview').html($('#keterangan').val());
            hiddenField();
            $('#loadpage').hide();
            alertify.success('Retur Penjualan Berhasil Disimpan <br /> &nbsp;');
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

    function fillTable(data2) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data2[0][98]; j++) {
            reValueTable += '<tr>';

            reValueTable += '<td align="center" width="25">' + i + '</td>'; 
            reValueTable += '<td><input type="hidden" id="idbarang[]" value="' + data2[j][1] + '" /><input type="hidden" id="idpersediaan[]" value="' + data2[j][6] + '" />' + data2[j][4] + '</td>';
            reValueTable += '<td align="center">' + data2[j][3] + '</td>';
            reValueTable += '<td align="right"><input type="hidden" id="hargasatuan[]" value="' + data2[j][2] + '" />' + toRp(data2[j][2]) + '</td>';
            reValueTable += '<td align="right">' + toRp(data2[j][2] * data2[j][3]) + '</td>';
            reValueTable += '<td align="center">' + (data2[j][3] - data2[j][7]) + '</td>';
            reValueTable += '<td align="center"><input type="text" size="4" class="text" id="jumlahretur[]" onkeypress="return IsAngka(event);" onkeyup="isiTotalHargaRetur(this)"><span class="vjumlahretur" style="display:none">0</span></td>';
            reValueTable += '<td align="center"><input type="hidden" id="totalhargaretur[]" /><span id="vtotalhargaretur">Rp. 0</span></td>';

            reValueTable += '</tr>';
            i++;
        }

        return reValueTable
    }

    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    ///////////////////////////////////////////////////////

    function isiTotalHargaRetur(element) {
        var sisaBarang = parseInt($(element).parent().prev().html());
        var jumlahRetur = $(element).val();

        if (jumlahRetur > sisaBarang) {
            alertify.error("Jumlah retur tidak boleh lebih besar dari jumlah sisa barang <br /> &nbsp;");

            jumlahRetur = sisaBarang;

            $(element).val(sisaBarang);
            $(element).focus();
        } else if (jumlahRetur == '') {
            jumlahRetur = 0;
        }

        totalHargaRetur = 0;
        var hargaSatuan = $(element).parent().prev().prev().prev().children().val();
        var totalHarga = parseInt(jumlahRetur) * parseInt(hargaSatuan);
        $(element).parent().next().children().next().html(toRp(totalHarga));
        $(element).parent().next().children().val(totalHarga);
        $(element).next().html(jumlahRetur);

        var totalData = 0;
        $('input[id="jumlahretur[]"]').each(function() {
            totalData++;
        });

        var i = 0;
        $('input[id="idbarangretur[]"]').each(function() {
            datasend[i][0] = $(this).val();
        });

        var i = 0;
        $('input[id="jumlahretur[]"]').each(function() {
            datasend[i][1] = $(this).val();
        });

        var i = 0;
        $('input[id="totalhargaretur[]"]').each(function() {
            datasend[i][1] = $(this).val();
            if ($(this).val() == '') {
            } else {
                totalHargaRetur += parseInt($(this).val());
            }
        });

        $('#totalview').html('<strong>' + toRp(totalHargaRetur) + '</strong>')
        $('#total').val(totalHargaRetur);

    }
    
    function cetakNota() {
        cetak('index.php?cetak=6750c8feff18cbffd53544189d2372fb', idReturJual);
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

    function showListPenjualan() {
        winRef = openWindow('index.php?page=e0c0d984d33cbdd6ad56e714da479a3d');
    }

    function getDataPenjualan(id) {
        $('#id').val(id);                  
        sendReq(1, '5557');
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

    <tr id="trinputfaktur">
        <td style="width:60px;">Penjualan</td>
        <td style="width:10px;">:</td> 
        <td><a href="#" id="bShowListPenjualan" class="detail" onclick="showListPenjualan();"></a></td>     
    </tr>

    <tr id="trnotaretur">
        <td>No Ref. Retur</td>
        <td>:</td> 
        <td id="notareturview"></td>
        <td align="right">
            Tanggal Retur :  
            <span id="tanggalreturview"></span>
        </td>
    </tr>
    <tr id="trfaktur">
        <td  style="width:90px;">No Faktur</td>
        <td  style="width:10px;">:</td> 
        <td id="nofakturview"></td>
        <td align="right">
            Tanggal Penjualan :  
            <span id="tanggalview"></span>
        </td>
    </tr>
    <tr id="trnamapelanggan">
        <td>Pelanggan</td> 
        <td>:</td> 
        <td><span id="namapelangganview"></span></td>
        <td></td>
    </tr>
    <tr id="tralamatpelanggan">
        <td></td> 
        <td></td>
        <td><span id="alamatpelangganview"></span></td>
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
        <tr>
            <td style="width:110px;">Total Penjualan</td>
            <td style="width:10;">:</td>
            <td id="totalpenjualanview">Rp. 0</td>  
            <td><input type="hidden" id="total" /></td>
            <td align="right" id="totalview" rowspan="2"><strong>Rp. 0</strong></td>
        </tr>		

        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td id="tdketerangan">
                <input type="text" class="text" id="keterangan" size="50" />
            </td>
            <td id="keteranganview">tesket</td>
        </tr>

    </table>                       
</div>
<div style="text-align: center;">
    <span class='tombol' id="bbayar" onclick="entryValidate();">SIMPAN</span> 
    <span class='tombol' id="breset" value='Reset' onclick="clearForm();" >RESET</span> 
    <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 
</div>