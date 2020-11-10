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

@$idreturjual = $data[0][2];
@$idpelanggan = $data[0][3];
@$idpenjualan = $data[0][4];
@$banyakdata = sizeof($data);


if ($kode == '5557') {

    $sql = "SELECT r.*, b.nama as namabarang, b.kode as kodebarang,
            (
                SELECT COUNT(*) FROM retur_jual_detail WHERE id_returjual = $idreturjual
            ) as totaldata
            FROM retur_jual_detail r
            JOIN barang b ON r.id_barang = b.id_barang
            WHERE r.id_returjual = $idreturjual";
}

if ($kode == '4444') {

    $id_persediaan[] = '';
    $id_barang[] = '';
    $jumlah[] = '';
    $harga[] = '';

    $jumlahretur = 0;
    $jumlahhpp = 0;

    for ($i = 1; $i < $banyakdata; $i++) {
        $id_persediaan[$i] = $data[$i][0];
        $jumlah[$i] = $data[$i][1];
        $harga[$i] = $data[$i][2];
        $id_barang[$i] = $data[$i][3];
    }

    for ($i = 1; $i < $banyakdata; $i++) {
        if ($jumlah[$i] > 0) {
            $idpersediaans = $id_persediaan[$i];
            $jumlahs = $jumlah[$i];
            $hargas = $harga[$i];
            $idbarangs = $id_barang[$i];

            $sql = "SELECT * FROM barang_persediaan WHERE id_barangpersediaan = $idpersediaans";
            $row = mysql_fetch_array(mysql_query($sql));
            $hpp = $row['harga'];

            mysql_query("INSERT INTO `retur_jual_detail`(`id_returjual`, `id_barang`, `harga`, `jumlah`) VALUES ($idreturjual, $idbarangs, $hargas, $jumlahs)");
            mysql_query("UPDATE barang SET stok = stok + $jumlahs WHERE id_barang = $idbarangs");
            mysql_query("INSERT INTO `barang_transaksi`(`id_pelanggan`, `id_kategori`, `id_penjualan`, `id_returjual`, `id_barang`, `jumlah_masuk`, `harga`, `createdby`) VALUES ($idpelanggan, 4, $idpenjualan, $idreturjual, $idbarangs, $jumlahs, $hargas, $user)");
            mysql_query("UPDATE barang_persediaan SET stok_sisa = stok_sisa + $jumlahs WHERE id_barangpersediaan = $idpersediaans");
            mysql_query("UPDATE penjualan_detail SET retur = retur + $jumlahs WHERE id_persediaan = $idpersediaans");

            $jumlahretur += ($hargas * $jumlahs);
            $jumlahhpp += ($hpp * $jumlahs);
        }
    }

    //accounting
    $islunas = 0;
    $status_pembayaran = 0;
    $subtotal = 0;
    $biaya_kirim = 0;
    $bayar = 0;
    $kembali = 0;
    $total_retur = 0;
    $total_bayar_hutang = 0;
    $sisa_hutang = 0;

    $sqlcek = "SELECT * FROM penjualan WHERE id_penjualan = $id";
    $result = mysql_query($sqlcek);
    while ($row = mysql_fetch_array($result)) {
        $islunas = $row['islunas'];
        $status_pembayaran = $row['status_pembayaran'];
        $subtotal = $row['subtotal'];
        $biaya_kirim = $row['biaya_kirim'];
        $bayar = $row['bayar'];
        $kembali = $row['kembali'];
    }

    $sqlcek = "SELECT ifnull(SUM(total), 0) as total FROM piutang_detail WHERE id_penjualan = $id";
    $result = mysql_query($sqlcek);
    $row = mysql_fetch_array($result);
    $total_bayar_piutang = $row['total']; 

    $sqlcek = "SELECT ifnull(SUM(total), 0) as total FROM retur_jual WHERE id_penjualan = $id";
    $result = mysql_query($sqlcek);
    $row = mysql_fetch_array($result);
    $total_retur = $row['total']; 

    $bayar = ($bayar - $kembali) + $total_bayar_piutang + $total_retur - $jumlahretur;
    $hutang = $subtotal + $biaya_kirim;
    $sisahutang = $hutang - $bayar; 
    
    if ($status_pembayaran == 1 or $islunas == 1) {
        $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (6, $idreturjual, NOW(), $jumlahretur, 0, $user)";
        $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $idreturjual, NOW(), 0, $jumlahretur, $user)";
        mysql_query($sqldeb);
        mysql_query($sqlkre);
    } else {
        if (($jumlahretur - $sisahutang) > 0) {
            $sqldeb2 = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (6, $idreturjual, NOW(), $jumlahretur, 0, $user)";
            $sqldeb  = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $idreturjual, NOW(), 0, ($jumlahretur - $sisahutang), $user)";
            $sqlkre  = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (2, $idreturjual, NOW(), 0, $sisahutang, $user)";
            mysql_query($sqldeb2);
            mysql_query($sqldeb);
            mysql_query($sqlkre);
        } else {
            $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (6, $idreturjual, NOW(), $jumlahretur, 0, $user)";
            $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (2, $idreturjual, NOW(), 0, $jumlahretur, $user)";
            mysql_query($sqldeb);
            mysql_query($sqlkre);
        }
    }

    $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, $idreturjual, NOW(), $jumlahhpp, 0, $user)";
    $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_returjual`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (11, $idreturjual, NOW(), 0, $jumlahhpp, $user)";
    mysql_query($sqldeb);
    mysql_query($sqlkre);

    // end accounting

    // cek status lunas
    
    $total = 0;
    $bayar = 0;
    $kembali = 0;
    $retur = 0;
    $piutang = 0;
    $sisa = 0;

    $sqlsumpenjualan = "SELECT total, bayar, kembali FROM penjualan WHERE id_penjualan = $idpenjualan";
    $run = mysql_query($sqlsumpenjualan);
    while ($row = mysql_fetch_array($run)) {
        $total = $row['total'];
        $bayar = $row['bayar'];
        $kembali = $row['kembali'];
    }

    $sqlsumreturbeli = "SELECT SUM(total) as total_retur FROM retur_jual WHERE id_penjualan = $idpenjualan";
    $run = mysql_query($sqlsumreturbeli);
    $row = mysql_fetch_array($run);
    $retur = $row['total_retur'];

    $sqlsumkreditbeli = "SELECT SUM(total) as piutang FROM piutang_detail WHERE id_penjualan = $idpenjualan";
    $run = mysql_query($sqlsumkreditbeli);
    $row = mysql_fetch_array($run);
    $piutang = $row['piutang'];
    
    $sisa = $total - $bayar - $retur - $piutang + $kembali;

    if ($sisa > 0) {
        $sqlupdate = "UPDATE penjualan SET islunas = 0 WHERE id_penjualan = $idpenjualan";
        mysql_query($sqlupdate);
    } else {
        $sqlupdate = "UPDATE penjualan SET islunas = 1 WHERE id_penjualan = $idpenjualan";
        mysql_query($sqlupdate);
    }
    
    // end cek status lunas
    
    $sql = "SELECT r.*, b.nama as namabarang, b.kode as kodebarang,
            (
                    SELECT COUNT(*) FROM retur_jual_detail WHERE id_returjual = $idreturjual
            ) as totaldata
            FROM retur_jual_detail r
            JOIN barang b ON r.id_barang = b.id_barang 
            WHERE r.id_returjual = $idreturjual";
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
            'id_returjualdetail' => $row['id_returjualdetail'],
            'id_returjual' => $row['id_returjual'],
            'id_barang' => $row['id_barang'],
            'harga' => $row['harga'],
            'jumlah' => $row['jumlah'],
            'namabarang' => $row['namabarang'],
            'kodebarang' => $row['kodebarang'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>