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
 
$no_faktur = $data[0][3];
$subtotal = $data[0][4];
$biaya_kirim = $data[0][5]; 
$total = $data[0][8];
$bayar = $data[0][9];
$status_pembayaran = $data[0][10];
$keterangan = $data[0][11];
$id_pemasok = $data[0][12];
$tanggal_pembelian = $data[0][13];
$jatuh_tempo = $data[0][14];
$id_po = $data[0][15]; 

if ($kode == '1111') {
    $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM pembelian                        
            ) as totaldata 
            FROM pembelian pemb, pemasok pema
            WHERE pemb.id_pemasok = pema.id_pemasok 
            ORDER BY tanggal_pembelian DESC
            LIMIT $cur_pos, $lim";
} else if ($kode == '4444') {

    //AMBIL MAX ID
    $last_id = '';
    $todaydate = date('Y') . date('m') . date('d');

    $sqlgetmaxid = "SELECT MAX(id_pembelian) as maxid FROM pembelian;";
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

    $no_nota = 'PJ/1/' . $todaydate . '/' . $last_id;

    if($id_po > 0){
        $sqlinsert = "INSERT INTO `pembelian`(`no_nota`, `no_faktur`, `subtotal`, `biaya_kirim`, `total`, `bayar`, `status_pembayaran`, `keterangan`, `id_pemasok`, `tanggal_pembelian`, `jatuh_tempo`, `createdby`, `islunas`, `id_purchaseorder`) VALUES ('$no_nota', '$no_faktur', $subtotal, $biaya_kirim, $total, $bayar, $status_pembayaran, '$keterangan', $id_pemasok, '$tanggal_pembelian', '$jatuh_tempo', $user, $status_pembayaran, $id_po)";
        $sqlupdatepo = "UPDATE purchase_order SET isaccepted = '1' WHERE id_purchaseorder = $id_po";
        mysql_query($sqlupdatepo);
    } else {
        $sqlinsert = "INSERT INTO `pembelian`(`no_nota`, `no_faktur`, `subtotal`, `biaya_kirim`, `total`, `bayar`, `status_pembayaran`, `keterangan`, `id_pemasok`, `tanggal_pembelian`, `jatuh_tempo`, `createdby`, `islunas`, `id_purchaseorder`) VALUES ('$no_nota', '$no_faktur', $subtotal, $biaya_kirim, $total, $bayar, $status_pembayaran, '$keterangan', $id_pemasok, '$tanggal_pembelian', '$jatuh_tempo', $user, $status_pembayaran, 0)";
    }

    mysql_query($sqlinsert);

    $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos , 1 as totaldata 
            FROM pembelian pemb, pemasok pema
            WHERE pemb.id_pemasok = pema.id_pemasok 
            ORDER BY createddate DESC
            LIMIT 1";
    $run = mysql_query($sql);
    $row = mysql_fetch_array($run);
    $id_pembelian = $row['id_pembelian'];
    
    
    
    //accounting
    //jurnal pembelian
    
    if($status_pembayaran == 1){
        $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, $id_pembelian, NOW(), $subtotal, 0, $user)";
        $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $id_pembelian, NOW(), 0, $subtotal, $user)";
        mysql_query($sqldeb);
        mysql_query($sqlkre);
    } else {
        $sisadana = $bayar - $biaya_kirim;
        if($sisadana == 0){
            $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, $id_pembelian, NOW(), $subtotal, 0, $user)";
            $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (4, $id_pembelian, NOW(), 0, $subtotal, $user)";
            mysql_query($sqldeb);
            mysql_query($sqlkre);
        } else {
            $sisa = $total - $sisadana;
            $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, $id_pembelian, NOW(), $subtotal, 0, $user)";
            $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $id_pembelian, NOW(), 0, $sisadana, $user)";
            mysql_query($sqldeb);
            mysql_query($sqlkre);
            $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (4, $id_pembelian, NOW(), 0, $sisa, $user)";
            mysql_query($sqlkre);
        }
    }
 
    //biaya kirim
    if($biaya_kirim > 0){        
        $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (10, $id_pembelian, NOW(), $biaya_kirim, 0, $user)";
        $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_pembelian`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $id_pembelian, NOW(), 0, $biaya_kirim, $user)";
        mysql_query($sqldeb);
        mysql_query($sqlkre);
    }
} else if ($kode == '5555') {
    $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos ,
            (
                SELECT COUNT(*) 
                FROM pembelian pemb, pemasok pema
                WHERE pemb.id_pemasok = pema.id_pemasok 
                AND
                (
                    pemb.no_nota LIKE '%$search%'
                    OR
                    pemb.no_faktur LIKE '%$search%'
                    OR
                    pema.nama LIKE '%$search%'
                )
            ) as totaldata 
            FROM pembelian pemb, pemasok pema
            WHERE pemb.id_pemasok = pema.id_pemasok 
            AND
            (
                pemb.no_nota LIKE '%$search%'
                OR
                pemb.no_faktur LIKE '%$search%'
                OR
                pema.nama LIKE '%$search%'
            )
            ORDER BY tanggal_pembelian DESC
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
            'id_pembelian' => $row['id_pembelian'],
            'no_nota' => $row['no_nota'],
            'no_faktur' => $row['no_faktur'],
            'subtotal' => $row['subtotal'],
            'biaya_kirim' => $row['biaya_kirim'],  
            'total' => $row['total'],
            'bayar' => $row['bayar'],
            'status_pembayaran' => $row['status_pembayaran'],
            'keterangan' => $row['keterangan'],
            'id_pemasok' => $row['id_pemasok'],
            'tanggal_pembelian' => $row['tanggal_pembelian'],
            'jatuh_tempo' => $row['jatuh_tempo'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'], 
            'islunas' => $row['islunas'],
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