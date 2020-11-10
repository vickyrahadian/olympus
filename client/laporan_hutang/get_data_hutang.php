<?php

//1111 = SELECT ALL
//1112 = SELECT PERDATE

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

@$tanggal_mulai = $data[0][3];
@$tanggal_akhir = $data[0][4];

if ($kode == '1111') {
    if ($id > 0) {
        $sql = "SELECT h.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM hutang     
                WHERE id_pemasok = $id
            ) as totaldata 
            FROM hutang h, pemasok pema
            WHERE h.id_pemasok = pema.id_pemasok 
            AND h.id_pemasok = $id
            ORDER BY tanggal_pembayaran DESC
            LIMIT $cur_pos, $lim";
    } else {
        $sql = "SELECT h.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM hutang      
            ) as totaldata 
            FROM hutang h, pemasok pema
            WHERE h.id_pemasok = pema.id_pemasok  
            ORDER BY tanggal_pembayaran DESC
            LIMIT $cur_pos, $lim";
    }
} else if ($kode == '1112') {
    if ($id > 0) {
        $sql = "SELECT h.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM hutang     
                WHERE id_pemasok = $id
                AND tanggal_pembayaran between '$tanggal_mulai' and '$tanggal_akhir'
            ) as totaldata 
            FROM hutang h, pemasok pema
            WHERE h.id_pemasok = pema.id_pemasok 
            AND h.tanggal_pembayaran between '$tanggal_mulai' and '$tanggal_akhir'
            AND h.id_pemasok = $id
            ORDER BY tanggal_pembayaran DESC
            LIMIT $cur_pos, $lim";
    } else {
        $sql = "SELECT h.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM hutang      
                WHERE tanggal_pembayaran between '$tanggal_mulai' and '$tanggal_akhir'
            ) as totaldata 
            FROM hutang h, pemasok pema
            WHERE h.id_pemasok = pema.id_pemasok 
            AND h.tanggal_pembayaran between '$tanggal_mulai' and '$tanggal_akhir' 
            ORDER BY tanggal_pembayaran DESC
            LIMIT $cur_pos, $lim";
    }
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
            'id_hutang' => $row['id_hutang'],
            'no_nota' => $row['no_nota'],
            'tanggal_pembayaran' => $row['tanggal_pembayaran'],
            'total' => $row['total'],
            'keterangan' => $row['keterangan'],
            'id_pemasok' => $row['id_pemasok'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'kota' => $row['kota'],
            'kodepos' => $row['kodepos'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>