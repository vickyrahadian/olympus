<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : pembelian.php                                                                                         *
 * DESC     : Digunakan untuk melakukan transaksi pembelian                                                         *
 * CREATED  : 14/1/2014                                                                                             *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Transaksi \u00BB Pembelian';
    var headerTitle = ['No', 'Kode Barang', 'Nama Barang', 'Jumlah', 'Harga Satuan', 'Total Harga'];
    var nomer = 1;
    var totalHarga = 0;
    var jumlahBarang = 0;
    var limit = 10;
    var barang;
    var idPembelian;

    var data = new Array(limit);
    for (i = 0; i < 100; i++) {
        data[i] = new Array(100);
    }

    var datasend = new Array(100);
    for (i = 0; i < 100; i++) {
        datasend[i] = new Array(100);
    }

    $(document).ready(function() {
        $('#jatuhtempo').val(getTodayDate());
        $('#tanggal').val(getTodayDate());
        $('#jatuhtempoview').html(getTodayDate());
        $('#tanggalview').html(getTodayDate());
        $('#subtotal').val(0);
        $('#biayakirim').val(0);
        $('#biayalain').val(0);
        $('#biayapajak').val(0);
        $('#total').val(0);
        $('#bayar').val(0);

        $(document).bind("keydown", disableF5);
        $(document).attr('title', title);
        $('#title').html(title);
        loadHeader(headerTitle);
        getAllBarang();
        unHiddenField();

        $('#tanggal').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        $('#jatuhtempo').datepick({
            dateFormat: 'dd/mm/yyyy'}
        );

        shortcut.add("F8", function() {
            showListBarang();
        });

        $('#tbiayakirim').blur(function() {
            if ($('#tbiayakirim').val() != '') {
                $('#biayakirim').val($('#tbiayakirim').val());
                $('#tbiayakirim').val(toRp($('#tbiayakirim').val()));
            } else {
                $('#tbiayakirim').val(0);
                $('#biayakirim').val($('#tbiayakirim').val());
                $('#tbiayakirim').val(toRp($('#tbiayakirim').val()));
            }
            hitungGrandTotal();
        });

        $('#tbiayakirim').focus(function() {
            if ($('#tbiayakirim').val() != '') {
                $('#tbiayakirim').val(toAngka($('#tbiayakirim').val()));
            }
        });

        $('#tbiayalain').blur(function() {
            if ($('#tbiayalain').val() != '') {
                $('#biayalain').val($('#tbiayalain').val());
                $('#tbiayalain').val(toRp($('#tbiayalain').val()));
            } else {
                $('#tbiayalain').val(0);
                $('#biayalain').val($('#tbiayalain').val());
                $('#tbiayalain').val(toRp($('#tbiayalain').val()));
            }
            hitungGrandTotal();
        });

        $('#tbiayapajak').focus(function() {
            if ($('#tbiayapajak').val() != '') {
                $('#tbiayapajak').val(toAngka($('#tbiayapajak').val()));
            }
        });

        $('#tbayar').blur(function() {
            if ($('#tbayar').val() != '') {
                $('#bayar').val($('#tbayar').val());
                $('#tbayar').val(toRp($('#tbayar').val()));
            }
        });

        $('#tbayar').focus(function() {
            if ($('#tbayar').val() != '') {
                $('#tbayar').val(toAngka($('#tbayar').val()));
            }
        });

        unHiddenField();
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
        datasend[0][97] = '1113';

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/barang/get_data_barang.php',
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
        $('#no_faktur').css('background-color', '');
        $('#no_faktur').val('');
        $('#id_pemasok').val('');
        $('#subtotal').val('');
        $('#biayakirim').val('');
        $('#biayalain').val('');
        $('#total').val('');
        $('#bayar').val('');
        $('#keterangan').val('');
        $('#tbiayakirim').val('');
        $('#tbiayalain').val('');
        $('#tbiayapajak').val('');
        $('#tbayar').val('');
        $('#in_barang').val('');
        $('#in_kode_barang').val('');
        $('#in_id_barang').val('');
        $('#in_nama_barang').val('');
        $('#in_banyak_barang').val('');
        $('#in_harga_jual').val('');
        $('#in_jumlah_harga').val('');
        $('#in_text_nama_barang').html('');

        $('#tdnama_pemasok').html('');
        $('#tdalamat_pemasok').html('');
        $('#subtotalview').html('Rp. 0,00');
        $('#totalview').html('<strong>Rp. 0,00</strong>');

        $('#jatuhtempo').val(getTodayDate());
        $('#tanggal').val(getTodayDate());
        $('#jatuhtempoview').html(getTodayDate());
        $('#tanggalview').html(getTodayDate());
        $('#subtotal').val(0);
        $('#biayakirim').val(0);
        $('#biayalain').val(0);
        $('#biayapajak').val(0);
        $('#biayapajakview').html('Rp. 0,00');
        $('#total').val(0);
        $('#bayar').val(0);

        $('#content_table tbody').html('');
        unHiddenField();
        loadHeader(headerTitle);
        totalHarga = 0;
    }

    function unHiddenField() {
        $('#trnonotapembelian').hide();
        $('#tdno_faktur').show();
        $('#no_fakturview').hide();
        $('#bshowListPemasok').show();
        $('#tdtanggal').show();
        $('#tanggalview').hide();
        $('#forminputbarang').show();
        $('#tdsubtotal').hide();
        $('#subtotalview').show();
        $('#tdbiayakirim').show();
        $('#biayakirimview').hide();
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
    }

    function hiddenField() {
        $('#trnonotapembelian').show();
        $('#tdno_faktur').hide();
        $('#no_fakturview').show();
        $('#bshowListPemasok').hide();
        $('#tdtanggal').hide();
        $('#tanggalview').show();
        $('#forminputbarang').hide();
        $('#tdsubtotal').hide();
        $('#subtotalview').show();
        $('#tdbiayakirim').hide();
        $('#biayakirimview').show();
        $('#tdbiayalain').hide();
        $('#biayalainview').show();
        $('#tbiayapajak').hide();
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
        noFaktur = $('#no_faktur').val();
        idPemasok = $('#id_pemasok').val();
        tanggal = $('#tanggal').val();
        reValue = false;

        subtotal = parseInt($('#subtotal').val());
        bkirim = $('#biayakirim').val() == '' ? 0 : parseInt($('#biayakirim').val());
        blain = $('#biayalain').val() == '' ? 0 : parseInt($('#biayalain').val());
        bpajak = parseInt(toAngka($('#biayapajakview').html()));
        total = parseInt($('#total').val());
        bayar = $('#bayar').val() == '' ? 0 : parseInt($('#bayar').val());

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
                } else {
                    reValue = true;
                }
            }
        }

        if (reValue) {

            datasend[0][3] = noFaktur;
            datasend[0][4] = subtotal;
            datasend[0][5] = bkirim;
            datasend[0][6] = blain;
            datasend[0][7] = bpajak;
            datasend[0][8] = total;
            datasend[0][9] = bayar;
            datasend[0][10] = subtotal + bkirim + blain + bpajak - bayar == 0 ? 1 : 0;
            datasend[0][11] = $('#keterangan').val();
            datasend[0][12] = idPemasok;
            datasend[0][13] = convertDateToDatabse($('#tanggal').val());
            datasend[0][14] = convertDateToDatabse($('#jatuhtempo').val());

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
            $('#biayakirimview').html(toRp($('#biayakirim').val()));
            $('#biayalainview').html(toRp($('#biayalain').val()));
            $('#biayapajakview').html($('#tbiayapajak').val() + ' % / ' + $('#biayapajakview').html());
            $('#bayarview').html(toRp($('#bayar').val()));
            $('#jatuhtempoview').html($('#jatuhtempo').val());
            $('#keteranganview').html($('#keterangan').val());
            $('#loadpage').hide();
            alertify.success('Detail Pembelian Berhasil Disimpan <br /> &nbsp;');
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

    function hitungJumlah() {
        var total = $('#in_banyak_barang').val() * $('#in_harga_barang').val();
        $('#in_harga_barang').val($('#in_harga_barang').val());
        $('#in_jumlah_harga').val(toRp(total));
    }

    function hitungGrandTotal() {

        hitungPajak();

        var biayaKirim = $('#biayakirim').val();
        if (biayaKirim == '') {
            biayaKirim = 0;
        }

        var biayaLain = $('#biayalain').val();
        if (biayaLain == '') {
            biayaLain = 0;
        }

        var biayaPajak = toAngka($('#biayapajakview').html());

        var bayarBayar = $('#bayar').val();
        if (bayarBayar == '') {
            bayarBayar = 0;
        }

        var total = totalHarga + parseInt(biayaKirim) + parseInt(biayaLain) + parseInt(biayaPajak);
        $('#totalview').html('<strong>' + toRp(total) + '</strong>');
        $('#total').val(total);
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
        $('#subtotal').val(totalHarga);
        hitungGrandTotal();
    }

    function isiLunas() {
        var total = $('#total').val();
        if (total != '') {
            $('#tbayar').val(toRp(total));
            $('#bayar').val(total);
        }
    }

    function hitungJumlah() {
        var total = $('#in_banyak_barang').val() * $('#in_harga_barang').val();
        $('#in_harga_barang').val($('#in_harga_barang').val());
        $('#in_jumlah_harga').val(toRp(total));
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
        cetak('index.php?cetak=1e04a1720c57aaa75b1d45eae45dfda8', idPembelian);
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

        ketemu = false;
        for (i = 0; i <= jumlahBarang; i++) {
            if (data[i] == $('#in_id_barang').val()) {
                ketemu = true;
            }
        }

        if (ketemu) {
            alertify.error("Barang sudah terdapat pada tabel <br /> &nbsp;");
        } else if ($('#in_nama_barang').val() == '') {
            alertify.error('Masukan kode barang <br /> &nbsp;');
            $('#in_barang').focus();
        } else if ($('#in_nama_barang').val() == 'BARANG TIDAK ADA') {
            alertify.error('Barang tidak ada pada database <br /> &nbsp;');
        } else if ($('#in_jumlah_harga').val() == 0) {
            alertify.error('Total Harga barang tidak boleh 0 <br /> &nbsp;');
        } else if ($('#in_jumlah_harga').val() == 'Rp. 0,00') {
            alertify.error('Total Harga barang tidak boleh 0 <br /> &nbsp;');
        } else if ($('#in_jumlah_harga').val() == '') {
            alertify.error('Total Harga barang tidak boleh 0 <br /> &nbsp;');
        } else if ($('#in_barang').val() == '') {
            alertify.error('Masukan kode barang <br /> &nbsp;');
        } else {
            var text = '<tr>';
            text += '<td align="center"></td>';
            text += '<td align="center"><input type="hidden" id="id_barang[]" value="' + $('#in_id_barang').val() + '"><input type="hidden" id="kode_barang[]" value="' + $('#in_kode_barang').val() + '">' + $('#in_kode_barang').val().toUpperCase() + '</td>';
            text += '<td>' + $('#in_nama_barang').val() + '</td>';
            text += '<td align="center"><input class="text" type="text" size="3" id="banyak_barang[]" value="' + $('#in_banyak_barang').val() + '" onkeyup="updateHarga(this);" onkeypress="return IsAngka(event);"><span class="v_in_banyak_barang" style="display:none">' + $('#in_banyak_barang').val() + '</span></td>';
            text += '<td align="center"><input class="text" type="text" size="15" id="harga_barang[]" value="' + toRp($('#in_harga_barang').val()) + '" onfocus="$(this).val(toAngka($(this).val()));" onblur="$(this).val(toRp($(this).val()));" onkeyup="updateHarga(this);" onkeypress="return IsAngka(event);"><span class="v_in_harga_barang" style="display:none">' + toRp($('#in_harga_barang').val()) + '</span></td>';
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

    ///////////////////////////////////////////////////////
    //PART G - END/////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    //PART H - FUNGSI POPUP//////////////////////////////// 
    ///////////////////////////////////////////////////////

    function showListPemasok() {
        winRef = openWindow('index.php?page=eef3ece3b25077f1449cdc39ebd87125');
    }

    function showListBarang() {
        winRef = openWindow('index.php?page=8bb19631b2135c1a4ca3b278b98805fe');
    }

    function getDataPemasok(id, nama, alamat) {
        $('#id_pemasok').val(id);
        $('#nama_pemasok').val(nama);
        $('#alamat_pemasok').val(alamat);
        $('#tdnama_pemasok').html(nama + '&nbsp;');
        $('#tdalamat_pemasok').html(alamat);
    }

    function getDataBarang(id, kode, nama, harga) {
        $('#in_id_barang').val(id);
        $('#in_kode_barang').val(kode);
        $('#in_barang').val(kode);
        $('#in_nama_barang').val(nama);
        $('#in_text_nama_barang').html(nama);
        $('#in_harga_jual').val(toRp(harga));
        $('#in_banyak_barang').focus();
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

<input type="hidden" id="id_pemasok" /> 
<input type="hidden" id="nama_pemasok" /> 
<input type="hidden" id="alamat_pemasok" /> 

<table style="width:100%;" border="0" id="content_table2">
    <tr id="trnonotapembelian">
        <td style="width:120px;">No Referensi</td>
        <td>:</td>
        <td id="nonotapembelianview">tesnp</td>        
    </tr>
    <tr>
        <td style="width:100px;">No Faktur</td>
        <td style="width:10px;">:</td>
        <td id="tdno_faktur"><input type="text" class="text" id="no_faktur" name="ino_faktur" /></td>
        <td id="no_fakturview">tesnf</td>
        <td align="right">
            Tanggal Pembelian : 
            <span id="tdtanggal"><input type="text" class="text" id="tanggal" name="itanggal" readonly="readonly" size="12" /></span>
            <span id="tanggalview">testp</span>
        </td>
    </tr>
    <tr>
        <td>Pemasok</td> 
        <td>:</td> 
        <td>
            <span id="tdnama_pemasok"></span> 
            <a href="#" id="bshowListPemasok" class="detail" onclick="showListPemasok();"></a>
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

<hr />

<table id="forminputbarang" style=";" border="0" >
    <tr>
        <td>
            <fieldset style="border:black 1px solid;padding:5px; font-size: 13px; padding:15px;">
                <legend>Input Barang</legend>

                <table id="content_table2" style="" border="0" >

                    <tr>
                        <td style="width:100px;">Kode Barang </td>

                        <td>
                            <input type="hidden" id="in_id_barang" /> 
                            <input type="hidden" id="in_kode_barang" /> 
                            <input type="text" class="text" id="in_barang" onkeypress="if (event.keyCode == 13) { $('#in_banyak_barang').focus(); }" onkeyup="getBarang();"/>
                        </td>  
                        <td>&nbsp;<a href="#" class="detail" onclick="showListBarang();"></a></td>					

                        <td style="width:100px;">Nama Barang</td>					
                        <td><input type="text" class="text" id="in_nama_barang" size="50" readonly="readonly" /></td>    

                    <tr>
                    </tr>	

                    <td>Jumlah Beli </td>
                    <td><input type="text" class="text" id="in_banyak_barang" onkeypress="if (event.keyCode == 13) { $('#in_harga_barang').focus(); } return IsAngka(event);" onkeyup="hitungJumlah();" /></td>
                    <td></td>		
                    <td>Harga Jual</td>				
                    <td><input type="text" class="text" id="in_harga_jual" readonly="readonly" /></td> 

                    <tr>
                    </tr>

                    <td>Harga Beli</td>
                    <td><input type="text" class="text" id="in_harga_barang" onkeypress="if (event.keyCode == 13) { addRow(); } return IsAngka(event);"  onkeyup="hitungJumlah();" /></td>
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
    <table width="100%" id="content_table2">
        <tr>
            <td width="100">Subtotal</td>
            <td width="10">:</td>
            <td id="subtotalview">Rp. 0,00</td>
            <td id="tdsubtotal">
                <input id="subtotal" />                
            </td>            
        <input type="hidden" id="total" />
        <td align="right" id="totalview" rowspan="6"><strong>Rp. 0,00</strong></td>
        </tr>

        <tr>
            <td>Biaya Kirim</td>
            <td>:</td>
            <td id="tdbiayakirim">
                <input type="hidden" id="biayakirim" size="20" onkeypress="return IsAngka(event);"  />
                <input type="text" class="text" id="tbiayakirim" size="20" onkeypress="return IsAngka(event);" onkeyup="hitungGrandTotal();"/>
            </td>
            <td id="biayakirimview">tes</td>
        </tr>

        <tr style="display:none">
            <td>Biaya Lain</td>
            <td>:</td>
            <td id="tdbiayalain">
                <input type="hidden" id="biayalain" size="20" onkeypress="return IsAngka(event);" />
                <input type="text" class="text" id="tbiayalain" size="20" onkeypress="return IsAngka(event);" />
            </td>                
            <td id="biayalainview">tes</td>
        </tr> 
        
        <tr style="display:none">
            <td>PPN (%)</td>
            <td>:</td>
            <td id="tdbiayapajak">
                <input type="text" class="text" id="tbiayapajak" size="20" onkeyup="hitungGrandTotal();" onkeypress="return IsAngka(event);" />
                <span id="biayapajakview">Rp. 0,00</span>
            </td>                 
        </tr>		

        <tr>  
            <td>Bayar</td>
            <td>:</td>
            <td id="tdbayar">
                <input type="hidden" id="bayar" size="20"/> 
                <input type="text" class="text" id="tbayar" size="20" onkeypress="return IsAngka(event);" /> 
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
<div style="text-align: center;">

    <span class='tombol' id="bbayar" onclick="entryValidate();">SIMPAN</span> 
    <span class='tombol' id="breset" value='Reset' onclick="clearForm();" >RESET</span> 
    <span class='tombol' id="bcetak" onclick="cetakNota();">CETAK</span> 

</div>
