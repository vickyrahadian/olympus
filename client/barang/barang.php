<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : barang.php                                                                                            *
 * DESC     : Digunakan untuk melakukan CRUD pada master data barang                                                *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Master \u00BB Barang';
    var headerTitle = ['No', 'Kode Barang', 'Nama Barang', 'Satuan', 'Harga Jual', 'Kategori', 'Stok'];
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

    var namaTempGambar = '';
    var namaTempGambar2 = '';

    $(document).ready(function() {
        $(document).attr('title', title);
        $('#title').html(title);

        loadHeader(headerTitle);
        sendReq(1, '1111');

        $('#fgambar').on('change', function() {
            $("#forminputs").vPB({
                url: 'client/barang/get_barang_upload_image.php',
                beforeSubmit: function()
                {
                    $("#spangambar").show();
                    $("#spangambar").html('');
                    $("#spangambar").html('<div style="font-family: Verdana, Geneva, sans-serif; font-size:12px; color:black;">'
                            + '<br /><br />'
                            + 'Upload '
                            + '<img src="asset/images/loadings.gif" alt="Upload...." title="Upload...."/>'
                            + '</div>');

                },
                success: function(response)
                {
                    namaTempGambar = response;

                    if (response == '1') {
                        $("#spangambar").show().html('<br /><br />Error, Gambar tidak boleh lebih dari 1 MB');
                    } else {
                        $("#spangambar").show().html('<br /><br /><img width="100px" src="asset/images/temp/' + namaTempGambar + '" />');
                        $("#spangambardelete").show();
                    }
                }
            }).submit();
        });
        
        shortcut.add("F8", function() {
            showInputForm();
        });
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
            url: 'client/barang/get_data_barang.php',
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

                    data[i][0] = response.data[i].id_barang;
                    data[i][1] = response.data[i].kode;
                    data[i][2] = response.data[i].barcode;
                    data[i][3] = response.data[i].nama;
                    data[i][4] = response.data[i].id_satuan;
                    data[i][5] = response.data[i].harga_ecer;
                    data[i][6] = response.data[i].stok_terjual;
                    data[i][7] = response.data[i].id_kategori;
                    data[i][8] = response.data[i].namakategori;
                    data[i][10] = response.data[i].namasatuan;
                    data[i][12] = response.data[i].gambar;
                    data[i][13] = response.data[i].stok;
                    data[i][14] = response.data[i].harga_beli;

                    //tabel standar field
                    data[i][93] = response.data[i].status;
                    data[i][94] = response.data[i].createddate;
                    data[i][95] = response.data[i].createdby;
                    data[i][96] = response.data[i].updateddate;
                    data[i][97] = response.data[i].updatedby;

                    //dont change this is for pagination
                    data[i][98] = response.data[i].totalrow;
                    data[i][99] = response.data[i].totaldata;
                }
                totalHalaman = Math.ceil((parseInt(data[0][99]) / limit));
                $('#isi_tabel').html(fillTable(data));
                $('#pagination').html(fillPagination(hal, totalHalaman));
                $('#sendKode').val(kode);
                setRadioButton(kode);
            }
        });
    }

    function getDropDownSatuan(idselect, name, url, inkode) {
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
                    reValue += "<option value='" + response.data[i].id_barangsatuan + "'>" + response.data[i].nama + "</option>";
                }
            }
            reValue += "</select>";

            $('#' + idselect).html(reValue);
        });
    }

    function getDropDownKategori(idselect, name, url, inkode) {
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
                    reValue += "<option value='" + response.data[i].id_barangkategori + "'>" + response.data[i].nama + "</option>";
                }
            }
            reValue += "</select>";
            $('#' + idselect).html(reValue);
        });
    }

    ///////////////////////////////////////////////////////
    // PART B - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART C - PENGATURAN FORM ///////////////////////////
    ///////////////////////////////////////////////////////

    function clearForm() {
        $('#id').val('');
        $('#barcode').val('');
        $('#barcode').css('background-color', '');
        $('#nama').val('');
        $('#nama').css('background-color', '');
        $('#harga').val('');
        $('#harga').css('background-color', '');
        $('#fgambar').val('');
        $('#spangambar').hide();
        $('#spangambardelete').hide();
        namaTempGambar = '';

        $(".dropdownlist").prop('selectedIndex', 0);
        $('#teks_cari').val('');
        $('#teks_cari').css('background-color', '');
    }

    function gridView(id) {
        hiddenField();
        $('#kodeview').html(data[id][1]);
        $('#barcodeview').html(data[id][2] == '0' ? '-' : data[id][2]);
        $('#namaview').html(data[id][3]);
        $('#satuanview').html(data[id][10]);
        $('#hargaview').html(toRp(data[id][5]));
        $('#kategoriview').html(data[id][8]);
        $('#stokview').html(data[id][13]);
        $('#gambarview').html(data[id][12] == '' ? '<img src="asset/images/ina.jpg" height="125px"/>' : ('<br /><img src="asset/images/barang/' + data[id][12] + '" height="125px" /><br /><br />'));
        if ($('#forminput').css('display') == 'none') {
            toggleForm('forminput');
        }
        $('#bsimpan').hide();
        $('#breset').hide();

        $('#content_table').show();
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

    function showInputForm() {
        unHiddenField();
        if ($('#forminput').css('display') == 'none') {
            toggleForm('forminput');
        }
        clearForm();
        $('#formtype').val('INS');
        $('#bsimpan').show();
        $('#breset').show();
    }

    function showEditForm(id) {
        unHiddenField();
        if ($('#forminput').css('display') == 'none') {
            toggleForm('forminput');
        }
        clearForm();
        $('#formtype').val('UPD');
        $('#id').val(data[id][0]);
        $('#bsimpan').show();
        $('#breset').hide();

        $('#kode').val(data[id][1]);
        $('#barcode').val(data[id][2]);
        $('#nama').val(data[id][3]);
        $('#harga').val(toRp(data[id][5]));
        $('#satuan').val(data[id][4]);
        $('#kategori').val(data[id][7]);
        namaTempGambar = data[id][12];
        namaTempGambar2 = data[id][12];

        if (data[id][12] == '') {
            $("#spangambar").show().html('<br /><br /><img width="100px" src="asset/images/ina.jpg" />');
        } else {
            $("#spangambar").show().html('<br /><br /><img width="100px" src="asset/images/barang/' + data[id][12] + '" />');
            $("#spangambardelete").show();
        }

        $('#content_table').show();
    }

    function hiddenField() {
        $('#trkode').show();
        $('#tdkode').hide();
        $('#kodeview').show();
        $('#tdbarcode').hide();
        $('#barcodeview').show();
        $('#tdnama').hide();
        $('#namaview').show();
        $('#tdsatuan').hide();
        $('#satuanview').show();
        $('#tdharga').hide();
        $('#hargaview').show();
        $('#tdkategori').hide();
        $('#kategoriview').show();
        $('#trstok').show();
        $('#tdgambar').hide();
        $('#gambarview').show();
    }

    function unHiddenField() {
        $('#trkode').hide();
        $('#tdkode').show();
        $('#kodeview').hide();
        $('#tdbarcode').show();
        $('#barcodeview').hide();
        $('#tdnama').show();
        $('#namaview').hide();
        $('#tdsatuan').show();
        $('#satuanview').hide();
        $('#tdharga').show();
        $('#hargaview').hide();
        $('#tdkategori').show();
        $('#kategoriview').hide();
        $('#trstok').hide();
        $('#tdgambar').show();
        $('#gambarview').hide();
    }

    function simpleSearch(event) {
        if(event.keyCode === 13){
            datasend[0][96] = $('#teks_cari').val();

            if ($('#tabel_aktif').is(':checked')) {
                kode = '5555';
            } else {
                kode = '5556';
            }

            sendReq(1, kode);
        }
    }

    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
    ///////////////////////////////////////////////////////

    function entryValidate() {
        var formType = $('#formtype').val();
        var reValue = true;

        if ($('#nama').val() == "") {
            $('#nama').css('background-color', 'yellow');
            reValue = false;
        }

        if ($('#harga').val() == "") {
            $('#harga').css('background-color', 'yellow');
            reValue = false;
        }

        if (reValue == false) {
            alertify.error("Silahkan koreksi field yang berwarna kuning <br /> &nbsp;");
        } else {
            datasend[0][3] = $('#barcode').val();
            datasend[0][4] = $('#nama').val();
            datasend[0][5] = toAngka($('#harga').val());
            datasend[0][7] = $('#kategori').val();
            datasend[0][8] = $('#satuan').val();
            datasend[0][10] = namaTempGambar;

            if ((namaTempGambar != '') && (namaTempGambar != namaTempGambar2)) {
                moveFile(namaTempGambar, 'asset/images/temp/', 'asset/images/barang/');
            }

            if (formType == "INS") {
                sendReq(1, '4444');
                clearForm();
                toggleForm('forminput');
                alertify.success('Data barang baru berhasil disimpan <br /> &nbsp;');
            } else if (formType == "UPD") {
                sendReq(1, '2222');
                clearForm();
                toggleForm('forminput');
                alertify.success('Data barang berhasil diubah <br /> &nbsp;');
            }
            kode = 1111;
        }
    }

    function gridDelete(id) {
        $('#forminput').hide();
        alertify.confirm('Anda yakin akan menghapus data ' + data[id][3] + ' ? <br /> &nbsp;', function(e) {
            if (e) {
                alertify.success('Data ' + data[id][3] + ' telah dihapus <br /> &nbsp;');
                clearForm();
                $('#id').val(data[id][0]);
                kode = '3333';
                sendReq(1, '3333');
            }
        });
    }

    function gridActivate(id) {
        alertify.confirm('Anda yakin akan mengaktifkan data ' + data[id][3] + ' ? <br /> &nbsp;', function(e) {
            if (e) {
                $('#id').val(data[id][0]);
                kode = '7777';
                sendReq(1, '7777');
            }
        });
    }

    ///////////////////////////////////////////////////////
    // PART D - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART E - PENGATURAN TABEL///////////////////////////
    ///////////////////////////////////////////////////////

    function changeTableType() {
        $('#forminput').hide();

        if ($('#tabel_aktif').is(':checked')) {
            kode = '1111';
        } else if ($('#tabel_tidak_aktif').is(':checked')) {
            kode = '1112';
        }

        sendReq(1, kode);
    }

    function loadHeader(titles) {
        var title = "<tr>";
        for (i = 0; i < titles.length; i++) {
            title += "<th>" + titles[i] + "</th>";
        }
        title += "<th>Aksi</th>";
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
            reValueTable += '<td align="center" width="130">' + data[j][1] + '</td>';
            reValueTable += '<td>' + data[j][3] + '</td>';
            reValueTable += '<td align="center">' + data[j][10] + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][5]) + '</td>';
            reValueTable += '<td align="center">' + data[j][8] + '</td>';
            reValueTable += '<td align="center">' + data[j][13] + '</td>';
            reValueTable += '<td align="center"><a href="#" class="detail" onclick="gridView(' + j + ')"></a> ';

            if (kode == '1112' || kode == '5556' || kode == '7777') {
                reValueTable += '<a href="#" class="aktifkan" onclick="gridActivate(' + j + ')"></a></td> ';
            } else {
                reValueTable += '<a href="#" class="update" onclick="showEditForm(' + j + ');"></a> ';
                reValueTable += '<a href="#" class="delete" onclick="gridDelete(' + j + ')"></a>';
            }
            reValueTable += '</td></tr>';
            i++;
        }

        return reValueTable
    }

    function pagingCLick(hal) {
        sendReq(hal, kode);
    }

    function setRadioButton(kode) {
        if (kode == '1111' || kode == '5555' || kode == '2222' || kode == '4444') {
            $('#tabel_aktif').prop('checked', true);
        } else if (kode == '1112' || kode == '5556') {
            $('#tabel_tidak_aktif').prop('checked', true);
        }
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

    function deleteImagePreview() {
        $('#fgambar').val('');
        $('#spangambar').hide();
        $('#spangambardelete').hide();
        namaTempGambar = '';
    }

    function moveFile(namaFile, lokasiAwal, lokasiPindah) {

        datasend[0][0] = namaFile;
        datasend[0][1] = lokasiAwal;
        datasend[0][2] = lokasiPindah;

        $.ajax({
            type: 'post',
            cache: false,
            url: 'asset/php/fungsi/movefile.php',
            data: {myJson: datasend}
        })
                .success(function(response) {
                    if (response != 1) {
                        alert('failed');
                    }
                });
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
    <form id="forminputs" method="post" enctype="multipart/form-data">

        <table id="content_form" style="width: 100%;">                    
            <tr id="trkode">
                <td>Kode Barang</td>
                <td id="tdkode"><input type="text" id="kode" class="text" value="" size="30" readonly="readonly" /></td>
                <td id="kodeview" style="display: none;"></td>
            </tr> 

            <tr>
                <td style="width: 100;">No Barcode</td>
                <td id="tdbarcode"><input type="text" id="barcode" class="text" value="" size="30" onkeypress="" /></td>
                <td id="barcodeview" style="display: none;"></td>
            </tr> 

            <tr>
                <td>Nama Barang</td>
                <td id="tdnama"><input type="text" id="nama" class="text" value="" size="50" /></td>
                <td id="namaview" style="display: none;"></td>
            </tr> 

            <tr>
                <td>Satuan</td>
                <td id="tdsatuan">
                    <script type="text/javascript">getDropDownSatuan('tdsatuan', 'satuan', 'client/barang_satuan/get_data_barang_satuan.php', '1114')</script>                    
                </td>
                <td id="satuanview" style="display: none;"></td>
            </tr> 

            <tr>
                <td>Harga Ecer</td>
                <td id="tdharga"><input type="text" id="harga" class="text" value="" size="20" onkeypress="return IsAngka(event);" onblur="changeToRp(this)" onfocus="changeToAngka(this)"/></td>
                <td id="hargaview" style="display: none;"></td>
            </tr> 

            <tr>
                <td>Kategori</td>
                <td id="tdkategori">
                    <script type="text/javascript">getDropDownKategori('tdkategori', 'kategori', 'client/barang_kategori/get_data_barang_kategori.php', '1114')</script>
                </td>
                <td id="kategoriview" style="display: none;"></td>
            </tr> 

            <tr id="trstok">
                <td>Stok</td>
                <td id="stokview"></td>
            </tr>

            <tr>
                <td>Gambar</td>
                <td id="tdgambar">
                    <input type="file" name="fgambar" id="fgambar"  />
                    <span id="spangambar"><br /></span>
                    <span id="spangambardelete">
                        <img src="asset/images/delete_2.png" width="15" onclick="deleteImagePreview();"/>
                    </span>
                </td>
                <td id="gambarview" style="display: none;"></td>
            </tr> 

            <tr>
                <td colspan="2" align="center" style="padding:15px;">

                    <span class='tombol' id="bsimpan" onclick="entryValidate();">SIMPAN</span> 
                    <span class='tombol' id="breset" value='Reset' onclick="clearForm();" >RESET</span> 
                    <span class='tombol' value='Tutup' onclick="toggleForm('forminput')" >TUTUP</span> 

                </td>
            </tr>
        </table>

    </form>
</div>

<!--div cari-->
<div id="top_command">
    <div id="cari">
        Cari Barang : 
        <input type="text" id="teks_cari" class="text" value="" size="30" onkeypress="simpleSearch(event)" />  

        Status : 
        <input type="radio" name="select_tabel" onclick="changeTableType();" id="tabel_aktif" />Aktif
        <input type="radio" name="select_tabel" onclick="changeTableType();" id="tabel_tidak_aktif" />Tidak Aktif 
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

<a href="#" class="back" onclick="resetTable();">Reset Tabel</a> | <a href="#" class="tambah" onclick='showInputForm();'>Tambah</a>