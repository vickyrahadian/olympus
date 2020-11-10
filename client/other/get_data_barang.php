<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
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
@$tabel = $_GET['tabel'];

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim;

//VARIABLE FROM POST 
$username = $data[0][3];
$oripassword = $data[0][4];
$password = md5($data[0][4]);
$nama = gantiHurufKapital($data[0][5]);
$alamat = gantiHurufKapital($data[0][6]);
$telepon = $data[0][7];
$id_posisi = $data[0][8];
$status = $data[0][9];
$gambar = $data[0][10];

if ($kode == '1111') {
    $sql = "SELECT pe.*, po.nama_posisi as namaposisi, (1) as totaldata
            FROM 
                pegawai pe, pegawai_posisi po
            WHERE
                pe.id_posisi = po.id_posisi
            AND
                status = 1
            AND
                id_pegawai = $user";
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
            'id_pegawai' => $row['id_pegawai'],
            'username' => $row['username'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'telepon' => $row['telepon'],
            'id_posisi' => $row['id_posisi'],
            'namaposisi' => $row['namaposisi'],
            'gambar' => $row['gambar'],
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