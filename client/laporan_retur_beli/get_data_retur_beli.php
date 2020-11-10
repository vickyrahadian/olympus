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
        $sql = "SELECT r.*, p.no_faktur as nofakturpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_beli) as totaldata
            FROM retur_beli r
            JOIN pembelian p ON p.id_pembelian = r.id_pembelian
            JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
            WHERE pe.id_pemasok = $id
            ORDER BY r.createddate DESC
            LIMIT $cur_pos, $lim"; 
    } else {
        $sql = "SELECT r.*, p.no_faktur as nofakturpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_beli) as totaldata
            FROM retur_beli r
            JOIN pembelian p ON p.id_pembelian = r.id_pembelian
            JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
            ORDER BY r.createddate DESC
            LIMIT $cur_pos, $lim";
    }
} else if ($kode == '1112') {
    if ($id > 0) {
        $sql = "SELECT r.*, p.no_faktur as nofakturpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos, 
            (
                SELECT COUNT(*)
                FROM retur_beli r
                JOIN pembelian p ON p.id_pembelian = r.id_pembelian
                JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
                WHERE r.tanggal_retur between '$tanggal_mulai' and '$tanggal_akhir'
                AND p.id_pemasok = $id
            ) as totaldata
            FROM retur_beli r
            JOIN pembelian p ON p.id_pembelian = r.id_pembelian
            JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
            WHERE r.tanggal_retur between '$tanggal_mulai' and '$tanggal_akhir'
            AND pe.id_pemasok = $id    
            ORDER BY r.createddate DESC
            LIMIT $cur_pos, $lim";
        
    } else {
        $sql = "SELECT r.*, p.no_faktur as nofakturpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos, 
            (
                SELECT COUNT(*)
                FROM retur_beli r
                JOIN pembelian p ON p.id_pembelian = r.id_pembelian
                JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
                WHERE r.tanggal_retur between '$tanggal_mulai' and '$tanggal_akhir'
            ) as totaldata
            FROM retur_beli r
            JOIN pembelian p ON p.id_pembelian = r.id_pembelian
            JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
            WHERE r.tanggal_retur between '$tanggal_mulai' and '$tanggal_akhir'
            ORDER BY r.createddate DESC
            LIMIT $cur_pos, $lim";
    }
}
//echo $sql;
$result = mysql_query($sql);
$totalrow = mysql_num_rows($result);

if ($totalrow <= 0) {
    $json['data'][] = array(
        'totalrow' => 0
    );
} else {
    while ($row = mysql_fetch_array($result)) {
        $json['data'][] = array(
            'id_returbeli' => $row['id_returbeli'],
            'no_nota' => $row['no_nota'],
            'tanggal_retur' => $row['tanggal_retur'],
            'total' => $row['total'],
            'keterangan' => $row['keterangan'],
            'id_pembelian' => $row['id_pembelian'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'nofakturpembelian' => $row['nofakturpembelian'],
            'totalpembelian' => $row['totalpembelian'],
            'idpemasok' => $row['idpemasok'],
            'namapemasok' => $row['namapemasok'],
            'alamatpemasok' => $row['alamatpemasok'],
            'kota' => $row['kota'],
            'kodepos' => $row['kodepos'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>