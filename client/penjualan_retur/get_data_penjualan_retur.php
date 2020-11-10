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

@$total = $data[0][3];
@$keterangan = $data[0][4];

if ($kode == '1111') {
    $sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_jual) as totaldata
            FROM retur_jual r
            JOIN penjualan p ON p.id_penjualan = r.id_penjualan
            JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan
            ORDER BY r.createddate DESC
            LIMIT $cur_pos, $lim";
}

if ($kode == '4444') {

    //AMBIL MAX ID
    $last_id = '';
    $todaydate = date('Y') . date('m') . date('d');

    $sqlgetmaxid = "SELECT MAX(id_returjual) as maxid FROM retur_jual";
    $run = mysql_query($sqlgetmaxid);
    while ($row = mysql_fetch_array($run)) {
        $last_id = $row['maxid'];
    }
    $last_id++;

    if ($last_id < 10) {
        $last_id = '000' . $last_id;
    } else if ($last_id >= 10 && $last_id < 100) {
        $last_id = '00' . $last_id;
    } else if ($last_id >= 100 && $last_id < 1000) {
        $last_id = '0' . $last_id;
    }

    $no_nota = 'PJ/4/' . $todaydate . '/' . $last_id;

    $sqlinsert = "INSERT INTO `retur_jual`(`no_nota`, `tanggal_retur`, `total`, `keterangan`, `id_penjualan`, `createdby`) VALUES ('$no_nota', CURRENT_TIMESTAMP, $total, '$keterangan', $id, $user)";
    mysql_query($sqlinsert);

    $sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_jual) as totaldata
            FROM retur_jual r
            JOIN penjualan p ON p.id_penjualan = r.id_penjualan
            JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan
            ORDER BY r.createddate DESC
            LIMIT 1";
}

if ($kode == '5555') {
    $sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, 
    (
        SELECT COUNT(*) 
        FROM retur_jual r
        JOIN penjualan p ON p.id_penjualan = r.id_penjualan
        JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan
        WHERE 
        (
            p.no_faktur LIKE '%$search%'
            OR
            pe.nama LIKE '%$search%'
        )									
    ) as totaldata
    FROM retur_jual r
    JOIN penjualan p ON p.id_penjualan = r.id_penjualan
    JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan
    WHERE 
    (
       p.no_faktur LIKE '%$search%'
        OR
        pe.nama LIKE '%$search%'
    )
    ORDER BY r.createddate DESC
    LIMIT $cur_pos, $lim";
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
            'id_returjual' => $row['id_returjual'],
            'no_nota' => $row['no_nota'],
            'tanggal_retur' => $row['tanggal_retur'],
            'total' => $row['total'],
            'keterangan' => $row['keterangan'],
            'id_penjualan' => $row['id_penjualan'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'nofakturpenjualan' => $row['nofakturpenjualan'],
            'totalpenjualan' => $row['totalpenjualan'],
            'idpelanggan' => $row['idpelanggan'],
            'namapelanggan' => $row['namapelanggan'],
            'alamatpelanggan' => $row['alamatpelanggan'],
            'kota' => $row['kota'],
            'kodepos' => $row['kodepos'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>