<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT SEMUA
//2222 = UPDATE
//3333 = DELETE
//4444 = INSERT
//5555 = SEARCHSIMPLE AKTIF
//5556 = SEARCHSIMPLE TIDAK AKTIF
//6666 = SEARCHCOMPLEX
//7777 = AKTIFKAN

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

require('../../fungsi.php');
konek_db();

@$data = $_POST['myJson'];
@$pesan = "";

@$user = $data[0][1];
@$id   = $data[0][2];
@$kode = $data[0][97];
@$hal  = $data[0][98];
@$lim  = $data[0][99];

$json = array();
@$tabel = $_GET['tabel'];

if ($hal == "" || $hal < 1) {
    $hal = 1;
}  

$cur_pos = ($hal - 1) * $lim;

//VARIABLE FROM POST 
$username       = $data[0][3];
$password       = md5($data[0][4]);
$nama           = gantiHurufKapital($data[0][5]);
$alamat         = gantiHurufKapital($data[0][6]); 
$telepon        = $data[0][7];
$id_posisi      = $data[0][8];
$status         = $data[0][9];
$gambar         = $data[0][10];
$search         = $data[0][11];
    
    if($kode == '1114'){
        $sql =  "SELECT *, 
                    (
                        SELECT COUNT(*) 
                        FROM pegawai_posisi 
                    ) as totaldata 
                FROM pegawai_posisi
                ORDER BY nama_posisi ASC"; 
    }
    
    

$result  = mysql_query($sql);
$totalrow  = mysql_num_rows($result);

if($totalrow <= 0){
    $json['data'][] = array(
        'total_row' => 0
    );
} else {
    while($row = mysql_fetch_array($result)){
        $json['data'][] = array(
            'id_posisi' => $row['id_posisi'],
            'nama_posisi' => $row['nama_posisi'],
            'kode_posisi' => $row['kode_posisi'],
            'total_row' => $totalrow,
            'total_data' => $row['totaldata']
        );
    }
} 
echo json_encode($json); 

?>