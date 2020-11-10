<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : kendaraan.php                                                                                     *
 * DESC     : Digunakan untuk melakukan CRUD pada master data kendaraan                                      *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION : -                                                                                                     *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////

    var title = 'Master \u00BB Kendaraan';
    var headerTitle = ['No', 'Nama', 'No Plat'];

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
        sendReq(1, '1111');
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
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;

        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/kendaraan/get_data_kendaraan.php',
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
                    data[i][0] = response.data[i].id_kendaraan;
                    data[i][1] = response.data[i].nama;
                    data[i][2] = response.data[i].no_plat;

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

    function clearForm() {
        $('#id').val('');
        $('#nama').val('');
        $('#nama').css('background-color', '');
        $('#no_plat').val('');
        $('#no_plat').css('background-color', '');
        $('#teks_cari').val('');
        $('#teks_cari').css('background-color', '');
    }

    function gridView(id) {
        hiddenField();
        $('#namaview').html(data[id][1]);
        $('#no_platview').html(data[id][2]);
        if ($('#forminput').css('display') == 'none') {
            toggleForm('forminput');
        }
        $('#bsimpan').hide();
        $('#breset').hide();
    }

    function hiddenField() {
        $('#tdnama').hide()
        $('#tdno_plat').hide()
        $('#namaview').show();
        $('#no_platview').show();
    }

    function unHiddenField() {
        $('#tdnama').show();
        $('#tdno_plat').show();
        $('#namaview').hide();
        $('#no_platview').hide();
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
        $('#no_plat').val(data[id][2]);
    }

    function simpleSearch() {

        datasend[0][96] = $('#teks_cari').val();

        if ($('#tabel_aktif').is(':checked')) {
            kode = '5555';
        } else {
            kode = '5556';
        }

        sendReq(1, kode);
        $('#teks_cari').css('background-color', '');

    }

    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
    ///////////////////////////////////////////////////////

    function entryValidate() {
        var formType = $('#formtype').val();
        var reValue = false;

        if ($('#nama').val() == "") {
            $('#nama').css('background-color', 'yellow');
            reValue = false;
        } else {
            reValue = true;
        }
        
        if ($('#no_plat').val() == "") {
            $('#no_plat').css('background-color', 'yellow');
            reValue = false;
        } else {
            reValue = true;
        }

        if (reValue == false) {
            alertify.error('Silahkan koreksi field yang berwarna kuning <br /> &nbsp;');
        } else {
            datasend[0][3] = $('#nama').val();
            datasend[0][4] = $('#no_plat').val();

            if (formType == "INS") {
                sendReq(1, '4444');
                clearForm();
                toggleForm('forminput');
                alertify.success('Data kendaraan baru berhasil disimpan <br /> &nbsp;');
            } else if (formType == "UPD") {
                sendReq(1, '2222');
                clearForm();
                toggleForm('forminput');
                alertify.success('Data kendaraan berhasil diubah <br /> &nbsp;');
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

    function changeTableType() {
        $('#forminput').hide();

        if ($('#tabel_aktif').is(':checked')) {
            kode = '1111';
        } else if ($('#tabel_tidak_aktif').is(':checked')) {
            kode = '1112';
        }

        sendReq(1, kode);
    }

    function fillTable(data) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data[0][98]; j++) {
            reValueTable += '<tr>';
            reValueTable += '<td align="center" width="25">' + i + '</td>';
            reValueTable += '<td>' + data[j][1] + '</td>';
            reValueTable += '<td align="center">' + data[j][2] + '</td>';
            reValueTable += '<td align="center" wdith="50"><a href="#" class="detail" onclick="gridView(' + j + ')"> </a>';

            if (kode == '1112' || kode == '5556' || kode == '7777') {
                reValueTable += '<a href="#" class="aktifkan" onclick="gridActivate(' + j + ')"> </a>';
            } else {
                reValueTable += '<a href="#" class="update" onclick="showEditForm(' + j + ');"> </a>';
                reValueTable += '<a href="#" class="delete" onclick="gridDelete(' + j + ')"> </a>';
            }

            reValueTable += '</td></tr>';
            i++;
        }

        return reValueTable
    }

    function loadHeader(titles) {
        var title = "<tr>";
        for (i = 0; i < titles.length; i++) {
            title += "<th>" + titles[i] + "</th>";
        }
        title += "<th width='100'>Aksi</th>";
        title += "</tr>";
        $('#judul_tabel').html(title);
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

    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
    ///////////////////////////////////////////////////////

</script>

<span style="display: none;">
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
    <table id="content_form" style="width: 100%;">
        <tr>
            <td style="width: 100px;">Nama Kendaraan</td>
            <td id="tdnama"><input type="text" id="nama" class="text" value="" size="30"/></td>
            <td id="namaview" style="display: none;"></td>
        </tr> 
        
        <tr>
            <td>No Plat</td>
            <td id="tdno_plat"><input type="text" id="no_plat" class="text" value="" size="30"/></td>
            <td id="no_platview" style="display: none;"></td>
        </tr> 
        
        <tr>
            <td colspan="2" align="center" style="padding:15px;">

                <span class='tombol' id="bsimpan" onclick="entryValidate();">SIMPAN</span> 
                <span class='tombol' id="breset" value='Reset' onclick="clearForm();" >RESET</span> 
                <span class='tombol' value='Tutup' onclick="toggleForm('forminput')" >TUTUP</span> 

            </td>
        </tr>
    </table>
</div>

<div id="top_command">
    <div id="cari">
        Cari Kendaraan : 
        <input type="text" id="teks_cari" class="text" value="" size="30" onkeyup="if (event.keyCode == 13) {simpleSearch();}"/>  

        Status : 
        <input type="radio" name="select_tabel" onclick="changeTableType();" id="tabel_aktif" />Aktif
        <input type="radio" name="select_tabel" onclick="changeTableType();" id="tabel_tidak_aktif" />Tidak Aktif 
    </div>
    <div id="loading" style="display: none;">
        <img src="asset/images/299.png" /> 
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

<a href="#" class="back" onclick="resetTable();">Reset Tabel</a>
| 
<a href="#" class="tambah" onclick='showInputForm();'>Tambah</a>