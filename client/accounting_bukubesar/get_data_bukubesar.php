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

@$user = $data[0][1];
@$id = $data[0][2];
@$kodeakun = $data[0][3]; 
@$tipe = $data[0][4];  
@$tanggal_mulai = $data[0][5]; 
@$tanggal_akhir = $data[0][6]; 
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
    if($tipe == 1){
        $sql = "SELECT *, 
            (
                SELECT COUNT(*) 
                FROM jurnal_umum
                WHERE id_kodeakun = $kodeakun
            ) as totaldata,
            (
                SELECT SUM(debit) FROM jurnal_umum WHERE id_kodeakun = $kodeakun
            ) as sumdebit,
            (
                SELECT SUM(kredit) FROM jurnal_umum WHERE id_kodeakun = $kodeakun
            ) as sumkredit
            FROM jurnal_umum
            JOIN daftar_akun
            ON jurnal_umum.id_kodeakun = daftar_akun.id_daftarakun
            WHERE jurnal_umum.id_kodeakun = $kodeakun
            ORDER BY id_jurnalumum ASC
            LIMIT $cur_pos, $lim";
    } else {
        $sql = "SELECT *,
            (
                SELECT COUNT(*) 
                FROM jurnal_umum
                WHERE id_kodeakun = $kodeakun
                AND jurnal_umum.tanggal between '$tanggal_mulai' and '$tanggal_akhir'
            ) as totaldata,
            (
                SELECT SUM(debit) FROM jurnal_umum WHERE id_kodeakun = $kodeakun
                AND jurnal_umum.tanggal between '$tanggal_mulai' and '$tanggal_akhir'
            ) as sumdebit,
            (
                SELECT SUM(kredit) FROM jurnal_umum WHERE id_kodeakun = $kodeakun
                AND jurnal_umum.tanggal between '$tanggal_mulai' and '$tanggal_akhir'
            ) as sumkredit
            FROM jurnal_umum
            JOIN daftar_akun
            ON jurnal_umum.id_kodeakun = daftar_akun.id_daftarakun
            WHERE jurnal_umum.id_kodeakun = $kodeakun
            AND jurnal_umum.tanggal between '$tanggal_mulai' and '$tanggal_akhir'
            ORDER BY id_jurnalumum ASC
            LIMIT $cur_pos, $lim";
    } 
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
            'id_jurnalumum' => $row['id_jurnalumum'], 
            'id_daftarakun' => $row['id_daftarakun'], 
            'tanggal' => $row['tanggal'],
            'debit' => $row['debit'],
            'kredit' => $row['kredit'],          
            'tanggal' => $row['tanggal'],
            'sumdebit' => $row['sumdebit'],
            'sumkredit' => $row['sumkredit'],          
            'kode_rekening' => $row['kode_akun'],
            'nama_rekening' => $row['nama_akun'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}

echo json_encode($json);
?>