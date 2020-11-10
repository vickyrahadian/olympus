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

$cur_pos = ($hal - 1) * $lim;
$total_bayar = $data[0][3];
$keterangan = $data[0][4];

if ($kode == '1111') {
    $sql = "SELECT hutang.*, pemasok.nama, pemasok.alamat, pemasok.kota, pemasok.kodepos, (SELECT COUNT(*) FROM hutang) as totaldata FROM hutang JOIN pemasok ON hutang.id_pemasok = pemasok.id_pemasok ORDER BY CREATEDDATE DESC LIMIT $cur_pos, $lim";
} else if ($kode == '4444') {

    //AMBIL MAX ID
    $last_id = '';
    $todaydate = date('Y') . date('m') . date('d');

    $sqlgetmaxid = "SELECT MAX(id_hutang) as maxid FROM hutang";
    $run = mysql_query($sqlgetmaxid);
    $row = mysql_fetch_array($run);
    $last_id = $row['maxid'];
    
    $last_id++;

    if ($last_id < 10) {
        $last_id = '000' . $last_id;
    } else if ($last_id >= 10 && $last_id < 100) {
        $last_id = '00' . $last_id;
    } else if ($last_id >= 100 && $last_id < 1000) {
        $last_id = '0' . $last_id;
    }

    $no_nota = 'PJ/H/' . $todaydate . '/' . $last_id;
    $sqlinsert = "INSERT INTO `hutang`(`no_nota`, `tanggal_pembayaran`, `total`, `keterangan`, `id_pemasok`, `createdby`) VALUES ('$no_nota', CURRENT_TIMESTAMP, $total_bayar, '$keterangan', $id, $user)";
    mysql_query($sqlinsert);
    
    $sql = "SELECT MAX(id_hutang) as maxid FROM hutang";
    $row = mysql_fetch_array(mysql_query($sql));
    $id_hutang = $row['maxid'];
    
    //insert ke jurnal
    $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_hutang`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (4, $id_hutang, NOW(), $total_bayar, 0, $user)";
    $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_hutang`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $id_hutang, NOW(), 0, $total_bayar, $user)";
    mysql_query($sqldeb);
    mysql_query($sqlkre);

    $sql = "SELECT hutang.*, pemasok.nama, pemasok.alamat, pemasok.kota, pemasok.kodepos, 1 as totaldata 
            FROM hutang 
            JOIN pemasok 
            ON hutang.id_pemasok = pemasok.id_pemasok 
            ORDER BY createddate DESC LIMIT 1";
    
} else if ($kode == '5555') {
    $sql = "SELECT 
                hutang.*, 
                pemasok.nama, 
                pemasok.alamat,
                pemasok.kota, pemasok.kodepos,
                (
                    SELECT COUNT(*) FROM hutang JOIN pemasok ON hutang.id_pemasok = pemasok.id_pemasok WHERE
                    (
                        hutang.no_nota LIKE '%$search%'
                        OR
                        pemasok.nama LIKE '%$search%'
                    )
                ) as totaldata 
            FROM hutang 
            JOIN pemasok ON hutang.id_pemasok = pemasok.id_pemasok
            WHERE
            (
                hutang.no_nota LIKE '%$search%'
                OR
                pemasok.nama LIKE '%$search%'
            )
            ORDER BY CREATEDDATE
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