<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1114 = SELECT DROPDOWN
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

@$user = $data[0][1];
@$id = $data[0][2];
@$search = $data[0][96];
@$kode = $data[0][97];
@$hal = $data[0][98];
@$lim = $data[0][99];
$json = array();

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim; 

if ($kode == '1111') {
    $sql = "SELECT *, 
            (
                SELECT COUNT(*) 
                FROM daftar_akun
            ) as totaldata 
            FROM daftar_akun
            LIMIT $cur_pos, $lim";
}

$result = mysql_query($sql);
$totalrow = mysql_num_rows($result);

if ($totalrow <= 0) {
    $json['data'][] = array(
        'totalrow' => 0,
        'totaldata' => 0
    );
} else {
    while ($row = mysql_fetch_array($result)) {
        $json['data'][] = array(
            'id_daftarakun' => $row['id_daftarakun'],
            'kode_akun' => $row['kode_akun'],
            'nama_akun' => $row['nama_akun'],
            'status' => $row['status'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'updateddate' => $row['updateddate'],
            'updatedby' => $row['updatedby'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}

echo json_encode($json);
?>