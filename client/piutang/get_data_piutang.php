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

if ($kode == '1111') {
    $sqlall = "SELECT 
                    pelanggan.id_pelanggan, 
                    pelanggan.nama, 	
                    pelanggan.kontak,
                    pelanggan.telepon,
                    pelanggan.alamat, 
                    pelanggan.kota,
                    pelanggan.kodepos,
                    penjualan.id_penjualan,
                    penjualan.no_faktur,  
                    penjualan.jatuh_tempo,

                    ifnull(SUM(penjualan.total), 0) as total, 
                    ifnull(SUM(penjualan.bayar), 0) as bayar,
                    ifnull(SUM(penjualan.kembali), 0) as kembali,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(piutang.jumlah_pembayaran_piutang, 0) as jumlah_pembayaran_piutang
                FROM 
                    pelanggan
                JOIN
                    penjualan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
                LEFT JOIN
                (
                    SELECT penjualan.id_pelanggan, SUM(retur_jual.total) as jumlah_retur 
                    FROM retur_jual
                    JOIN penjualan ON retur_jual.id_penjualan = penjualan.id_penjualan
                    WHERE penjualan.islunas = 0
                    GROUP BY penjualan.id_pelanggan
                ) as retur ON pelanggan.id_pelanggan = retur.id_pelanggan
                LEFT JOIN
                (
                    SELECT p.id_pelanggan, p.id_penjualan, SUM(pd.total) as jumlah_pembayaran_piutang
                    FROM penjualan p JOIN piutang_detail pd ON p.id_penjualan = pd.id_penjualan
                    JOIN piutang pi ON pi.id_piutang = pd.id_piutang
                    WHERE p.islunas = 0
                    GROUP BY p.id_pelanggan
                ) as piutang ON pelanggan.id_pelanggan = piutang.id_pelanggan
                WHERE
                    pelanggan.status = 1
                    AND
                    penjualan.islunas = 0
                GROUP BY 
                    penjualan.id_pelanggan
                HAVING
                    (total - bayar - jumlah_retur - jumlah_pembayaran_piutang + kembali) > 0";

    $sql = "SELECT 
                    pelanggan.id_pelanggan, 
                    pelanggan.nama, 	
                    pelanggan.kontak,
                    pelanggan.telepon,
                    pelanggan.alamat, 
                    pelanggan.kota,
                    pelanggan.kodepos,
                    penjualan.id_penjualan,
                    penjualan.no_faktur,  
                    penjualan.jatuh_tempo,

                    ifnull(SUM(penjualan.total), 0) as total, 
                    ifnull(SUM(penjualan.bayar), 0) as bayar,
                    ifnull(SUM(penjualan.kembali), 0) as kembali,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(piutang.jumlah_pembayaran_piutang, 0) as jumlah_pembayaran_piutang
                FROM 
                    pelanggan
                JOIN
                    penjualan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
                LEFT JOIN
                (
                    SELECT penjualan.id_pelanggan, SUM(retur_jual.total) as jumlah_retur 
                    FROM retur_jual
                    JOIN penjualan ON retur_jual.id_penjualan = penjualan.id_penjualan
                    WHERE penjualan.islunas = 0
                    GROUP BY penjualan.id_pelanggan
                ) as retur ON pelanggan.id_pelanggan = retur.id_pelanggan
                LEFT JOIN
                (
                    SELECT p.id_pelanggan, p.id_penjualan, SUM(pd.total) as jumlah_pembayaran_piutang
                    FROM penjualan p JOIN piutang_detail pd ON p.id_penjualan = pd.id_penjualan
                    JOIN piutang pi ON pi.id_piutang = pd.id_piutang
                    WHERE p.islunas = 0
                    GROUP BY p.id_pelanggan
                ) as piutang ON pelanggan.id_pelanggan = piutang.id_pelanggan
                WHERE
                    pelanggan.status = 1
                    AND
                    penjualan.islunas = 0
                GROUP BY 
                    penjualan.id_pelanggan
                HAVING
                    (total - bayar - jumlah_retur - jumlah_pembayaran_piutang + kembali) > 0
                LIMIT $cur_pos, $lim";
    
} else if ($kode == '1112') {
    $sqlall = "SELECT 
                    pelanggan.id_pelanggan, 
                    pelanggan.nama, 	
                    pelanggan.kontak,
                    pelanggan.telepon,
                    pelanggan.alamat, 
                    pelanggan.kota,
                    pelanggan.kodepos,
                    penjualan.id_penjualan,
                    penjualan.no_faktur,   
                    penjualan.jatuh_tempo,

                    ifnull(SUM(penjualan.total), 0) as total, 
                    ifnull(SUM(penjualan.bayar), 0) as bayar,
                    ifnull(SUM(penjualan.kembali), 0) as kembali,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(piutang.jumlah_piutang, 0) as jumlah_pembayaran_piutang
                FROM 
                    pelanggan
                JOIN
                    penjualan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
                LEFT JOIN
                (
                    SELECT id_penjualan, SUM(retur_jual.total) as jumlah_retur 
                    FROM retur_jual  
                    GROUP BY retur_jual.id_penjualan
                ) as retur ON penjualan.id_penjualan = retur.id_penjualan
                LEFT JOIN
                (
                    SELECT 
                        piutang_detail.id_penjualan, SUM(piutang_detail.total) as jumlah_piutang
                    FROM 
                        piutang_detail
                    GROUP BY
                        piutang_detail.id_penjualan
                ) as piutang ON penjualan.id_penjualan = piutang.id_penjualan
                WHERE
                    pelanggan.status = 1
                    AND
                    pelanggan.id_pelanggan = $id
                    AND 
                    penjualan.islunas = 0
                GROUP BY 
                    penjualan.id_penjualan
                HAVING
                    (total - bayar - jumlah_retur - jumlah_pembayaran_piutang + kembali) <> 0";
    
    $sql = "SELECT 
                    pelanggan.id_pelanggan, 
                    pelanggan.nama, 	
                    pelanggan.kontak,
                    pelanggan.telepon,
                    pelanggan.alamat, 
                    pelanggan.kota,
                    pelanggan.kodepos,
                    penjualan.id_penjualan,
                    penjualan.no_faktur,   
                    penjualan.jatuh_tempo,

                    ifnull(SUM(penjualan.total), 0) as total, 
                    ifnull(SUM(penjualan.bayar), 0) as bayar,
                    ifnull(SUM(penjualan.kembali), 0) as kembali,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(piutang.jumlah_piutang, 0) as jumlah_pembayaran_piutang
                FROM 
                    pelanggan
                JOIN
                    penjualan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
                LEFT JOIN
                (
                    SELECT id_penjualan, SUM(retur_jual.total) as jumlah_retur 
                    FROM retur_jual  
                    GROUP BY retur_jual.id_penjualan
                ) as retur ON penjualan.id_penjualan = retur.id_penjualan
                LEFT JOIN
                (
                    SELECT 
                        piutang_detail.id_penjualan, SUM(piutang_detail.total) as jumlah_piutang
                    FROM 
                        piutang_detail
                    GROUP BY
                        piutang_detail.id_penjualan
                ) as piutang ON penjualan.id_penjualan = piutang.id_penjualan
                WHERE
                    pelanggan.status = 1
                    AND
                    pelanggan.id_pelanggan = $id
                    AND 
                    penjualan.islunas = 0
                GROUP BY 
                    penjualan.id_penjualan
                HAVING
                    (total - bayar - jumlah_retur - jumlah_pembayaran_piutang + kembali) <> 0
                LIMIT $cur_pos, $lim";
}

if ($kode == '5555') {
    $sqlall = "SELECT 
                    pelanggan.id_pelanggan, 
                    pelanggan.nama, 	
                    pelanggan.kontak,
                    pelanggan.telepon,
                    pelanggan.alamat, 
                    pelanggan.kota,
                    pelanggan.kodepos,
                    penjualan.id_penjualan,
                    penjualan.no_faktur,  
                    penjualan.jatuh_tempo,

                    ifnull(SUM(penjualan.total), 0) as total, 
                    ifnull(SUM(penjualan.bayar), 0) as bayar,
                    ifnull(SUM(penjualan.kembali), 0) as kembali,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(piutang.jumlah_pembayaran_piutang, 0) as jumlah_pembayaran_piutang
                FROM 
                    pelanggan
                JOIN
                    penjualan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
                LEFT JOIN
                (
                    SELECT penjualan.id_pelanggan, SUM(retur_jual.total) as jumlah_retur 
                    FROM retur_jual
                    JOIN penjualan ON retur_jual.id_penjualan = penjualan.id_penjualan
                    WHERE penjualan.islunas = 0
                    GROUP BY penjualan.id_pelanggan
                ) as retur ON pelanggan.id_pelanggan = retur.id_pelanggan
                LEFT JOIN
                (
                    SELECT p.id_pelanggan, p.id_penjualan, SUM(pd.total) as jumlah_pembayaran_piutang
                    FROM penjualan p JOIN piutang_detail pd ON p.id_penjualan = pd.id_penjualan
                    JOIN piutang pi ON pi.id_piutang = pd.id_piutang
                    WHERE p.islunas = 0
                    GROUP BY p.id_pelanggan
                ) as piutang ON pelanggan.id_pelanggan = piutang.id_pelanggan
                WHERE
                    pelanggan.status = 1
                    AND
                    penjualan.islunas = 0
                    AND
                    pelanggan.nama LIKE '%$search%'
                GROUP BY 
                    penjualan.id_pelanggan
                HAVING
                    (total - bayar - jumlah_retur - jumlah_pembayaran_piutang + kembali) > 0";

    $sql = "SELECT 
                    pelanggan.id_pelanggan, 
                    pelanggan.nama, 	
                    pelanggan.kontak,
                    pelanggan.telepon,
                    pelanggan.alamat, 
                    pelanggan.kota,
                    pelanggan.kodepos,
                    penjualan.id_penjualan,
                    penjualan.no_faktur,  
                    penjualan.jatuh_tempo,

                    ifnull(SUM(penjualan.total), 0) as total, 
                    ifnull(SUM(penjualan.bayar), 0) as bayar,
                    ifnull(SUM(penjualan.kembali), 0) as kembali,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(piutang.jumlah_pembayaran_piutang, 0) as jumlah_pembayaran_piutang
                FROM 
                    pelanggan
                JOIN
                    penjualan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
                LEFT JOIN
                (
                    SELECT penjualan.id_pelanggan, SUM(retur_jual.total) as jumlah_retur 
                    FROM retur_jual
                    JOIN penjualan ON retur_jual.id_penjualan = penjualan.id_penjualan
                    WHERE penjualan.islunas = 0
                    GROUP BY penjualan.id_pelanggan
                ) as retur ON pelanggan.id_pelanggan = retur.id_pelanggan
                LEFT JOIN
                (
                    SELECT p.id_pelanggan, p.id_penjualan, SUM(pd.total) as jumlah_pembayaran_piutang
                    FROM penjualan p JOIN piutang_detail pd ON p.id_penjualan = pd.id_penjualan
                    JOIN piutang pi ON pi.id_piutang = pd.id_piutang
                    WHERE p.islunas = 0
                    GROUP BY p.id_pelanggan
                ) as piutang ON pelanggan.id_pelanggan = piutang.id_pelanggan
                WHERE
                    pelanggan.status = 1
                    AND
                    penjualan.islunas = 0
                    AND
                    pelanggan.nama LIKE '%$search%'
                GROUP BY 
                    penjualan.id_pelanggan
                HAVING
                    (total - bayar - jumlah_retur - jumlah_pembayaran_piutang + kembali) > 0
            LIMIT $cur_pos, $lim";
}

$result = mysql_query($sql);
$result2 = mysql_query($sqlall);
$totalrow = mysql_num_rows($result);
$totalrow2 = mysql_num_rows($result2);


if ($totalrow <= 0) {
    $json['data'][] = array(
        'totalrow' => 0
    );
} else {
    while ($row = mysql_fetch_array($result)) {
        $json['data'][] = array(
            'id_pelanggan' => $row['id_pelanggan'],
            'id_penjualan' => $row['id_penjualan'],
            'no_faktur' => $row['no_faktur'],
            'jatuh_tempo' => $row['jatuh_tempo'],
            'nama' => $row['nama'],
            'kontak' => $row['kontak'],
            'telepon' => $row['telepon'],
            'alamat' => $row['alamat'],
            'kota' => $row['kota'],
            'kodepos' => $row['kodepos'],
            'total' => $row['total'],
            'bayar' => $row['bayar'],
            'kembali' => $row['kembali'],
            'jumlah_pembayaran_piutang' => $row['jumlah_pembayaran_piutang'],
            'jumlah_retur' => $row['jumlah_retur'],
            'totalrow' => $totalrow,
            'totaldata' => $totalrow2
        );
    }
}

echo json_encode($json);
?>