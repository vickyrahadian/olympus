<?php
/********************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : popup_pembelian.php                                                                                   *
 * DESC     : Digunakan untuk memilih data pembelian barang untuk retur                                             *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 ********************************************************************************************************************/
?>

<script type="text/javascript">

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////
    
	var headerTitle = ['No', 'No Faktur', 'Tanggal Pembelian', 'Pemasok', 'Total'];
	var kode;
	var hal = 0;
	var totalHalaman;
	var limit = 10;

	var data = new Array(limit);
	for (i=0; i <100; i++){
		data[i] = new Array(100);
	}

	var datasend = new Array(100);
	for (i=0; i <100; i++){
		datasend[i] = new Array(100);
	} 
	
	$(document).ready(function(){
	loadHeader(headerTitle);
	sendReq(1, '1111');

	});
	
    ///////////////////////////////////////////////////////
    // PART A - END////////////////////////////////////////
    ///////////////////////////////////////////////////////
    
    ///////////////////////////////////////////////////////
    // PART B - MENGAMBIL DATA DARI DATABASE///////////////
    ///////////////////////////////////////////////////////
	
	function sendReq(inhal, inkode){
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
            url: 'client/pembelian/get_data_pembelian.php',
            data: {myJson : datasend},
            beforeSend: function() { $('#loading').show(); },
            complete: function() { $('#loading').hide(); }
            }).success (function(response) {
			
			var jumlahData = response.data[0].totalrow;
			if(jumlahData <= 0){
				$('#isi_tabel').html('');
				$('#pagination').html(fillPagination(1, 1));
			} else {
				for(i = 0; i < jumlahData; i++){
				
					data[i][0] = response.data[i].id_pembelian;
					data[i][1] = response.data[i].no_nota;
					data[i][2] = response.data[i].no_faktur;
					data[i][3] = response.data[i].subtotal;
					data[i][4] = response.data[i].biaya_kirim;
					data[i][5] = response.data[i].biaya_lain;
					data[i][6] = response.data[i].biaya_pajak;
					data[i][7] = response.data[i].total;
					data[i][8] = response.data[i].uang_muka;
					data[i][9] = response.data[i].status_pembayaran; 
					data[i][10] = response.data[i].keterangan;
					data[i][11] = response.data[i].id_pemasok;
					data[i][12] = response.data[i].tanggal_pembelian;
					data[i][13] = response.data[i].jatuh_tempo;
					data[i][14] = response.data[i].islunas;
					data[i][15] = response.data[i].nama;
					data[i][16] = response.data[i].alamat;
					
					//tabel standar field
					data[i][94] = response.data[i].createddate;
					data[i][95] = response.data[i].createdby;
					
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

    ///////////////////////////////////////////////////////
    // PART B - END////////////////////////////////////////
	///////////////////////////////////////////////////////
    
    ///////////////////////////////////////////////////////
    // PART C - PENGATURAN FORM ///////////////////////////
	///////////////////////////////////////////////////////
	
	function simpleSearch(){
		datasend[0][96] = $('#teks_cari').val();
		kode = '5555';
		sendReq(1, kode);
		$('#teks_cari').css('background-color', '');        
    }
    
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
	
	function loadHeader(titles){
        var title = "<tr>";
        for(i = 0; i < titles.length; i++){
            title += "<th>" + titles[i] + "</th>";
        }
        title += "</tr>";
        $('#judul_tabel').html(title);
    }
 
	function fillTable(data){
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;
        
        for(j = 0; j < data[0][98]; j++){
            reValueTable += '<tr onClick="closeWindow(' + data[j][0] + ')" >';
                reValueTable += '<td align="center">' + i + '</td>'; 
                reValueTable += '<td align="">' + data[j][2] + '</td>';
                reValueTable += '<td align="center">' + dateToString(data[j][12]) + '</td>';
                reValueTable += '<td align="">' + data[j][15] + '</td>';
                reValueTable += '<td align="right">'  + toRp(data[j][7]) + '</td>';             
            reValueTable += '</tr>';
            i++;
        }
		
         
        return reValueTable
    }
	
	function pagingCLick(hal){ 
        sendReq(hal, kode);
    }
 
    ///////////////////////////////////////////////////////
    // PART E - END////////////////////////////////////////
	///////////////////////////////////////////////////////
    
    ///////////////////////////////////////////////////////
    // PART F - FUNGSI LAIN LAIN///////////////////////////
	///////////////////////////////////////////////////////
	
	function closeWindow(id) {
        opener.getDataPembelian(id);
        window.close();
    }
 
    ///////////////////////////////////////////////////////
    // PART F - END////////////////////////////////////////
	///////////////////////////////////////////////////////

</script>

<div id="top_command">
    <div id="cari">
        Cari Pembelian :
        <input type="text" id="teks_cari" class="text" value="" size="30" onkeypress="if(event.keyCode == 13){simpleSearch();}" /> 
    </div>
    <div id="loading" style="display: none;">
        <img src="asset/images/299.png" />
    </div>
</div>

<div id="datagrid">
    <table width='100%' id='popup_table'>
        <thead id="judul_tabel"></thead>
        <tbody id="isi_tabel"></tbody>
    </table>

    <br />

    <p align="right" id="pagination">
    </p>
</div>