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
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan
                WHERE id_pelanggan = $id
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan
            AND penj.id_pelanggan = $id
            ORDER BY tanggal_penjualan DESC
            LIMIT $cur_pos, $lim";
    } else {
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan 
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan 
            ORDER BY tanggal_penjualan DESC
            LIMIT $cur_pos, $lim";
    }
} else if ($kode == '1112') {
    if ($id > 0) {
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan penj, pelanggan pela
                WHERE penj.id_pelanggan = pela.id_pelanggan
                AND penj.tanggal_penjualan between '$tanggal_mulai' and '$tanggal_akhir'
                AND penj.id_pelanggan = $id
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan
            AND penj.tanggal_penjualan between '$tanggal_mulai' and '$tanggal_akhir'
            AND penj.id_pelanggan = $id
            ORDER BY tanggal_penjualan DESC
            LIMIT $cur_pos, $lim";
        
  
    } else {
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan penj, pelanggan pela
                WHERE penj.id_pelanggan = pela.id_pelanggan
                AND penj.tanggal_penjualan between '$tanggal_mulai' and '$tanggal_akhir'
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan
            AND penj.tanggal_penjualan between '$tanggal_mulai' and '$tanggal_akhir' 
            ORDER BY tanggal_penjualan DESC
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
            'id_penjualan' => $row['id_penjualan'],
            'no_faktur' => $row['no_faktur'],
            'subtotal' => $row['subtotal'],
            'biaya_kirim' => $row['biaya_kirim'], 
            'total' => $row['total'],
            'bayar' => $row['bayar'],
            'kembali' => $row['kembali'],
            'status_pembayaran' => $row['status_pembayaran'],
            'keterangan' => $row['keterangan'],
            'id_pelanggan' => $row['id_pelanggan'],
            'tanggal_penjualan' => $row['tanggal_penjualan'],
            'jatuh_tempo' => $row['jatuh_tempo'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'islunas' => $row['islunas'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>