<?php
/* * ******************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : popup_barang.php                                                                                      *
 * DESC     : Digunakan untuk memilih barang pada transaksi pembelian                                               *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 * ****************************************************************************************************************** */
?>

<script type="text/javascript">

    var headerTitle = ['Barcode', 'Kode Barang', 'Nama Barang', 'Harga', 'Stok'];

    var kode;
    var hal = 0;
    var totalHalaman;
    var limit = 10;

    var data = new Array(limit);
    for (i = 0; i < 100; i++) {
        data[i] = new Array(100);
    }

    var datasend = new Array(limit);
    for (i = 0; i < 100; i++) {
        datasend[i] = new Array(100);
    }

    $(document).ready(function() {
        loadHeader(headerTitle);
        sendReq(1, '1111');
    });

    function loadHeader(titles) {
        var title = "<tr>";
        for (i = 0; i < titles.length; i++) {
            title += "<th>" + titles[i] + "</th>";
        }
        title += "</tr>";
        $('#judul_tabel').html(title);
    }

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
                $('#loading').fadeIn();
            },
            complete: function() {
                $('#loading').fadeOut();
            }
        })
                .success(function(response) {
                    var jumlahData = response.data[0].totalrow;
                    if (jumlahData <= 0) {
                        $('#isi_tabel').html('');
                        $('#pagination').html(fillPagination(1, 1));
                    } else {
                        for (i = 0; i < jumlahData; i++) {
                            data[i][0] = response.data[i].id_barang;
                            data[i][1] = response.data[i].barcode;
                            data[i][2] = response.data[i].nama;
                            data[i][3] = response.data[i].id_satuan;
                            data[i][4] = response.data[i].harga_ecer;
                            data[i][5] = response.data[i].stok_terjual;
                            data[i][6] = response.data[i].id_kategori;
                            data[i][7] = response.data[i].namakategori;
                            data[i][9] = response.data[i].namasatuan;
                            data[i][11] = response.data[i].gambar;
                            data[i][12] = response.data[i].kode;
                            data[i][13] = response.data[i].stok;

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
                    }
                });
    }

    function fillTable(data) {
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;

        for (j = 0; j < data[0][98]; j++) {
            reValueTable += '<tr onClick="closeWindow(' + data[j][0] + ', \'' + data[j][12] + '\', \'' + data[j][2] + '\', \'' + data[j][4] + '\', ' + data[j][13] + ')">';
            reValueTable += '<td align="center" width="130">' + data[j][1] + '</td>';
            reValueTable += '<td align="center" width="130">' + data[j][12] + '</td>';
            reValueTable += '<td>' + data[j][2] + '</td>';
            reValueTable += '<td align="right">' + toRp(data[j][4]) + '</td>';
            reValueTable += '<td align="center">' + data[j][13] + '</td>';
            reValueTable += '</tr>';
            i++;
        }

        return reValueTable
    }

    function pagingCLick(hal) {
        sendReq(hal, kode);
    }

    function simpleSearch() {

        datasend[0][96] = $('#teks_cari').val();

        kode = '5555';

        sendReq(1, kode);
        $('#teks_cari').css('background-color', '');

    }


    function closeWindow(id, kode, nama, harga, stok) {
        opener.getDataBarang(id, kode, nama, harga, stok);
        window.close();
    }
</script>
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

<!--div cari-->
<div id="top_command">
    <div id="cari">
        Cari Barang : 
        <input type="text" id="teks_cari" class="text" value="" size="30" onkeypress="if (event.keyCode == 13) {
                    simpleSearch();
                }" /> 

    </div>
    <div id="loading" style="display: none;">
        <img src="asset/images/299.png" /> 
    </div>
</div>

<div id="datagrid">
    <table width='100%'  id='popup_table'>
        <thead id="judul_tabel"></thead>
        <tbody id="isi_tabel"></tbody>
    </table>        

    <br />

    <p align="right" id="pagination">
    </p>
</div>