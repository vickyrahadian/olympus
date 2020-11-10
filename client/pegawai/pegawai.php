<?php
/********************************************************************************************************************
 *                                                                                                                  *
 * TASK     : SISTEM INFORMASI PENJUALAN, PEMBELIAN DAN PERSEDIAAN BARANG PADA TOKO BAHAN BANGUNAN PALANGJAYA       *
 * AUTHOR   : VICKY RAHADIAN FIRMANSYAH (1274001)                                                                   *
 * EMAIL    : vicky.rahadian@gmail.com                                                                              *
 * COMP     : UNIVERSITAS KRISTEN MARANATHA BANDUNG                                                                 *
 * FILE     : pegawai.php                                                                                           *
 * DESC     : Digunakan untuk melakukan CRUD pada master data pegawai                                               *
 * CREATED  : 3 Februari 2014                                                                                       *
 * REVISION :                                                                                                       *
 *                                                                                                                  *
 ********************************************************************************************************************/
 ?>
 
 <script type="text/javascript">	

    ///////////////////////////////////////////////////////
    // PART A - INISIALISASI VARIABEL DAN FUNGSI AWAL//////
    ///////////////////////////////////////////////////////
    
    var title = 'Master \u00BB Pegawai';
    var headerTitle = ['No', 'Username', 'Nama', 'Alamat', 'Telepon', 'Posisi'];
    
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
    
    var namaTempGambar = '';
    var namaTempGambar2 = '';
    // DONT CHANGE THIS PART //
    
    $(document).ready(function(){
        $(document).attr('title', title);
        $('#title').html(title);  
        
        loadHeader(headerTitle);
        sendReq(1, '1111');
        
        $('#fgambar').on('change', function(){                 
            $("#forminputs").vPB({
				url: 'client/pegawai/get_pegawai_upload_image.php',
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
                    
					if(response == '1'){
					    $("#spangambar").hide().fadeIn('slow').html('<br /><br />Error, Gambar tidak boleh lebih dari 1 MB');
					} else {
					   $("#spangambar").hide().fadeIn('slow').html('<br /><br /><img width="100px" src="asset/images/temp/' + namaTempGambar + '" />');
                       $("#spangambardelete").fadeIn('slow');
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
    
    function sendReq(inhal, inkode){
        hal = inhal;
        kode = inkode;
        datasend[0][1]  = USERID;
        datasend[0][2]  = $('#id').val();
        datasend[0][97] = kode;
        datasend[0][98] = inhal;
        datasend[0][99] = limit;        
        
        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: 'client/pegawai/get_data_pegawai.php',
            data: {myJson : datasend},
            beforeSend: function() { $('#loading').fadeIn(); },
            complete: function() { $('#loading').fadeOut(); }
            }).success (function(response) {

			var jumlahData = response.data[0].totalrow;
			if(jumlahData <= 0){
				$('#isi_tabel').html('');
				$('#pagination').html(fillPagination(1, 1));
			} else {
				for(i = 0; i < jumlahData; i++){
					data[i][0] = response.data[i].id_pegawai;
					data[i][1] = response.data[i].username; 
					data[i][3] = response.data[i].nama;
					data[i][4] = response.data[i].alamat;
					data[i][5] = response.data[i].telepon;
					data[i][6] = response.data[i].id_posisi;
					data[i][8] = response.data[i].namaposisi;
					data[i][9] = response.data[i].gambar;
					
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
    
    function getDropDownPosisi(idselect, name, url, inkode){
        datasend[0][97] = inkode;       
        
        $.ajax({
            type: 'post',
            cache: false,
            dataType: 'json',
            url: url,
            data: {myJson : datasend}
        })
        .success (function(response) {
            var reValue = "<select class='dropdownlist' id='" + name + "'>";
            var jumlahData = response.data[0].total_row;  
            if(jumlahData <= 0){
                reValue += "<option>DATA NOT FOUND</option>"
            } else {
                for(i = 0; i < jumlahData; i++){
                    reValue += "<option value='" + response.data[i].id_posisi + "'>" + response.data[i].nama_posisi + "</option>";
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
    
    function gridView(id){
        hiddenField();
        $('#usernameview').html(data[id][1]);
        $('#namaview').html(data[id][3]);
        $('#alamatview').html(data[id][4]);
        $('#teleponview').html(data[id][5]);        
        $('#posisiview').html(data[id][8]);
        $('#gambarview').html(data[id][9] == '' ? '<img src="asset/images/ina.jpg" height="125px"/>' : ('<br/ ><img width="100px" src="asset/images/pegawai/' + data[id][9] + '" /><br /><br />'));
        if($('#forminput').css('display') == 'none'){
            toggleForm('forminput');
        }        
        $('#bsimpan').hide();
        $('#breset').hide();     
        
        $('#content_table').show(); 
    }
    
    function toggleForm(param){
        if(param == 'forminput'){
            if($('#' + param).css('display') == 'none'){
                $('#' + param).show();
            } else {
                $('#' + param).hide();
            }
        }
    }
    
    function showInputForm(){
        unHiddenField();
        if($('#forminput').css('display') == 'none'){
            toggleForm('forminput');
        }
        clearForm();
        $('#formtype').val('INS');
        $('#bsimpan').hide();
        $('#breset').show();        
        
        $('#un').removeAttr('readonly');
    }
    
    function showEditForm(id){
        unHiddenField();
        if($('#forminput').css('display') == 'none'){
            toggleForm('forminput');
        }
        clearForm();
        $('#formtype').val('UPD');
        $('#id').val(data[id][0]);
        $('#bsimpan').show();
        $('#breset').hide();        
        
        $('#validasiun').val(1);
        $('#pesanun').html('');
        $('#un').val(data[id][1]).attr('readonly', 'readonly');
        $('#nama').val(data[id][3]);
        $('#alamat').val(data[id][4]);    
        $('#telepon').val(data[id][5]); 
        $('#posisi').val(data[id][6]);
        namaTempGambar = data[id][9];
        namaTempGambar2 = data[id][9];
        
        if(data[id][9] == ''){
            $("#spangambar").show().html('<br /><br /><img width="100px" src="asset/images/ina.jpg" />');                
        } else {
            $("#spangambar").show().html('<br /><br /><img width="100px" src="asset/images/pegawai/' + data[id][9] + '" />');
            $("#spangambardelete").show();
        }
        
        $('#content_table').show();
        
    }
    
    function clearForm(){
        $('#id').val('');
        $('#un').val('');
        $('#un').css('background-color', '');
        $('#pesanun').hide();
        $('#pass').val('');
        $('#pass').css('background-color', '');
        $('#kpass').val('');
        $('#kpass').css('background-color', '');
        $('#nama').val('');
        $('#nama').css('background-color', '');
        $('#alamat').val('');
        $('#alamat').css('background-color', '');
        $('#telepon').val('');
        $('#telepon').css('background-color', '');
        $('#fgambar').val(''); 
        $('#spangambar').hide();
        $('#spangambardelete').hide();
        namaTempGambar = '';
        
        $(".dropdownlist").prop('selectedIndex', 0);
        $('#teks_cari').val('');
        $('#teks_cari').css('background-color', '');
    }
    
    function hiddenField(){
        $('#tdusername').hide();
        $('#usernameview').show();
        $('#trpassword').hide();
        $('#passwordview').hide();
        $('#trkpassword').hide();
        $('#kpasswordview').hide();
        $('#tdnama').hide();
        $('#namaview').show();    
        $('#tdalamat').hide();
        $('#alamatview').show();
        $('#tdtelepon').hide();
        $('#teleponview').show();
        $('#tdposisi').hide();
        $('#posisiview').show();
        $('#tdgambar').hide();
        $('#gambarview').show();
    }
    
    function unHiddenField(){
        $('#tdusername').show();
        $('#usernameview').hide();
        $('#trpassword').show();
        $('#passwordview').hide();
        $('#trkpassword').show();
        $('#kpasswordview').hide();
        $('#tdnama').show();
        $('#namaview').hide();    
        $('#tdalamat').show();
        $('#alamatview').hide();
        $('#tdtelepon').show();
        $('#teleponview').hide();
        $('#tdposisi').show();
        $('#posisiview').hide();
        $('#tdgambar').show();
        $('#gambarview').hide();
    }
    
	function simpleSearch(){
  
		datasend[0][96] = $('#teks_cari').val();   
		
		if($('#tabel_aktif').is(':checked')) {
			kode = '5555';
		} else {
			kode = '5556';       
		}
		
		sendReq(1, kode);                            
        
    }
	
    ///////////////////////////////////////////////////////
    // PART C - END////////////////////////////////////////
	///////////////////////////////////////////////////////
    
    ///////////////////////////////////////////////////////
    // PART D - PROSES INSERT, UPDATE DAN DELETE///////////
	///////////////////////////////////////////////////////
    
    function entryValidate(){
        var formType = $('#formtype').val();
        var reValue = true;
        
        if ($('#un').val() == ""){
            $('#un').css('background-color', 'yellow');
            reValue = false;    
        } else if ($('#validasiun').val() == 0){
            $('#un').css('background-color', 'yellow');
            reValue = false;              
        } else {
            $('#un').css('background-color', '');
        }
        
        if ($('#nama').val() == ""){
            $('#nama').css('background-color', 'yellow');
            reValue = false;                        
        } else {
            $('#nama').css('background-color', '');
        }
        
        if ($('#alamat').val() == ""){
            $('#alamat').css('background-color', 'yellow');
            reValue = false;                        
        } else {
            $('#alamat').css('background-color', '');
        }
        
        if ($('#telepon').val() == ""){
            $('#telepon').css('background-color', 'yellow');
            reValue = false;                        
        } else {
            $('#telepon').css('background-color', '');
        }
        
		if(formType == "INS"){
		
			if ($('#pass').val() == ""){
				$('#pass').css('background-color', 'yellow');
				reValue = false;          
			}  else if ($('#kpass').val() == ""){
				$('#kpass').css('background-color', 'yellow');
				reValue = false;                        
			} else {
				$('#pass').css('background-color', '');
			}
		
		}
		
		if ($('#pass').val() != $('#kpass').val()){
			$('#kpass').css('background-color', 'yellow');
			alertify.error("Konfirmasi password harus sama dengan password<br /> &nbsp;");
			reValue = false;                        
		} else {                        
			$('#kpass').css('background-color', '');
		}                                                          
                 
        if(reValue == false){
            alertify.error("Silahkan koreksi field yang berwarna kuning <br /> &nbsp;");
        } else {
                        
            datasend[0][3]  = $('#un').val();  
            datasend[0][4]  = $('#pass').val();  
            datasend[0][5]  = $('#nama').val();  
            datasend[0][6]  = $('#alamat').val();  
            datasend[0][7]  = $('#telepon').val();  
            datasend[0][8]  = $('#posisi').val();  
            datasend[0][10]  = namaTempGambar;
            
            if((namaTempGambar != '') && (namaTempGambar != namaTempGambar2)){
                moveFile(namaTempGambar, 'asset/images/temp/', 'asset/images/pegawai/');
            }                                                                                              
                                                
            if(formType == "INS"){
                sendReq(1, '4444'); 
                clearForm();
                toggleForm('forminput');
                alertify.success('Data pegawai baru berhasil disimpan <br /> &nbsp;');
            } else if(formType == "UPD"){
                sendReq(1, '2222'); 
                clearForm();
                toggleForm('forminput');
                alertify.success('Data pegawai berhasil diubah <br /> &nbsp;');
            } 
            kode = 1111;                   
        }
    }
    
    function gridDelete(id){
        $('#forminput').hide();
        if(USERID == data[id][0]){
            alertify.error('Anda tidak bisa menghapus ' + data[id][1] + ' karena sedang login dengan username tersebut! <br /> &nbsp;');         
        } else {
            alertify.confirm('Anda yakin akan menghapus data ' + data[id][1] + ' ? <br /> &nbsp;', function (e) {
                if (e) {
                    alertify.success('Data ' + data[id][1] + ' telah dihapus <br /> &nbsp;');
                    clearForm();
                    $('#id').val(data[id][0]);
                    kode = '3333';
                    sendReq(1, '3333');
                } 
            });
        }
    }
    
    function gridActivate(id){
        alertify.confirm('Anda yakin akan mengaktifkan data ' + data[id][1] + ' ? <br /> &nbsp;', function (e) {
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
    
    function loadHeader(titles){
        var title = "<tr>";
        for(i = 0; i < titles.length; i++){
            title += "<th>" + titles[i] + "</th>";
        }
        title += "<th>Aksi</th>";
        title += "</tr>";
        $('#judul_tabel').html(title);
    }
    
    function fillTable(data){
        var reValueTable = '';
        var i = 1;
        i = ((hal - 1) * limit) + i;
        
        for(j = 0; j < data[0][98]; j++){
            reValueTable += '<tr>';
                reValueTable += '<td align="center" width="25">' + i + '</td>';
                reValueTable += '<td align="center">' + data[j][1] + '</td>';
                reValueTable += '<td>' + data[j][3] + '</td>';
                reValueTable += '<td>' + data[j][4] + '</td>';
                reValueTable += '<td align="center">' + data[j][5] + '</td>';
                reValueTable += '<td align="center">' + data[j][8] + '</td>';
                reValueTable += '<td align="center"><a href="#" class="detail" onclick="gridView(' + j + ')"></a> ';
                
                if(kode == '1112' || kode == '5556' || kode == '7777'){
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
    
    function pagingCLick(hal){ 
        sendReq(hal, kode);
    }
    
    function changeTableType(){
        $('#forminput').hide();

        if($('#tabel_aktif').is(':checked')) { 
            kode = '1111';
        } else if($('#tabel_tidak_aktif').is(':checked')) {             
            kode = '1112';            
        }
        
        sendReq(1, kode);
    }
    
    function setRadioButton(kode){
        if(kode == '1111' || kode == '5555' || kode == '2222' || kode == '4444' ){
            $('#tabel_aktif').prop('checked', true);
        } else if(kode == '1112' || kode == '5556'){
            $('#tabel_tidak_aktif').prop('checked', true);
        }
    }
    
    function resetTable(){
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
    
    function moveFile(namaFile, lokasiAwal, lokasiPindah){
        
        datasend[0][0] = namaFile;        
        datasend[0][1] = lokasiAwal;
        datasend[0][2] = lokasiPindah;
        
        $.ajax({
            type: 'post',
            cache: false,
            url: 'asset/php/fungsi/movefile.php',
            data: {myJson : datasend}
        })
        .success (function(response) { 
            if(response != 1){
                alert('failed');
            }
        });    
    }
    
    function deleteImagePreview(){
        $('#fgambar').val('');
        $('#spangambar').hide();
        $('#spangambardelete').hide();
        namaTempGambar = '';
    }
    
    function similarityCheck(inhal, inkode, searchVal){
        
        if(searchVal.length == 0){
            $('#validasiun').val('0');
            $('#pesanun').show().html("");
            $('#bsimpan').hide();
        } else if(searchVal.length < 5){
            $('#validasiun').val('0');
            $('#pesanun').show().html("Username harus lebih dari 4 karakter");
            $('#bsimpan').hide();
        } else if ($('#formtype').val() == 'INS') {
            hal = inhal;
            kode = inkode;
            datasend[0][1]  = USERID;
            datasend[0][2]  = $('#id').val();
            datasend[0][96] = searchVal;        
            datasend[0][97] = kode;
            datasend[0][98] = inhal;
            datasend[0][99] = limit;        
            
            $.ajax({
                type: 'post',
                cache: false,
                dataType: 'json',
                url: 'client/pegawai/get_data_pegawai.php',
                data: {myJson : datasend},
                beforeSend: function() { $('#loading').fadeIn(); },
                complete: function() { $('#loading').fadeOut(); }
                })
                .success (function(response) {
                    var jumlahData = response.data[0].totalrow;
                    if(jumlahData <= 0){                
                        $('#validasiun').val('1');
                        $('#pesanun').show().html("<em>Username tersedia</em>");
                        $('#bsimpan').show();
                    } else {           
                        $('#validasiun').val('0');
                        $('#pesanun').show().html("<em>Username telah dipakai</em>");
                        $('#bsimpan').hide();
                    }                  
                });
        }
                           
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
    
        <table id="content_form" style="width:100%">
            <tr>
                <td style="width:100">Username</td>
                <td id="tdusername">
                    <input type="hidden" id="validasiun" value="1"/>
                    <input type="text" id="un" class="text" value="" size="20" maxlength="25" onkeyup="similarityCheck(1, '1115', $('#un').val());"/>
                    <span id="pesanun"></span>
                </td>
                <td id="usernameview"></td>
            </tr> 
                 
            <tr id="trpassword" style="display: none;">
                <td width="150">Password</td>
                <td id="tdpassword"><input type="password" id="pass" class="text" value="" size="20"/></td>
                <td id="passwordview"></td>
            </tr>
            
            <tr id="trkpassword" style="display: none;">
                <td>Konfirmasi Passowrd</td>
                <td id="tdkpassword"><input type="password" id="kpass" class="text" value="" size="20"/></td>
                <td id="kpasswordview"></td>
            </tr>                 
                            
            <tr>
                <td>Nama</td>
                <td id="tdnama"><input type="text" id="nama" class="text" value="" size="30"/></td>
                <td id="namaview" style="display: none;"></td>
            </tr> 
            
            <tr>
                <td>Alamat</td>
                <td id="tdalamat"><input type="text" id="alamat" class="text" value="" size="50"/></td>
                <td id="alamatview" style="display: none;"></td>
            </tr>
            
            <tr>
                <td>Telepon</td>
                <td id="tdtelepon"><input type="text" id="telepon" class="text" value="" size="20"/></td>
                <td id="teleponview" style="display: none;"></td>
            </tr>
            
            <tr>
                <td>Posisi</td>
                <td id="tdposisi">
                    <script type="text/javascript">getDropDownPosisi('tdposisi', 'posisi', 'client/pegawai/get_data_posisi.php', '1114')</script>
                </td>
                <td id="posisiview" style="display: none;"></td>
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
        Cari Pegawai : 
        <input type="text" id="teks_cari" class="text" value="" size="30" onkeypress="if(event.keyCode == 13){simpleSearch();}" /> 
        
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
    
    <p align="right" id="pagination"></p>
</div>

<a href="#" class="back" onclick="resetTable();">Reset Tabel</a>
 | 
<a href="#" class="tambah" onclick='showInputForm();'>Tambah</a>