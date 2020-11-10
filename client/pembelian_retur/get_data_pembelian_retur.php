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
    $sql = "SELECT r.*, p.no_faktur as nofakturpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_beli) as totaldata
            FROM retur_beli r
            JOIN pembelian p ON p.id_pembelian = r.id_pembelian
            JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
            ORDER BY r.createddate DESC
            LIMIT $cur_pos, $lim";
}

if ($kode == '4444') {

    //AMBIL MAX ID
    $last_id = '';
    $todaydate = date('Y') . date('m') . date('d');

    $sqlgetmaxid = "SELECT MAX(id_returbeli) as maxid FROM retur_beli";
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

    $no_nota = 'PJ/3/' . $todaydate . '/' . $last_id;

    //accounting
    $islunas = 0;
    $status_pembayaran = 0;
    $subtotal = 0;
    $biaya_kirim = 0;
    $bayar = 0;
    $total_retur = 0;
    $total_bayar_hutang = 0;
    $sisa_hutang = 0;

    $sqlcek = "SELECT * FROM pembelian WHERE id_pembelian = $id";
    $result = mysql_query($sqlcek);
    while ($row = mysql_fetch_array($result)) {
        $islunas = $row['islunas'];
        $status_pembayaran = $row['status_pembayaran'];
        $subtotal = $row['subtotal'];
        $biaya_kirim = $row['biaya_kirim']; 
        $bayar = $row['bayar'];
    }

    $sqlcek = "SELECT ifnull(SUM(total), 0) as total FROM hutang_detail WHERE id_pembelian = $id";
    $result = mysql_query($sqlcek);
    $row = mysql_fetch_array($result);
    $total_bayar_hutang = $row['total'];

    $sqlcek = "SELECT ifnull(SUM(total), 0) as total FROM retur_beli WHERE id_pembelian = $id";
    $result = mysql_query($sqlcek);
    $row = mysql_fetch_array($result);
    $total_retur = $row['total'];

    $bayar = $bayar + $total_bayar_hutang + $total_retur;
    $hutang = $subtotal + $biaya_kirim;
    $sisahutang = $hutang - $bayar;

    if ($status_pembayaran == 1 or $islunas == 1) {
        $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returbeli`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, 123456, NOW(), $total, 0, $user)";
        $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returbeli`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, 123456, NOW(), 0, $total, $user)";
        mysql_query($sqldeb);
        mysql_query($sqlkre);
    } else {
        if (($total - $sisahutang) > 0) {
            $sqldeb2 = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returbeli`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (4, 123456, NOW(), $sisahutang, 0, $user)";
            $sqldeb  = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returbeli`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, 123456, NOW(), ($total - $sisahutang), 0, $user)";
            $sqlkre  = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returbeli`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, 123456, NOW(), 0, $total, $user)";            
            mysql_query($sqldeb2);
            mysql_query($sqldeb);
            mysql_query($sqlkre);
        } else {
            $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returbeli`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (4, 123456, NOW(), $total, 0, $user)";
            $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returbeli`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, 123456, NOW(), 0, $total, $user)";
            mysql_query($sqldeb);
            mysql_query($sqlkre);
        }
    }

    // end accounting
    //insert ke retur_beli
    $sqlinsert = "INSERT INTO retur_beli (no_nota, tanggal_retur, total, keterangan, id_pembelian, createdby) VALUES ('$no_nota', CURRENT_TIMESTAMP, $total, '$keterangan', $id, $user)";
    mysql_query($sqlinsert);
    
    $sqlcek = "SELECT max(id_returbeli) as maxid FROM retur_beli";
    $result = mysql_query($sqlcek);
    $row = mysql_fetch_array($result);
    $id_returbeli = $row['maxid'];
    
    //update idreturbeli pada accounting
    $sql = "UPDATE jurnal_umum SET id_returbeli = $id_returbeli WHERE id_returbeli = 123456";
    mysql_query($sql);

    $subtotal = 0;
    $bayar = 0;
    $retur = 0;
    $hutang = 0;
    $sisa = 0;

    $sqlsumpembelian = "SELECT subtotal, bayar FROM pembelian WHERE id_pembelian = $id";
    $run = mysql_query($sqlsumpembelian);
    while ($row = mysql_fetch_array($run)) {
        $subtotal = $row['subtotal'];
        $bayar = $row['bayar'];
    }

    $sqlsumreturbeli = "SELECT ifnull(SUM(total), 0) as total_retur FROM retur_beli WHERE id_pembelian = $id";
    $run = mysql_query($sqlsumreturbeli);
    $row = mysql_fetch_array($run);
    $retur = $row['total_retur'];    

    $sqlsumkreditbeli = "SELECT ifnull(SUM(total), 0) as hutang FROM hutang_detail WHERE id_pembelian = $id";
    $run = mysql_query($sqlsumkreditbeli);
    $row = mysql_fetch_array($run);
    $hutang = $row['hutang'];

    $sisa = $subtotal - $bayar - $retur - $hutang;

    if ($sisa > 0) {
        $sqlupdate = "UPDATE pembelian SET islunas = 0 WHERE id_pembelian = $id";
        mysql_query($sqlupdate);
    } else {
        $sqlupdate = "UPDATE pembelian SET islunas = 1 WHERE id_pembelian = $id";
        mysql_query($sqlupdate);
    }

    $sql = "SELECT r.*, p.no_faktur as nofakturpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos,  (SELECT COUNT(*) FROM retur_beli) as totaldata
            FROM retur_beli r
            JOIN pembelian p ON p.id_pembelian = r.id_pembelian
            JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
            ORDER BY r.createddate DESC
            LIMIT 1";
}

if ($kode == '5555') {
    $sql = "SELECT r.*, p.no_faktur as nofakturpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos, 
    (
        SELECT COUNT(*) 
        FROM retur_beli r
        JOIN pembelian p ON p.id_pembelian = r.id_pembelian
        JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
        WHERE 
        (
            r.no_nota LIKE '%$search%'
            OR
            p.no_faktur LIKE '%$search%'
            OR
            pe.nama LIKE '%$search%'
        )									
    ) as totaldata
    FROM retur_beli r
    JOIN pembelian p ON p.id_pembelian = r.id_pembelian
    JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
    WHERE 
    (
        r.no_nota LIKE '%$search%'
        OR
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