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
        $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM pembelian     
                WHERE id_pemasok = $id
            ) as totaldata 
            FROM pembelian pemb, pemasok pema
            WHERE pemb.id_pemasok = pema.id_pemasok 
            AND pemb.id_pemasok = $id
            ORDER BY tanggal_pembelian DESC
            LIMIT $cur_pos, $lim";
    } else {
        $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM pembelian                        
            ) as totaldata 
            FROM pembelian pemb, pemasok pema
            WHERE pemb.id_pemasok = pema.id_pemasok 
            ORDER BY tanggal_pembelian DESC
            LIMIT $cur_pos, $lim";
    }
} else if ($kode == '1112') {
    if ($id > 0) {
        $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos ,
            (
                SELECT COUNT(*) 
                FROM pembelian pemb, pemasok pema
                WHERE pemb.id_pemasok = pema.id_pemasok 
                AND pemb.tanggal_pembelian between '$tanggal_mulai' and '$tanggal_akhir'
                AND pemb.id_pemasok = $id
            ) as totaldata 
            FROM pembelian pemb, pemasok pema
            WHERE pemb.id_pemasok = pema.id_pemasok 
            AND pemb.tanggal_pembelian between '$tanggal_mulai' and '$tanggal_akhir'
            AND pemb.id_pemasok = $id
            ORDER BY tanggal_pembelian DESC
            LIMIT $cur_pos, $lim";
    } else {
        $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos ,
            (
                SELECT COUNT(*) 
                FROM pembelian pemb, pemasok pema
                WHERE pemb.id_pemasok = pema.id_pemasok 
                AND pemb.tanggal_pembelian between '$tanggal_mulai' and '$tanggal_akhir'
            ) as totaldata 
            FROM pembelian pemb, pemasok pema
            WHERE pemb.id_pemasok = pema.id_pemasok 
            AND pemb.tanggal_pembelian between '$tanggal_mulai' and '$tanggal_akhir'
            ORDER BY tanggal_pembelian DESC
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
            'id_pembelian' => $row['id_pembelian'],
            'no_nota' => $row['no_nota'],
            'no_faktur' => $row['no_faktur'],
            'subtotal' => $row['subtotal'],
            'biaya_kirim' => $row['biaya_kirim'],
            'biaya_lain' => $row['biaya_lain'],
            'biaya_pajak' => $row['biaya_pajak'],
            'total' => $row['total'],
            'uang_muka' => $row['uang_muka'],
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