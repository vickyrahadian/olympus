<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT SEMUA
//1114 = SELECT DROPDOWN
//2222 = UPDATE
//3333 = DELETE
//4444 = INSERT
//5555 = SEARCHSIMPLE AKTIF
//5556 = SEARCHSIMPLE TIDAK AKTIF
//5557 = SEARCHSIMPLE ON LIMIT
//6666 = SEARCHCOMPLEX
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

@$cur_pos = ($hal - 1) * $lim;
@$banyakdata = sizeof($data);

if ($kode == '4444') {
    $idpembelian[] = '';
    $jumlahbayar[] = '';
    $lunas[] = 0;
    $debit = 0;
    $uang_muka = 0;
    $status_pembayaran = 0;

    for ($i = 1; $i < $banyakdata; $i++) {
        $idpembelian[$i] = $data[$i][0];
        $jumlahbayar[$i] = $data[$i][1];
        $lunas[$i] = $data[$i][2];
        $sisa[$i] = $data[$i][3];
    }

    for ($i = 1; $i < $banyakdata; $i++) {
        if ($jumlahbayar[$i] <> 0) {
            $sql = "INSERT INTO hutang_detail VALUES(NULL, $id, $idpembelian[$i], $jumlahbayar[$i], $sisa[$i])";
            mysql_query($sql);
        }

        if ($lunas[$i] == 1) {
            $sql = "UPDATE pembelian SET islunas = $lunas[$i] WHERE id_pembelian = $idpembelian[$i]";
            mysql_query($sql);
        }
    }

    $sql = "SELECT 
                k.*,
                p.no_nota,
                p.total as totalpembelian,
                (
                    SELECT COUNT(*) FROM hutang_detail WHERE id_hutang= $id
                ) AS totaldata 
            FROM pembelian p JOIN hutang_detail k ON p.id_pembelian = k.id_pembelian
            WHERE id_hutang = $id";
}

if ($kode == '5557') {
    $sql = "SELECT 
                k.*,
                p.no_nota,
                p.total as totalpembelian,
                (
                    SELECT COUNT(*) FROM hutang_detail WHERE id_hutang = $id
                ) AS totaldata 
            FROM pembelian p JOIN hutang_detail k ON p.id_pembelian = k.id_pembelian
            WHERE id_hutang = $id";
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
            'id_hutangdetail' => $row['id_hutangdetail'],
            'id_hutang' => $row['id_hutang'],
            'id_pembelian' => $row['id_pembelian'],
            'total' => $row['total'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata'],
            'no_nota' => $row['no_nota'],
            'totalpembelian' => $row['totalpembelian']
        );
    }
}

echo json_encode($json);
?>