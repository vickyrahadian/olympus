<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : pemasok.php                                                                                           *
 * DESC     : Digunakan untuk melakukan CRUD pada master data pemasok                                               *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Master \u00BB Pemasok';
    var headerTitle = ['No', 'Kode', 'Nama', 'Nama Kontak', 'Kota', 'Telepon'];

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

        shortcut.add("F8", function() {
            showInputForm();
        });

        $('#fgambar').on('change', function() {
            $("#forminputs").vPB({
                url: 'client/pemasok/get_pemasok_upload_image.php',
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
            url: 'client/pemasok/get_data_pemasok.php',
            data: {myJson: datasend},
            beforeSend: function() {
                $('#loading').show();
            },
            complete: function() {
                $('#loading').hide();
            }
        })
                .success(function(response) {
                    var jumlahData = response.data[0].totalrow;
                    if (jumlahData <= 0) {
                        $('#isi_tabel').html('');
                        $('#pagination').html(fillPagination(1, 1));
                    } else {
                        for (i = 0; i < jumlahData; i++) {
                            data[i][0] = response.data[i].id_pemasok;
                            data[i][1] = response.data[i].nama;
                            data[i][2] = response.data[i].kontak;
                            data[i][3] = response.data[i].alamat;
                            data[i][4] = response.data[i].kota;
                            data[i][5] = response.data[i].telepon;
                            data[i][6] = response.data[i].gambar;
                            data[i][7] = response.data[i].kodepos;
                            data[i][8] = response.data[i].fax;
                            data[i][9] = response.data[i].email;
                            data[i][10] = response.data[i].website;
                            data[i][11] = response.data[i].kode;

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

    ///////////////////////////////////////////////////////
    // PART B - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART C - PENGATURAN FORM ///////////////////////////
    ///////////////////////////////////////////////////////

    function gridView(id) {
        hiddenField();
        $('#namaview').html(data[id][1]);
        $('#kontakview').html(data[id][2]);
        $('#alamatview').html(data[id][3]);
        $('#kotaview').html(data[id][4]);
        $('#teleponview').html(data[id][5]);
        $('#kodeposview').html(data[id][7]);
        $('#faxview').html(data[id][8]);
        $('#emailview').html(data[id][9]);
        $('#websiteview').html(data[id][10]);
        $('#kodeview').html(data[id][11]);
        $('#gambarview').html(data[id][6] == '' ? '<img src="asset/images/ina.jpg" height="125px"/>' : ('<br/ ><img width="100px" src="asset/images/pemasok/' + data[id][6] + '" /><br /><br />'));


        if ($('#forminput').css('display') == 'none') {
            toggleForm('forminput');
        }
        $('#bsimpan').hide();
        $('#breset').hide();

        $('#content_table').show();
    }

    function simpleSearch() {

        datasend[0][96] = $('#teks_cari').val();

        if ($('#tabel_aktif').is(':checked')) {
            kode = '5555';
        } else {
            kode = '5556';
        }

        sendReq(1, kode);

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

        $('#nama').val(data[id][1]);
        $('#kontak').val(data[id][2]);
        $('#alamat').val(data[id][3]);
        $('#kota').val(data[id][4]);
        $('#telepon').val(data[id][5]);
        $('#kodepos').val(data[id][7]);
        $('#fax').val(data[id][8]);
        $('#email').val(data[id][9]);
        $('#website').val(data[id][10]);
        namaTempGambar = data[id][6];
        namaTempGambar2 = data[id][6];

        if (data[id][6] == '') {
            $("#spangambar").show().html('<br /><br /><img width="100px" src="asset/images/ina.jpg" />');
        } else {
            $("#spangambar").show().html('<br /><br /><img width="100px" src="asset/images/pemasok/' + data[id][6] + '" />');
            $("#spangambardelete").show();
        }

        $('#content_table').show();

    }

    function clearForm() {
        $('#id').val('');
        $('#nama').val('');
        $('#nama').css('background-color', '');
        $('#kontak').val('');
        $('#kontak').css('background-color', '');
        $('#alamat').val('');
        $('#alamat').css('background-color', '');
        $('#kodepos').val('');
        $('#kodepos').css('background-color', '');
        $('#kota').val('');
        $('#kota').css('background-color', '');
        $('#telepon').val('');
        $('#telepon').css('background-color', '');
        $('#fax').val('');
        $('#fax').css('background-color', '');
        $('#email').val('');
        $('#email').css('background-color', '');
        $('#website').val('');
        $('#website').css('background-color', '');
        $('#fgambar').val('');
        $('#spangambar').hide();
        $('#spangambardelete').hide();
        namaTempGambar = '';

        $('#teks_cari').val('');
        $('#teks_cari').css('background-color', '');
    }

    function hiddenField() {
        $('#trkode').show()
        $('#tdnama').hide();
        $('#namaview').show();
        $('#tdkontak').hide();
        $('#kontakview').show();
        $('#tdalamat').hide();
        $('#alamatview').show();
        $('#tdkota').hide();
        $('#kotaview').show();
        $('#tdtelepon').hide();
        $('#teleponview').show();
        $('#tdfax').hide();
        $('#faxview').show();
        $('#tdkodepos').hide();
        $('#kodeposview').show();
        $('#tdemail').hide();
        $('#emailview').show();
        $('#tdwebsite').hide();
        $('#websiteview').show();
        $('#tdgambar').hide();
        $('#gambarview').show();
    }

    function unHiddenField() {
        $('#trkode').hide()
        $('#tdnama').show();
        $('#namaview').hide();
        $('#tdkontak').show();
        $('#kontakview').hide();
        $('#tdalamat').show();
        $('#alamatview').hide();
        $('#tdkota').show();
        $('#kotaview').hide();
        $('#tdtelepon').show();
        $('#teleponview').hide();
        $('#tdfax').show();
        $('#faxview').hide();
        $('#tdkodepos').show();
        $('#kodeposview').hide();
        $('#tdemail').show();
        $('#emailview').hide();
        $('#tdwebsite').show();
        $('#websiteview').hide();
        $('#tdgambar').show();
        $('#gambarview').hide();
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

        if ($('#kontak').val() == "") {
            $('#kontak').css('background-color', 'yellow');
            reValue = false;
        }

        if ($('#alamat').val() == "") {
            $('#alamat').css('background-color', 'yellow');
            reValue = false;
        }

        if ($('#kota').val() == "") {
            $('#kota').css('background-color', 'yellow');
            reValue = false;
        }

        if ($('#kodepos').val() == "") {
            $('#kodepos').css('background-color', 'yellow');
            reValue = false;
        }

        if ($('#telepon').val() == "") {
            $('#telepon').css('background-color', 'yellow');
            reValue = false;
        }

        if ($('#email').val() != '') {
            if (!echeck($('#email').val())) {
                $('#email').css('background-color', 'yellow');
                alertify.error("Alamat email tidak valid<br /> &nbsp;");
                reValue = false;
            }
        }

        if (reValue == false) {
            alertify.error("Silahkan koreksi field yang berwarna kuning <br /> &nbsp;");
        } else {
            datasend[0][3] = $('#nama').val();
            datasend[0][4] = $('#kontak').val();
            datasend[0][5] = $('#alamat').val();
            datasend[0][6] = $('#kota').val();
            datasend[0][7] = $('#kodepos').val();
            datasend[0][8] = $('#telepon').val();
            datasend[0][9] = $('#fax').val();
            datasend[0][10] = $('#email').val();
            datasend[0][11] = $('#website').val();
            datasend[0][12] = namaTempGambar;

            if ((namaTempGambar != '') && (namaTempGambar != namaTempGambar2)) {
                moveFile(namaTempGambar, 'asset/images/temp/', 'asset/images/pemasok/');
            }

            if (formType == "INS") {
                sendReq(1, '4444');
                clearForm();
                toggleForm('forminput');
                alertify.success('Data pemasok baru berhasil disimpan <br /> &nbsp;');
            } else if (formType == "UPD") {
                sendReq(1, '2222');
                clearForm();
                toggleForm('forminput');
                alertify.success('Data pemasok berhasil diubah <br /> &nbsp;');
            }
            kode = 1111;
        }
    }

    function gridDelete(id) {
        $('#forminput').hide();
        alertify.confirm('Anda yakin akan menghapus data ' + data[id][1] + ' ? <br /> &nbsp;', function(e) {
            if (e) {
                alertify.success('Data ' + data[id][1] + ' telah dihapus <br /> &nbsp;');
                clearForm();
                $('#id').val(data[id][0]);
                kode = '3333';
                sendReq(1, '3333');
            }
        });
    }

    function gridActivate(id) {
        alertify.confirm('Anda yakin akan mengaktifkan data ' + data[id][1] + ' ? <br /> &nbsp;', function(e) {
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
            reValueTable += '<td align="center">' + data[j][11] + '</td>';
            reValueTable += '<td>' + data[j][1] + '</td>';
            reValueTable += '<td>' + data[j][2] + '</td>';
            reValueTable += '<td align="center">' + data[j][4] + '</td>';
            reValueTable += '<td align="center">' + data[j][5] + '</td>';
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

    function changeTableType() {
        $('#forminput').hide();

        if ($('#tabel_aktif').is(':checked')) {
            kode = '1111';
        } else if ($('#tabel_tidak_aktif').is(':checked')) {
            kode = '1112';
        }

        sendReq(1, kode);
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

    function deleteImagePreview() {
        $('#fgambar').val('');
        $('#spangambar').hide();
        $('#spangambardelete').hide();
        namaTempGambar = '';
    }

    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

</script>

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

        <table id="content_form" width="100%" border="0">                    
            <tr id="trkode">
                <td>Kode Pemasok</td> 
                <td colspan="3" id="kodeview" colspan="3"></td>
            </tr>   

            <tr>
                <td>Nama Pemasok</td>
                <td id="tdnama" colspan="3"><input type="text" id="nama" class="text" value="" size="30"/></td>
                <td colspan="3" id="namaview" colspan="3" ></td>
            </tr> 

            <tr>
                <td width="10%">Nama Kontak</td>
                <td width="40%" id="tdkontak"><input type="text" id="kontak" class="text" value="" size="30"/></td>
                <td width="40%" id="kontakview" ></td>

                <td width="10%">Telepon</td>
                <td width="40%" id="tdtelepon"><input type="text" id="telepon" class="text" value="" size="30"/></td>
                <td width="40%" id="teleponview" ></td>
            </tr>

            <tr>
                <td>Alamat</td>
                <td id="tdalamat"><input type="text" id="alamat" class="text" value="" size="50"/></td>
                <td id="alamatview" ></td>

                <td>Fax</td>
                <td id="tdfax"><input type="text" id="fax" class="text" value="" size="30"/></td>
                <td id="faxview" ></td>
            </tr>

            <tr>
                <td>Kota</td>
                <td id="tdkota"><input type="text" id="kota" class="text" value="" size="30"/></td>
                <td id="kotaview" ></td>

                <td>Email</td>
                <td id="tdemail"><input type="text" id="email" class="text" value="" size="30"/></td>
                <td id="emailview" ></td>
            </tr>

            <tr>
                <td>Kode Pos</td>
                <td id="tdkodepos"><input type="text" id="kodepos" class="text" value="" size="15"/></td>
                <td id="kodeposview" ></td>

                <td>Website</td>
                <td id="tdwebsite"><input type="text" id="website" class="text" value="" size="30"/></td>
                <td id="websiteview" ></td>
            </tr>

            <tr>
                <td>Gambar</td>
                <td id="tdgambar" colspan="3">
                    <input type="file" name="fgambar" id="fgambar"  />
                    <span id="spangambar"><br /></span>
                    <span id="spangambardelete">
                        <img src="asset/images/delete_2.png" width="15" onclick="deleteImagePreview();"/>
                    </span>
                </td>
                <td id="gambarview" colspan="3"></td>
            </tr> 

            <tr>
                <td colspan="4" align="center" style="padding:15px;">

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
        Cari Pemasok : 
        <input type="text" id="teks_cari" class="text" value="" size="30" onkeypress="if (event.keyCode == 13) {
                    simpleSearch();
                }" />  

        Status : 
        <input type="radio" name="select_tabel" onclick="changeTableType();" id="tabel_aktif" />Aktif
        <input type="radio" name="select_tabel" onclick="changeTableType();" id="tabel_tidak_aktif" />Tidak Aktif 
    </div>
    <div id="loading" style="display: none;">
        <img src="asset/images/299.png" /> 
    </div>
</div>

<div id="datagrid">
    <table width='100%' id='content_table'>
        <thead id="judul_tabel"></thead>
        <tbody id="isi_tabel"></tbody>
    </table>        

    <br />

    <p align="right" id="pagination">
    </p>
</div>

<a href="#" class="back" onclick="resetTable();">Reset Tabel</a>
| 
<a href="#" class="tambah" onclick='showInputForm();'>Tambah</a>