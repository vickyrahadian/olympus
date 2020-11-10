<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : penjualan.php                                                                                         *
 * DESC     : Digunakan untuk melakukan transaksi penjualan                                                         *
 * CREATED  : 14/1/2014                                                                                             *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Transaksi \u00BB Penjualan (POS)';
    var headerTitle = ['No', 'Kode Barang', 'Nama Barang', 'Jumlah', 'Harga Satuan', 'Total Harga'];
    var nomer = 1;
    var totalHarga = 0;
    var jumlahBarang = 0;
    var limit = 10;
    var barang;
    var idPenjualan;

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
        getAllBarang(); 

        $('#jatuhtempo').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        shortcut.add("F8", function() {
            showListBarang();
        });

        $('#biayakirim').blur(function() {
            if ($('#biayakirim').val() != '') { 
                $('#biayakirim').val(toRp($('#biayakirim').val()));
            } else {
                $('#biayakirim').val(0); 
                $('#biayakirim').val(toRp($('#biayakirim').val()));
            }
            hitungGrandTotal();
        });

        $('#biayakirim').focus(function() {
            if ($('#biayakirim').val() != '') {
                $('#biayakirim').val(toAngka($('#biayakirim').val()));
            }
        });

        $('#bayar').blur(function() {
            if ($('#bayar').val() != '') { 
                $('#bayar').val(toRp($('#bayar').val()));
            } else {
                $('#bayar').val(0); 
                $('#bayar').val(toRp($('#bayar').val()));
            }
            hitungGrandTotal();
        });

        $('#bayar').focus(function() {
            if ($('#bayar').val() != '') {
                $('#bayar').val(toAngka($('#bayar').val()));
            }
        });
        
        clearForm();
    });

    ///////////////////////////////////////////////////////
    // PART A - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART B - MENGAMBIL DATA DARI DATABASE///////////////
    ///////////////////////////////////////////////////////

    function getAllBarang() {
        //DONT CHANGE THIS 6 LINES 
        datasend[0][1] = USERID;
        datasend[0][2] = $('#id').val();
        datasend[0][97] = '1114';

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/penjualan/get_barang.php',
            data: {myJson: datasend}
        }).success(function(response) {

            var jumlahData = response.data[0].totalrow;
            barang = new Array(jumlahData);
            for (i = 0; i < jumlahData; i++) {
                barang[i] = new Array(100);
            }
            for (i = 0; i < jumlahData; i++) {
                barang[i][0] = response.data[i].id_barang;
                barang[i][1] = response.data[i].kode;
                barang[i][2] = response.data[i].barcode;
                barang[i][3] = response.data[i].nama;
                barang[i][4] = response.data[i].id_satuan;
                barang[i][5] = response.data[i].harga_ecer;
                barang[i][6] = response.data[i].stok_terjual;
                barang[i][7] = response.data[i].id_kategori;
                barang[i][8] = response.data[i].namakategori;
                barang[i][10] = response.data[i].namasatuan;
                barang[i][12] = response.data[i].gambar;
                barang[i][13] = response.data[i].jumlahmasuk;
                barang[i][14] = response.data[i].jumlahkeluar;
                barang[i][15] = response.data[i].stok;

                //tabel standar field
                barang[i][93] = response.data[i].status;
                barang[i][94] = response.data[i].createddate;
                barang[i][95] = response.data[i].createdby;
                barang[i][96] = response.data[i].updateddate;
                barang[i][97] = response.data[i].updatedby;

                //dont change this is for pagination
                barang[i][98] = response.data[i].totalrow;
                barang[i][99] = response.data[i].totaldata;
            }

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
        $('#in_barang').val('');
        $('#in_kode_barang').val('');
        $('#in_id_barang').val('');
        $('#in_nama_barang').val('');
        $('#in_banyak_barang').val('');
        $('#in_harga_jual').val('');
        $('#in_jumlah_harga').val('');
        $('#in_text_nama_barang').html('');
        
        $('#iskirim').prop('checked', false);
        $('#trkendaraan').hide();
        
        $('#id_pelanggan').val(0);
        $('#nama_pelanggan').val('');
        $('#alamat_pelanggan').val(''); 

        $('#subtotalview').html('Rp. 0');
        $('#totalview').html('Rp. 0');
        $('#biayakirim').val('Rp. 0');  
        $('#bayar').val('Rp. 0');   
        $('#jatuhtempo').val(getTodayDate());
        $('#tanggal').val(getTodayDate());
        $('#keterangan').val('');      
        $('#kembaliview').html(toRp(0));

        $('#content_table tbody').html('');

        unHiddenField();
        loadHeader(headerTitle);
        getAllBarang();
        totalHarga = 0;
    }

    function unHiddenField() {
        $('#trpelangganradio').show();
        $('#trpelanggan').hide();
        $('#tdtanggal').show();
        $('#tanggalview').hide();
        $('#forminputbarang').show();
        $('#tdsubtotal').hide();
        $('#subtotalview').show();
        $('#trbiayakirim').show();
        $('#iskirim').show(); 
        $('#biayakirimview').hide();
        $('#kendaraanview').hide();
        $('#tdbiayalain').show();
        $('#biayalainview').hide();
        $('#tbiayapajak').show();
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
        $('#bcetak2').hide();
    }

    function hiddenField() {
        $('#trpelangganradio').hide();
        $('#trpelanggan').show();
        $('#tdtanggal').hide();
        $('#tanggalview').show();
        $('#forminputbarang').hide();
        $('#tdsubtotal').hide();
        $('#subtotalview').show();
        if ($('#iskirim').prop('checked') == true) {
            $('#biayakirimview').show();
            $('#tdbiayakirim').hide();
            $('#bcetak2').show();
        } else {
            $('#trbiayakirim').hide();
            $('#bcetak2').hide();
        }
        $('#iskirim').hide();
        $('#tbiayakirim').hide();
        $('#tdkendaraan').hide();
        $('#kendaraanview').show();
        $('#tdbiayalain').hide(); 
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
    }


    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
    ///////////////////////////////////////////////////////

    function entryValidate() {        
        reValue = true;
        
        idPelanggan = $('#id_pelanggan').val();tanggal = $('#tanggal').val();
        subtotal = parseInt(toAngka($('#subtotalview').html()));
        bkirim = $('#biayakirim').val() == 'Rp. 0' ? 0 : parseInt(toAngka($('#biayakirim').val()));
        total = parseInt(toAngka($('#totalview').html()));
        bayar = $('#bayar').val() == 'Rp. 0' ? 0 : parseInt(toAngka($('#bayar').val()));
        keterangan = $('#keterangan').val();
        iskirim = $('#iskirim').prop('checked') == true ? 1 : 0;
        idkendaraan = $('#kendaraan').val();

        if ($('#jatuhtempo').val() == '') {
            $('#jatuhtempo').css('background-color', 'yellow');
            alertify.error('Silahkan masukan tanggal jatuh tempo! <br /> &nbsp;');
            reValue = false;
        } else {
            $('#jatuhtempo').css('background-color', 'white');

            if (!checkDate($('#jatuhtempo').val(), $('#tanggal').val())) {
                alertify.error('Tanggal jatuh tempo tidak boleh kurang dari tanggal penjualan! <br /> &nbsp;');
                reValue = false;
            }

            if (subtotal <= 0) {
                alertify.error('Masukan minimal 1 buah barang <br /> &nbsp;');
                reValue = false;
            }

            if ($('#iscustomerno').is(':checked')) {
                if (bayar < total) {
                    alertify.error('Non Pelanggan harus melunasi pembayaran');
                    reValue = false;
                }
            }

            if ($('#iscustomeryes').is(':checked')) {
                if ($('#id_pelanggan').val() == 0) {
                    alertify.error('Masukan data pelanggan');
                    reValue = false;
                }
            }
            
            if (bayar < bkirim) {
                alertify.error('Biaya kirim harus dilunasi <br /> &nbsp;');
                reValue = false;
            }
        }

        if (reValue == false) {
            //alertify.error("Silahkan koreksi field yang berwarna kuning <br /> &nbsp;");
        } else {
            datasend[0][4] = subtotal;
            datasend[0][5] = bkirim;
            datasend[0][8] = total;
            datasend[0][9] = bayar;
            datasend[0][10] = bayar - total >= 0 ? 1 : 0;
            datasend[0][11] = $('#keterangan').val();
            datasend[0][12] = (idPelanggan == '' ? 0 : idPelanggan);
            datasend[0][13] = convertDateToDatabse($('#tanggal').val());
            datasend[0][14] = convertDateToDatabse($('#jatuhtempo').val());
            datasend[0][16] = ($('#keterangan').val() == '' ? '-' : $('#keterangan').val());
            datasend[0][17] = toAngka($('#kembaliview').html());
            //sementara
            datasend[0][18] = idkendaraan;
            datasend[0][19] = iskirim;

            datasend[0][1] = USERID;
            datasend[0][97] = '4444';

            $.ajax({
                type: 'post',
                cache: false,
                dataType: 'json',
                url: 'client/penjualan/get_data_penjualan.php',
                data: {myJson: datasend},
                beforeSend: function() {
                    $('#loadpage').fadeIn(500);
                }
            }).success(function(response) {
                idPenjualan = response.data[0].id_penjualan;
                saveDetail(idPenjualan);
            });

        }
    }

    function saveDetail(idPenjualan) {
        var totalData = 0;
        $('input[id="kode_barang[]"]').each(function() {
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
            datasend[i][2] = $(this).val();
            $(this).hide();
            i++;
        });

        var i = 1;
        $('input[id="jumlah_harga[]"]').each(function() {
            datasend[i][3] = $(this).val();
            i++;
        });

        datasend[0][1] = USERID;
        datasend[0][2] = idPenjualan;
        datasend[0][3] = $('#id_pelanggan').val();
        datasend[0][97] = '4444';


        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/penjualan/get_data_penjualan_detail.php',
            data: {myJson: datasend}
        }).success(function(response) {
            hiddenField();
            $('#tanggalview').html($('#tanggal').val());
            $('#kendaraanview').html($('#kendaraan :selected').text());
            $('#biayakirimview').html($('#biayakirim').val()); 
            $('#bayarview').html($('#bayar').val());
            $('#jatuhtempoview').html($('#jatuhtempo').val());
            $('#keteranganview').html($('#keterangan').val());
            $('#loadpage').hide();           
            alertify.success('Detail Penjualan Berhasil Disimpan <br /> &nbsp;');
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

    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
    ///////////////////////////////////////////////////////

    function getBarang() {
        if ($('#in_barang').val() != '') {
            if ($('#in_barang').val() != '-') {
                var posisi;
                var ketemu = false;
                for (i = 0; i < barang.length; i++) {
                    if (barang[i][1].toUpperCase() == $('#in_barang').val().toUpperCase() || barang[i][2].toUpperCase() == $('#in_barang').val().toUpperCase()) {
                        posisi = i;
                        ketemu = true;
                    }
                }
                if (ketemu) {
                    $('#in_id_barang').val(barang[posisi][0]);
                    $('#in_kode_barang').val(barang[posisi][1]);
                    $('#in_harga_jual').val(toRp(barang[posisi][5]));
                    $('#in_nama_barang').val(barang[posisi][3]);
                    $('#in_stok_barang').val(barang[posisi][15]);
                } else {
                    $('#in_nama_barang').val('BARANG TIDAK ADA');
                    $('#in_harga_jual').val('');
                }
            } else {
                $('#in_nama_barang').val('BARANG TIDAK ADA');
                $('#in_harga_jual').val('');
            }
        } else {
            $('#in_id_barang').val('');
            $('#in_kode_barang').val('');
            $('#in_nama_barang').val('');
            $('#in_harga_jual').val('');
        }
    }

    function hitungGrandTotal() {
        
        var biayaKirim = toAngka($('#biayakirim').val());        
        var total = totalHarga + parseInt(biayaKirim); 
        $('#totalview').html(toRp(total)); 
    
        hitungKembali();

    }

    function updateHarga(element) {

        var total = $(element).val() == '' ? 0 : parseInt($(element).val());
        var hargaBarang = $(element).parent().next().children().val();
        var jumlahHarga = parseInt(hargaBarang) * parseInt(total);
        var stok = parseInt($(element).parent().prev().prev().children().next().next().val());

        if (total <= stok) {
            $(element).next().html($(element).val());

            $(element).parent().next().next().children().val(jumlahHarga);
            $(element).parent().next().next().children().next().html(toRp(jumlahHarga));

            totalHarga = 0;
            $('input[id="jumlah_harga[]"]').each(function() {
                totalHarga = parseInt(totalHarga) + parseInt($(this).val());
            });

            $('#subtotalview').html(toRp(totalHarga));
            $('#subtotal').val(totalHarga);
            hitungGrandTotal();
        } else {
            alertify.error('Stok tidak mencukupi <br /> &nbsp;');
            $(element).val(stok);
        }
    }

    function isiLunas() {
        var total = toAngka($('#totalview').html());
        if (total != '') {
            $('#bayar').val(toRp(total)); 
        }
    }

    function hitungJumlah() {
        var total = $('#in_banyak_barang').val() * ($('#in_harga_jual').val() == '' ? 0 : toAngka($('#in_harga_jual').val()));
        $('#in_jumlah_harga').val(toRp(total));
    }

    function hitungKembali() {
        var total = toAngka($('#totalview').html());
        var bayar = toAngka($('#bayar').val()); 
        var kembali = parseInt(bayar) - parseInt(total);
        if (kembali > 0) {
            $('#kembaliview').html(toRp(kembali));
        } else {
            $('#kembaliview').html(toRp(0));
        }
    }

    function hitungPajak() {

        var biayaKirim = $('#biayakirim').val();
        if (biayaKirim == '') {
            biayaKirim = 0;
        }

        var biayaLain = $('#biayalain').val();
        if (biayaLain == '') {
            biayaLain = 0;
        }

        var total = totalHarga + parseInt(biayaKirim) + parseInt(biayaLain);

        var totalPajak = 0;
        var pajak = $('#tbiayapajak').val();
        if (pajak != '') {
            pajak = parseInt($('#tbiayapajak').val());
            totalPajak = pajak * total / 100;
        } else {
            pajak = 0;
            totalPajak = 0;
        }

        $('#biayapajakview').html(toRp(totalPajak));
    }

    function cetakNota() {
        cetak('index.php?cetak=d218d389d7dfc4f77c3bc12b71a1a51b', idPenjualan);
    }
    
    function cetakSuratJalan(){
        printLaporan('index.php?cetak=e2e1677134e890a57cb4607abd42c37f', idPenjualan, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    }

    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART G - FUNGSI ADDROW///////////////////////////////
    ///////////////////////////////////////////////////////

    function addRow() {

        jumlahBarang = 0;
        data = new Array(limit);
        for (i = 0; i < 100; i++) {
            data[i] = new Array(100);
        }

        $('input[id="id_barang[]"]').each(function() {
            data[jumlahBarang] = $(this).val();
            jumlahBarang++;
        });

        var ketemu = false;
        for (i = 0; i <= jumlahBarang; i++) {
            if (data[i] == $('#in_id_barang').val()) {
                ketemu = true;
            }
        }

        if (ketemu) {
            alertify.error("Barang sudah terdapat pada tabel <br /> &nbsp;");
        } else if (parseInt($('#in_banyak_barang').val()) > parseInt($('#in_stok_barang').val())) {
            alertify.error('Stok tidak mencukupi <br /> &nbsp;');
        } else if ($('#in_nama_barang').val() == '') {
            alertify.error('Masukan kode barang <br /> &nbsp;');
            $('#in_barang').focus();
        } else if ($('#in_nama_barang').val() == 'BARANG TIDAK ADA') {
            alertify.error('Barang tidak ada pada database <br /> &nbsp;');
        } else if ($('#in_jumlah_harga').val() == 0) {
            alertify.error('Total Harga barang tidak boleh 0 <br /> &nbsp;');
        } else if ($('#in_jumlah_harga').val() == 'Rp. 0') {
            alertify.error('Total Harga barang tidak boleh 0 <br /> &nbsp;');
        } else if ($('#in_jumlah_harga').val() == '') {
            alertify.error('Total Harga barang tidak boleh 0 <br /> &nbsp;');
        } else if ($('#in_barang').val() == '') {
            alertify.error('Masukan kode barang <br /> &nbsp;');
        } else {
            var text = '<tr>';
            text += '<td align="center"></td>';
            text += '<td align="center"><input type="hidden" id="id_barang[]" value="' + $('#in_id_barang').val() + '"><input type="hidden" id="kode_barang[]" value="' + $('#in_kode_barang').val() + '"><input type="hidden" id="stok_barang[]" value="' + $('#in_stok_barang').val() + '">' + $('#in_kode_barang').val().toUpperCase() + '</td>';
            text += '<td>' + $('#in_nama_barang').val() + '</td>';
            text += '<td align="center"><input class="text" type="text" size="3" id="banyak_barang[]" value="' + $('#in_banyak_barang').val() + '" onkeyup="updateHarga(this);" onkeypress="return IsAngka(event);"><span class="v_in_banyak_barang" style="display: none">' + $('#in_banyak_barang').val() + '</span></td>';
            text += '<td align="center"><input type="hidden" id="harga_barang[]" value="' + toAngka($('#in_harga_jual').val()) + '"><span class="v_in_harga_jual">' + $('#in_harga_jual').val() + '</span></td>';
            text += '<td align="center"><input type="hidden" id="jumlah_harga[]" value="' + toAngka($('#in_jumlah_harga').val()) + '"><span id="v_in_jumlah_harga">' + $('#in_jumlah_harga').val() + '</span></td>';
            text += '<td align="center"><img src="asset/images/delete.png" onClick="eraseRow(this);"></td>';
            text += '</tr>';
            $('#content_table').append(text);

            totalHarga = 0;
            $('input[id="jumlah_harga[]"]').each(function() {
                totalHarga = parseInt(totalHarga) + parseInt($(this).val());
            });

            $('#subtotalview').html(toRp(totalHarga));
            $('#subtotal').val(totalHarga);
            isiNomer();
            hitungGrandTotal();

            $('#in_barang').val('').focus();
            $('#in_kode_barang').val('');
            $('#in_id_barang').val('');
            $('#in_nama_barang').val('');
            $('#in_banyak_barang').val('');
            $('#in_harga_barang').val('');
            $('#in_jumlah_harga').val('');
            $('#in_text_nama_barang').html('');
        }
    }

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

    function setKendaraan() {
        if ($('#iskirim').prop('checked') == true) {
            $('#tbiayakirim').show();
            $('#tdbiayakirim').show();
            $('#trkendaraan').show();
            $('#tdkendaraan').show();
            $('#kendaraan').show();
        } else {
            $('#tdbiayakirim').hide();
            $('#trkendaraan').hide(); 
            $('#biayakirim').val('Rp. 0');
        }
        hitungGrandTotal();
    }

    function getDropDownKendaraan(idselect, name, url, inkode) {
        datasend[0][97] = inkode;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: url,
            data: {myJson: datasend}
        }).success(function(response) {
            var reValue = "<select class='dropdownlist' id='" + name + "'>";
            var jumlahData = response.data[0].totalrow;
            if (jumlahData <= 0) {
                reValue += "<option>DATA NOT FOUND</option>"
            } else {
                for (i = 0; i < jumlahData; i++) {
                    reValue += "<option value='" + response.data[i].id_kendaraan + "'>" + response.data[i].nama + ' - ' + response.data[i].no_plat + "</option>";
                }
            }
            reValue += "</select>";
            $('#' + idselect).html(reValue);
        });
    }

    ///////////////////////////////////////////////////////
    //PART G - END/////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART H - FUNGSI POPUP//////////////////////////////// 
    ///////////////////////////////////////////////////////

    function showListPelanggan() {
        winRef = openWindow('index.php?page=34c364a07301067bee97a99b1904f43e');
    }

    function showListBarang() {
        winRef = openWindow('index.php?page=b55857d896af521ddadfc2a62e4a0b6a');
    }

    function getDataPelanggan(id, nama, alamat, kota) {
        $('#id_pelanggan').val(id);
        $('#nama_pelanggan').val(nama);
        $('#alamat_pelanggan').val(alamat);
        $('#tdnama_pelanggan').html(nama + '&nbsp;');
        $('#tdalamat_pelanggan').html(alamat + ', ' + kota);
    }

    function getDataBarang(id, kode, nama, harga, stok) {
        $('#in_id_barang').val(id);
        $('#in_kode_barang').val(kode);
        $('#in_barang').val(kode);
        $('#in_nama_barang').val(nama);
        $('#in_stok_barang').val(stok);
        $('#in_text_nama_barang').html(nama);
        $('#in_harga_jual').val(toRp(harga));
        $('#in_banyak_barang').focus();
    }

    function showFormPelanggan() {
        showListPelanggan();
        $('#trpelanggan').show();
    }

    function hapusPelanggan() {
        $('#id_pelanggan').val(0);
        $('#nama_pelanggan').val('');
        $('#alamat_pelanggan').val('');
        $('#tdnama_pelanggan').html('');
        $('#tdalamat_pelanggan').html('');
        $('#trpelanggan').hide();
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

<input type="hidden" id="id_pelanggan" value="0"/> 
<input type="hidden" id="nama_pelanggan" /> 
<input type="hidden" id="alamat_pelanggan" /> 

<table style="width:100%;" border="0" id="content_table2">
    <tr id="trpelangganradio">
        <td width="250px">
            <input type="radio" name="iscustomer" id="iscustomeryes" onclick="showFormPelanggan();" />Pelanggan 
            <input type="radio" name="iscustomer" id="iscustomerno" checked="checked" onclick="hapusPelanggan()"/>Cash / Non Pelanggan
        </td> 
    </tr>
    <tr>                 

    </tr>
    <tr>
        <td id="trpelanggan" width="80%"><span id="tdnama_pelanggan"></span> - <span id="tdalamat_pelanggan"></span></td>  
        <td align="right">
            Tanggal Penjualan : 
            <span id="tdtanggal"><input type="text" class="text" id="tanggal" name="itanggal" readonly="readonly" size="12" /></span>
            <span id="tanggalview">testp</span>
        </td>     
    </tr>
</table>

<hr />

<table id="forminputbarang">
    <tr>
        <td>
            <fieldset style="border:black 1px solid;padding:5px; font-size: 13px; padding:15px;">
                <legend>Input Barang</legend>

                <table id="content_table2">

                    <tr>
                        <td style="width:100px;">Kode Barang </td>
                        <td>
                            <input type="hidden" id="in_id_barang" /> 
                            <input type="hidden" id="in_kode_barang" /> 
                            <input type="hidden" id="in_stok_barang" /> 
                            <input type="text" class="text" id="in_barang" onkeypress="if (event.keyCode == 13) { $('#in_banyak_barang').focus(); }" onkeyup="getBarang();"/>
                        </td>  
                        <td>&nbsp;<span class="detail" onclick="showListBarang();" ></span></td>					

                        <td style="width:100px;">Nama Barang</td>					
                        <td><input type="text" class="text" id="in_nama_barang" size="50" readonly="readonly" /></td>    
                    </tr>

                    <tr>                    
                        <td>Jumlah</td>
                        <td><input type="text" class="text" id="in_banyak_barang" onkeypress="if (event.keyCode == 13) { addRow(); } return IsAngka(event);"  onkeyup="hitungJumlah();" /></td>
                        <td></td>		
                        <td>Harga</td>				
                        <td><input type="text" class="text" id="in_harga_jual" readonly="readonly" /></td> 
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>				
                        <td>Total </td>
                        <td><input type="text" class="text" id="in_jumlah_harga" readonly="readonly" /></td>
                    </tr>

                </table>

            </fieldset>
        </td>
    </tr>
</table>

<br/>

<table id="content_table" width="100%">
    <thead id="judul_tabel"></thead>
    <tbody id="isi_tabel"></tbody>       
</table>         

<br />   

<div id="tabel_bayar" >
    <table width="100%" id="content_table2" border="0">
        <tr>
            <td width="100">Subtotal</td>
            <td width="10">:</td>
            <td id="subtotalview">Rp. 0</td>
            <td id="tdsubtotal">
                <input id="subtotal" />                
            </td>             
        <td align="right" rowspan="5"><strong><span id="totalview">Rp. 0</span></strong></td>
        </tr>

        <tr id="trbiayakirim">
            <td>Biaya Kirim <input type="checkbox" id="iskirim" onclick="setKendaraan()"></td>
            <td>:</td>
            <td id="tdbiayakirim" style="display:none">                
                <input type="text" class="text" id="biayakirim" size="20" onkeypress="return IsAngka(event);""/>
            </td>
            <td id="biayakirimview">tes</td>
        </tr>

        <tr id="trkendaraan" style="display:none">
            <td>Kendaraan</td>
            <td>:</td>
            <td id="tdkendaraan">               
                <script type="text/javascript">getDropDownKendaraan('tdkendaraan', 'kendaraan', 'client/kendaraan/get_data_kendaraan.php', '1114')</script>
            </td>
            <td id="kendaraanview">tes</td>
        </tr> 	

        <tr>  
            <td>Bayar</td>
            <td>:</td>
            <td id="tdbayar">
                <input type="text" class="text" id="bayar" size="20" onkeypress="return IsAngka(event);" /> 
                <span class="tombol" onclick="isiLunas();">Lunas</span>
            </td>
            <td id="bayarview">tes</td>
        </tr>

        <tr>  
            <td>Kembali</td>
            <td>:</td>
            <td id="kembaliview">Rp. 0</td>
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

<div style="text-align: center;">	
    <span class='tombol' id="bbayar" onclick="entryValidate();">SIMPAN</span> 
    <span class='tombol' id="breset" value='Reset' onclick="clearForm();" >RESET</span> 
    <span class='tombol' id="bcetak" onclick="cetakNota()">CETAK</span> 
    <span class='tombol' id="bcetak2" onclick="cetakSuratJalan()">CETAK SURAT JALAN</span> 
</div>