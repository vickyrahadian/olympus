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
    $idpenjualan[] = '';
    $jumlahbayar[] = '';
    $lunas[] = 0;
    $debit = 0;
    $bayar = 0;
    $kembali = 0;
    $status_pembayaran = 0;

    for ($i = 1; $i < $banyakdata; $i++) {
        $idpenjualan[$i] = $data[$i][0];
        $jumlahbayar[$i] = $data[$i][1];
        $lunas[$i] = $data[$i][2];
        $sisa[$i] = $data[$i][3];
    }

    for ($i = 1; $i < $banyakdata; $i++) {
        if ($jumlahbayar[$i] <> 0) {
            $sql = "INSERT INTO piutang_detail VALUES(NULL, $id, $idpenjualan[$i], $jumlahbayar[$i], $sisa[$i])";
            mysql_query($sql);
        }

        if ($lunas[$i] == 1) {
            $sql = "UPDATE penjualan SET islunas = $lunas[$i] WHERE id_penjualan = $idpenjualan[$i]";
            mysql_query($sql);
        }        
    }

   

    $sql = "SELECT 
            k.*,
            p.no_faktur,
            p.total as totalpenjualan,
            (
                SELECT COUNT(*) FROM piutang_detail WHERE id_piutang = $id
            ) AS totaldata 
                FROM penjualan p JOIN piutang_detail k ON p.id_penjualan = k.id_penjualan
                WHERE id_piutang = $id";
}

if ($kode == '5557') {
    $sql = "SELECT 
            k.*,
            p.no_faktur,
            p.total as totalpenjualan,
            (
                SELECT COUNT(*) FROM piutang_detail WHERE id_piutang = $id
            ) AS totaldata 
                FROM penjualan p JOIN piutang_detail k ON p.id_penjualan = k.id_penjualan
                WHERE id_piutang = $id";
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
            'id_piutangdetail' => $row['id_piutangdetail'],
            'id_piutang' => $row['id_piutang'],
            'id_penjualan' => $row['id_penjualan'],
            'total' => $row['total'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata'],
            'no_faktur' => $row['no_faktur'],
            'totalpenjualan' => $row['totalpenjualan']
        );
    }
}

echo json_encode($json);
?>