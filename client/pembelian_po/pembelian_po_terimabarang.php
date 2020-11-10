<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : pembelian_po_terimabarang.php                                                                         *
 * DESC     : Digunakan untuk melakukan penerimaan barang dari purchaseorder                                        *
 * CREATED  : 14/1/2014                                                                                             *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Transaksi \u00BB Penerimaan Order Barang';
    var headerTitle = ['No', 'Nama Barang', 'Jumlah Pesan', 'Harga Pesan', 'Jumlah Terima', 'Harga Terima', 'Total'];
    var nomer = 1;
    var totalHarga = 0;
    var jumlahBarang = 0;
    var limit = 10;
    var barang;
    var idPembelian;
    var idPurchaseOrder;

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
        unHiddenField();

        $('#tanggal').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        $('#jatuhtempo').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        shortcut.add("F8", function() {
            showListOrder();
        });

        $('#biayakirim').blur(function() {
            if ($('#biayakirim').val() != '') { 
                $('#biayakirim').val(toRp($('#biayakirim').val()));
            } else { 
                $('#biayakirim').val(toRp(0));
            }
            hitungGrandTotal();
        });

        $('#biayakirim').focus(function() {
            if ($('#biayakirim').val() != '') {
                $('#biayakirim').val(toAngka($('#biayakirim').val()));
            }
        });       

        $('#bayar').blur(function() {
            if(parseInt($('#bayar').val()) > parseInt(toAngka($('#subtotalview').html()))) {
                $('#bayar').val($('#subtotalview').html());
            } else {             
                if ($('#bayar').val() != '') { 
                    $('#bayar').val(toRp($('#bayar').val()));
                } else { 
                    $('#bayar').val(toRp(0));
                }
            }
        });

        $('#bayar').focus(function() {
            if ($('#bayar').val() != '') {
                $('#bayar').val(toAngka($('#bayar').val()));
            }
        });
        
        clearForm();
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
        datasend[0][2] = $('#id_order').val();
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/pembelian_po/get_data_pembelian_po.php',
            data: {myJson: datasend}
        }).success(function(response) {

            var jumlahData = response.data[0].totalrow;
            if (jumlahData <= 0) {
                $('#isi_tabel').html('');
                $('#pagination').html(fillPagination(1, 1));
            } else {
                idPurchaseOrder = response.data[0].id_purchaseorder;
                totalHarga = response.data[0].total;
                $('#subtotalview').html(toRp(response.data[0].total));                
                $('#subtotal').val(response.data[0].total);
                sendReq2(1, '5557', idPurchaseOrder);
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
            data: {myJson: datasend}
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
            hitungGrandTotal();
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
        $('#no_faktur').css('background-color', '');
        $('#no_faktur').val('');
        $('#id_pemasok').val('');
        $('#tanggal').val(getTodayDate());
        $('#tanggalview').html(getTodayDate());
                
        $('#in_barang').val('');
        $('#in_kode_barang').val('');
        $('#in_id_barang').val('');
        $('#in_nama_barang').val('');
        $('#in_banyak_barang').val('');
        $('#in_harga_jual').val('');
        $('#in_jumlah_harga').val('');
        $('#in_text_nama_barang').html('');

        $('#tdnama_pemasok').html('');
        $('#tdorder').html('');
        $('#tdalamat_pemasok').html('');

        $('#subtotalview').html('Rp. 0,00');
        $('#totalview').html('Rp. 0,00');
        $('#biayakirim').val('Rp. 0,00'); 
        $('#lunasbiayakirim').prop('checked', false);
        $('#bayar').val('Rp. 0,00');   
        $('#jatuhtempo').val(getTodayDate());
        $('#jatuhtempoview').html(getTodayDate());
        $('#keterangan').val('');      
        
        $('#content_table tbody').html('');
        unHiddenField();
        loadHeader(headerTitle);
        totalHarga = 0;
    }

    function unHiddenField() {
        $('#trnonotapembelian').hide();
        $('#tdno_faktur').show();
        $('#no_fakturview').hide();
        $('#bShowListOrder').show();
        $('#tdtanggal').show();
        $('#tanggalview').hide();
        $('#forminputbarang').show();
        $('#tdsubtotal').hide();
        $('#subtotalview').show();
        $('#tdbiayakirim').show();
        $('#biayakirimview').hide(); 
        $('#tdtotal').hide();
        $('#totalview').show();
        $('#tdbayar').show();
        $('#bayarview').hide();
        $('#tdjatuhtempo').show();
        $('#jatuhtempoview').hide();
        $('#tdketerangan').show();
        $('#keteranganview').hide();
        $('#bbayar').show();
        $('#bcetak').hide();
    }

    function hiddenField() {
        $('#trnonotapembelian').show();
        $('#tdno_faktur').hide();
        $('#no_fakturview').show();
        $('#bShowListOrder').hide();
        $('#tdtanggal').hide();
        $('#tanggalview').show();
        $('#forminputbarang').hide();
        $('#tdsubtotal').hide();
        $('#subtotalview').show();
        $('#tdbiayakirim').hide();
        $('#biayakirimview').show(); 
        $('#tdtotal').hide();
        $('#totalview').show();
        $('#tdbayar').hide();
        $('#bayarview').show();
        $('#tdjatuhtempo').hide();
        $('#jatuhtempoview').show();
        $('#tdketerangan').hide();
        $('#keteranganview').show();
        $('#bbayar').hide();
        $('#bcetak').show();

        $("#content_table th:last-child, #content_table td:last-child").remove();
        $('.v_in_banyak_barang').show();
        $('.v_in_harga_barang').show();
    }


    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
    ///////////////////////////////////////////////////////

    function entryValidate() {
        reValue = false;
        
        noFaktur = $('#no_faktur').val();
        idPemasok = $('#id_pemasok').val();
        tanggal = $('#tanggal').val();
        subtotal = parseInt(toAngka($('#subtotalview').html()));
        bkirim = $('#biayakirim').val() == 'Rp. 0,00' ? 0 : parseInt(toAngka($('#biayakirim').val()));
        total = parseInt(toAngka($('#totalview').html()));
        bayar = $('#bayar').val() == 'Rp. 0,00' ? 0 : parseInt(toAngka($('#bayar').val()));
        keterangan = $('#keterangan').val(); 
        
        if ($('#tanggal').val() == '') {
            $('#tanggal').css('background-color', 'yellow');
            reValue = false;
            alertify.error('Silahkan masukan tanggal pembelian! <br /> &nbsp;');
        } else {
            $('#tanggal').css('background-color', 'white');

            if ($('#jatuhtempo').val() == '') {
                $('#jatuhtempo').css('background-color', 'yellow');
                reValue = false;
                alertify.error('Silahkan masukan tanggal jatuh tempo! <br /> &nbsp;');
            } else {
                $('#jatuhtempo').css('background-color', 'white');
                if (noFaktur == '') {
                    $('#no_faktur').focus().css('background-color', 'yellow');
                    alertify.error('Silahkan masukan no faktur pembelian! <br /> &nbsp;');
                } else if (idPemasok == '') {
                    alertify.error('Silahkan pilih pemasok! <br /> &nbsp;');
                } else if (!checkDate($('#jatuhtempo').val(), $('#tanggal').val())) {
                    alertify.error('Tanggal jatuh tempo tidak boleh kurang dari tanggal pembelian! <br /> &nbsp;');
                } else if (subtotal <= 0) {
                    alertify.error('Masukan minimal 1 buah barang <br /> &nbsp;');
                } else if (bayar > total) {
                    alertify.error('Pembayaran melebihi total harga <br /> &nbsp;');
                } else if (bayar < bkirim) {
                    alertify.error('Biaya kirim harus dilunasi <br /> &nbsp;');
                } else {
                    reValue = true;
                }
            }
        }

        if (reValue) {

            datasend[0][3] = noFaktur;
            datasend[0][4] = subtotal;
            datasend[0][5] = bkirim; 
            datasend[0][8] = total;
            datasend[0][9] = bayar;
            datasend[0][10] = total - bayar == 0 ? 1 : 0;
            datasend[0][11] = keterangan;
            datasend[0][12] = idPemasok;
            datasend[0][13] = convertDateToDatabse($('#tanggal').val());
            datasend[0][14] = convertDateToDatabse($('#jatuhtempo').val());
            datasend[0][15] = idPurchaseOrder; 

            datasend[0][1] = USERID;
            datasend[0][97] = '4444';

            $.ajax({
                type: 'post',
                cache: false,
                dataType: 'json',
                url: 'client/pembelian/get_data_pembelian.php',
                data: {myJson: datasend},
                beforeSend: function() {
                    $('#loadpage').fadeIn(500);
                }
            }).success(function(response) {
                idPembelian = response.data[0].id_pembelian;
                $('#nonotapembelianview').html(response.data[0].no_nota);
                saveDetail(idPembelian);
            });
        }
    }

    function saveDetail(idPembelian) {
        var totalData = 0;
        $('input[id="id_barang[]"]').each(function() {
            totalData++;
        });

        var datasend = new Array(totalData);
        for (i = 0; i <= totalData; i++) {
            datasend[i] = new Array(100);
        }

        var i = 1;
        $('input[id="id_barang[]"]').each(function() {
            datasend[i][0] = $(this).val();
            i++;
        });

        var i = 1;
        $('input[id="banyak_barang[]"]').each(function() {
            datasend[i][1] = $(this).val();
            $(this).hide();
            i++;
        });

        var i = 1;
        $('input[id="harga_barang[]"]').each(function() {
            datasend[i][2] = toAngka($(this).val());
            $(this).hide();
            i++;
        });

        var i = 1;
        $('input[id="jumlah_harga[]"]').each(function() {
            datasend[i][3] = $(this).val();
            i++;
        });

        datasend[0][1] = USERID;
        datasend[0][2] = idPembelian;
        datasend[0][3] = $('#id_pemasok').val();
        datasend[0][97] = '4444';
        
        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/pembelian/get_data_pembelian_detail.php',
            data: {myJson: datasend}
        }).success(function(response) {
            hiddenField();
            $('#no_fakturview').html($('#no_faktur').val());
            $('#tanggalview').html($('#tanggal').val());
            biayaKirim = $('#biayakirim').val();
            if($('#lunasbiayakirim').prop('checked') && toAngka(biayaKirim) > 0){
                biayaKirim = $('#biayakirim').val() + ' / Lunas';
            } 
            $('#biayakirimview').html(biayaKirim); 
            $('#bayarview').html($('#bayar').val());
            $('#jatuhtempoview').html($('#jatuhtempo').val());
            $('#keteranganview').html($('#keterangan').val());
            $('#loadpage').hide();
            alertify.success('Detail Penerimaan Barang Berhasil Disimpan <br /> &nbsp;');
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
        title += "<th>Hapus</th>";
        title += "</tr>";
        $('#judul_tabel').html(title);
    }
    
    function fillTable(data){
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data[0][98]; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center">' + i + '</td>';
            reValueTable += '<td align="left"><input type="hidden" id="id_barang[]" value="' + data[j][2] + '">' + data[j][5] + '</td>'; 
            reValueTable += '<td align="right">' + data[j][4] + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][3]) + '</td>';
            reValueTable += '<td align="center"><input class="text" type="text" size="3" id="banyak_barang[]" value="' + data[j][4] + '" onkeyup="updateHarga(this);" onkeypress="return IsAngka(event);"><span class="v_in_banyak_barang" style="display:none">' + data[j][4] + '</span></td>';
            reValueTable += '<td align="center"><input class="text" type="text" size="15" id="harga_barang[]" value="' + toRp(data[j][3]) + '" onfocus="$(this).val(toAngka($(this).val()));" onblur="$(this).val(toRp($(this).val()));" onkeyup="updateHarga(this);" onkeypress="return IsAngka(event);"><span class="v_in_harga_barang" style="display:none">' + toRp(data[j][3]) + '</span></td>';
            reValueTable += '<td align="right"><input type="hidden" id="jumlah_harga[]" value="' + (data[j][3] * data[j][4]) + '"><span id="v_in_jumlah_harga">' + toRp(data[j][3] * data[j][4]) + '</span></td>';
            reValueTable += '<td align="center"><img src="asset/images/delete.png" onClick="eraseRow(this);"></td>';           
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

    function hitungGrandTotal() {

        var biayaKirim = $('#biayakirim').val();
        if (biayaKirim == '') {
            biayaKirim = 0;
        }
 
        var bayarBayar = $('#bayar').val();
        if (bayarBayar == '') {
            bayarBayar = 0;
        }

        var total = parseInt(totalHarga) + parseInt(toAngka(biayaKirim));
        $('#totalview').html(toRp(total)); 
    }

    function updateHarga(element) {
        if ($(element).prop('id') == 'harga_barang[]') {
            var harga = $(element).val() == '' ? 0 : $(element).val();
            var totalBarang = $(element).parent().prev().children().val();
            var jumlahHarga = parseInt(totalBarang) * parseInt(harga);  

            $(element).next().html(toRp($(element).val()));

            $(element).parent().next().children().val(jumlahHarga);
            $(element).parent().next().children().next().html(toRp(jumlahHarga));
        } else if ($(element).prop('id') == 'banyak_barang[]') {
            var total = $(element).val() == '' ? 0 : $(element).val();
            var hargaBarang = toAngka($(element).parent().next().children().val());
            var jumlahHarga = parseInt(hargaBarang) * parseInt(total);            
            
            $(element).next().html($(element).val());

            $(element).parent().next().next().children().val(jumlahHarga);
            $(element).parent().next().next().children().next().html(toRp(jumlahHarga));
        }

        totalHarga = 0;
        $('input[id="jumlah_harga[]"]').each(function() {
            totalHarga = parseInt(totalHarga) + parseInt($(this).val());
        });

        $('#subtotalview').html(toRp(totalHarga)); 
        hitungGrandTotal();
    }

    function isiLunas() {
        var total = $('#totalview').html();
        if (total != '') {
            $('#bayar').val(total);
        }
    }

    function cetakNota() {
        cetak('index.php?cetak=1e04a1720c57aaa75b1d45eae45dfda8', idPembelian);
    }

    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART G - FUNGSI ADDROW///////////////////////////////
    ///////////////////////////////////////////////////////

    function eraseRow(element) {
        var harga = $(element).parent().prev().children().val();
        totalHarga = parseInt(totalHarga) - parseInt(harga);
        $('#subtotal').val(totalHarga);
        $('#subtotalview').html(toRp(totalHarga));
        $(element).parent().parent().remove();
        hitungGrandTotal();
        isiNomer();
        $('#in_barang').focus();
    }

    function isiNomer() {
        var nomer = 1;
        $('#content_table tbody tr').each(function() {
            $(this).find('td:first').html(nomer);
            nomer++;
        });
    }

    ///////////////////////////////////////////////////////
    //PART G - END/////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART H - FUNGSI POPUP//////////////////////////////// 
    ///////////////////////////////////////////////////////

    function showListOrder() {
        winRef = openWindow('index.php?page=518f2282e4255da235d5c5dc1f0e0d7e');
    }
 
    function getDataOrder(idorder, idpemasok, nama, alamat, no_nota) {
        $('#id_order').val(idorder);
        $('#id_pemasok').val(idpemasok);
        $('#nama_pemasok').val(nama);
        $('#alamat_pemasok').val(alamat);
        $('#tdnama_pemasok').html(nama + '&nbsp;');
        $('#tdalamat_pemasok').html(alamat);
        $('#tdorder').html(no_nota + '&nbsp;');
        
        sendReq(1, '1115');
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

<h1 id="title"></h1>

<input type="hidden" id="id_order" /> 
<input type="hidden" id="id_pemasok" /> 
<input type="hidden" id="nama_pemasok" /> 
<input type="hidden" id="alamat_pemasok" /> 

<table style="width:100%;" border="0" id="content_table2">
    <tr id="trnonotapembelian">
        <td style="width:120px;">No Nota</td>
        <td>:</td>
        <td id="nonotapembelianview">tesnp</td>        
    </tr>
    
    <tr>
        <td>No. Order</td> 
        <td>:</td> 
        <td>
            <span id="tdorder"></span> 
            <a href="#" id="bShowListOrder" class="detail" onclick="showListOrder();"></a>
        </td>
        <td></td>
        <td></td>
    </tr>
    
    <tr>
        <td style="width:100px;">No Faktur</td>
        <td style="width:10px;">:</td>
        <td id="tdno_faktur"><input type="text" class="text" id="no_faktur" name="ino_faktur" /></td>
        <td id="no_fakturview">tesnf</td>
        <td align="right">
            Tanggal Penerimaan : 
            <span id="tdtanggal"><input type="text" class="text" id="tanggal" name="itanggal" readonly="readonly" size="12" /></span>
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
        <td></td>
    </tr>
    <tr>
        <td></td> 
        <td></td>
        <td><span id="tdalamat_pemasok"></span></td>
        <td></td>
        <td></td>
    </tr> 
</table>

<table id="content_table" width="100%">
    <thead id="judul_tabel"></thead>
    <tbody id="isi_tabel"></tbody>       
</table>         

<br />   

<div id="tabel_bayar" >
    <table width="100%" border="0" id="content_table2">
        <tr>
            <td width="100">Subtotal</td>
            <td width="10">:</td>
            <td id="subtotalview">Rp. 0,00</td>  
            <td align="right" rowspan="5"><strong><span id="totalview">Rp. 0,00</span></strong></td>
        </tr>

        <tr>
            <td>Biaya Kirim</td>
            <td>:</td>
            <td id="tdbiayakirim">
                <input type="text" class="text" id="biayakirim" size="20" onkeypress="return IsAngka(event);"/> 
            </td>
            <td id="biayakirimview">tes</td>
        </tr>     

        <tr>  
            <td>Bayar</td>
            <td>:</td>
            <td id="tdbayar"> 
                <input type="text" class="text" id="bayar" size="20" onkeypress="return IsAngka(event);"/> 
                <span class="tombol" onclick="isiLunas();">Lunas</span>
            </td>
            <td id="bayarview">tes</td>
        </tr>

        <tr>  
            <td>Jatuh Tempo</td>
            <td>:</td>
            <td id="tdjatuhtempo">
                <input type="text" class="text" size="12" id="jatuhtempo" readonly="readonly" />
            </td>
            <td id="jatuhtempoview">tesjt</td>
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
<br />
<div style="text-align: center;">

    <span class='tombol' id="bbayar" onclick="entryValidate();">SIMPAN</span> 
    <span class='tombol' id="breset" value='Reset' onclick="clearForm();" >RESET</span> 
    <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 

</div>
