<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT ALL DATA NO LIMIT
//2222 = UPDATE
//3333 = DELETE
//4444 = INSERT
//5555 = SEARCHSIMPLE AKTIF
//5556 = SEARCHSIMPLE TIDAK AKTIF
//7777 = AKTIFKAN


header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

require('../../fungsi.php');
konek_db();

$data = $_POST['myJson'];
$pesan = "";

@$user 	= $data[0][1];
@$id 	  = $data[0][2];
@$alpha   = $data[0][3];
@$search  = $data[0][96];
@$kode    = $data[0][97];
@$hal     = $data[0][98];
@$lim     = $data[0][99];

$json = array();

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim;
 
if ($kode == '1111') { 	
	$sql = "SELECT * FROM barang WHERE status = 1 ORDER BY nama";
	$run = mysql_query($sql);
	while($row = mysql_fetch_array($run)){
		$barang[][0] = $row['id_barang'];
	} 
	
	$jumlahdata = sizeof($barang);
	
	for($i = 0; $i < $jumlahdata; $i++){
		$ids = $barang[$i][0];
		
		$sql = "SELECT barang.id_barang, barang.nama, month(penjualan.tanggal_penjualan) as bulan, year(penjualan.tanggal_penjualan) as tahun, ifnull(SUM(penjualan_detail.jumlah), 0) as jumlah
				FROM barang, penjualan, penjualan_detail 
				WHERE barang.id_barang = penjualan_detail.id_barang
				AND penjualan.id_penjualan = penjualan_detail.id_penjualan
				AND barang.id_barang = $ids
				GROUP BY barang.id_barang, month(penjualan.tanggal_penjualan), year(penjualan.tanggal_penjualan)
				ORDER BY penjualan.createddate ASC";
		$run = mysql_query($sql);
		while($row = mysql_fetch_array($run)){
			
		}		
	}
	
	$jumlahjual[] = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
	echo singleES($jumlahjual[0]);
} 

$result = mysql_query($sql); 
$totalrow = mysql_num_rows($result); 

if ($totalrow <= 0) {
    $json['data'][] = array(
        'totalrow' => 0
    );
} else {
    while ($row = mysql_fetch_array($result)) {
        $json['data'][] = array(
            'id_barang' => 15,
            'nama' => 15,
            'single' => 15,
            'double' => 15,
            'triple' => 15,
            'totalrow' => 15,
            'totaldata' => 15
        );
    }
}
echo json_encode($json);

function singleES($data){
	$peramalan = 0;
	return $peramalan;
}

?>