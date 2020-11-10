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

@$user = $data[0][1];
@$id = $data[0][2];
@$tanggal_mulai = $data[0][3]; 
@$tanggal_akhir = $data[0][4]; 
@$search = $data[0][96];
@$kode = $data[0][97];
@$hal = $data[0][98];
@$lim = $data[0][99];

$json = array();

if ($kode == '1111') {
    $sql = "SELECT d.id_daftarakun, d.kode_akun, d.nama_akun, ifnull(SUM(j.debit), 0) as sumdebit, ifnull(SUM(j.kredit), 0) as sumkredit FROM daftar_akun d LEFT JOIN jurnal_umum j ON d.id_daftarakun = j.id_kodeakun GROUP BY d.id_daftarakun ORDER BY d.id_daftarakun";
} else if ($kode == '5555') {
    $sql = "SELECT d.id_daftarakun, d.kode_akun, d.nama_akun, ifnull(SUM(j.debit), 0) as sumdebit, ifnull(SUM(j.kredit), 0) as sumkredit FROM daftar_akun d LEFT JOIN jurnal_umum j ON d.id_daftarakun = j.id_kodeakun AND j.tanggal between '$tanggal_mulai' and '$tanggal_akhir' GROUP BY d.id_daftarakun ORDER BY d.id_daftarakun";
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
            'nama_akun' => $row['nama_akun'], 
            'kode_akun' => $row['kode_akun'], 
            'sumdebit' => $row['sumdebit'], 
            'sumkredit' => $row['sumkredit'],            
            'totalrow' => $totalrow
        );
    }
}

echo json_encode($json);
?>