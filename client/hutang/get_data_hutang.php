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
                    pemasok.id_pemasok, 
                    pemasok.nama, 	
                    pemasok.kontak,
                    pemasok.telepon,
                    pemasok.alamat, 
                    pemasok.kota,
                    pemasok.kodepos,
                    pembelian.id_pembelian,
                    pembelian.no_faktur,  
                    pembelian.no_nota,
                    pembelian.jatuh_tempo, 

                    ifnull(SUM(pembelian.total), 0) as total, 
                    ifnull(SUM(pembelian.bayar), 0) as bayar,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(hutang.jumlah_bayar_hutang, 0) as jumlah_bayar_hutang
                FROM 
                    pemasok
                JOIN
                    pembelian ON pemasok.id_pemasok = pembelian.id_pemasok
                LEFT JOIN
                (
                    SELECT pembelian.id_pemasok, SUM(retur_beli.total) as jumlah_retur 
                    FROM retur_beli 
                    JOIN pembelian ON retur_beli.id_pembelian = pembelian.id_pembelian
                    WHERE pembelian.islunas = 0
                    GROUP BY pembelian.id_pemasok
                ) as retur ON pemasok.id_pemasok = retur.id_pemasok
                LEFT JOIN
                (
                    SELECT p.id_pemasok, p.id_pembelian, SUM(hd.total) as jumlah_bayar_hutang
                    FROM pembelian p JOIN hutang_detail hd ON p.id_pembelian = hd.id_pembelian
                    JOIN hutang h ON h.id_hutang = hd.id_hutang
                    WHERE p.islunas = 0
                    GROUP BY h.id_pemasok
                ) as hutang ON pemasok.id_pemasok = hutang.id_pemasok
                WHERE
                    pemasok.status = 1
                    AND
                    pembelian.islunas = 0
                GROUP BY 
                    pembelian.id_pemasok
                HAVING
                    (total - bayar - jumlah_retur - jumlah_bayar_hutang) > 0";

    $sql = "SELECT 
                    pemasok.id_pemasok, 
                    pemasok.nama, 	
                    pemasok.kontak,
                    pemasok.telepon,
                    pemasok.alamat, 
                    pemasok.kota,
                    pemasok.kodepos,
                    pembelian.id_pembelian,
                    pembelian.no_faktur,  
                    pembelian.no_nota,
                    pembelian.jatuh_tempo, 

                    ifnull(SUM(pembelian.total), 0) as total, 
                    ifnull(SUM(pembelian.bayar), 0) as bayar,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(hutang.jumlah_bayar_hutang, 0) as jumlah_bayar_hutang
                FROM 
                    pemasok
                JOIN
                    pembelian ON pemasok.id_pemasok = pembelian.id_pemasok
                LEFT JOIN
                (
                    SELECT pembelian.id_pemasok, SUM(retur_beli.total) as jumlah_retur 
                    FROM retur_beli 
                    JOIN pembelian ON retur_beli.id_pembelian = pembelian.id_pembelian
                    WHERE pembelian.islunas = 0
                    GROUP BY pembelian.id_pemasok
                ) as retur ON pemasok.id_pemasok = retur.id_pemasok
                LEFT JOIN
                (
                    SELECT p.id_pemasok, p.id_pembelian, SUM(hd.total) as jumlah_bayar_hutang
                    FROM pembelian p JOIN hutang_detail hd ON p.id_pembelian = hd.id_pembelian
                    JOIN hutang h ON h.id_hutang = hd.id_hutang
                    WHERE p.islunas = 0
                    GROUP BY h.id_pemasok
                ) as hutang ON pemasok.id_pemasok = hutang.id_pemasok
                WHERE
                    pemasok.status = 1
                    AND
                    pembelian.islunas = 0
                GROUP BY 
                    pembelian.id_pemasok
                HAVING
                    (total - bayar - jumlah_retur - jumlah_bayar_hutang) > 0
                LIMIT $cur_pos, $lim";
    
} else if ($kode == '1112') {
    $sqlall = "SELECT 
                    pemasok.id_pemasok, 
                    pemasok.nama, 	
                    pemasok.kontak,
                    pemasok.telepon,
                    pemasok.alamat, 
                    pemasok.kota,
                    pemasok.kodepos,
                    pembelian.id_pembelian,
                    pembelian.no_faktur,  
                    pembelian.jatuh_tempo,
                    pembelian.no_nota,

                    ifnull(SUM(pembelian.total), 0) as total, 
                    ifnull(SUM(pembelian.bayar), 0) as bayar,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(hutang.jumlah_bayar_hutang, 0) as jumlah_bayar_hutang
                FROM 
                    pemasok
                JOIN
                    pembelian ON pemasok.id_pemasok = pembelian.id_pemasok
                LEFT JOIN
                (
                    SELECT id_pembelian, SUM(retur_beli.total) as jumlah_retur 
                    FROM retur_beli  
                    GROUP BY retur_beli.id_pembelian
                ) as retur ON pembelian.id_pembelian = retur.id_pembelian
                LEFT JOIN
                (
                    SELECT 
                        hutang_detail.id_pembelian, SUM(hutang_detail.total) as jumlah_bayar_hutang
                    FROM 
                        hutang_detail
                    GROUP BY
                        hutang_detail.id_pembelian
                ) as hutang ON pembelian.id_pembelian = hutang.id_pembelian
                WHERE
                    pemasok.status = 1
                    AND
                    pemasok.id_pemasok = $id
                    AND 
                    pembelian.islunas = 0
                GROUP BY 
                    pembelian.id_pembelian
                HAVING
                    (total - bayar - jumlah_retur - jumlah_bayar_hutang) <> 0";

    $sql = "SELECT 
                    pemasok.id_pemasok, 
                    pemasok.nama, 	
                    pemasok.kontak,
                    pemasok.telepon,
                    pemasok.alamat, 
                    pemasok.kota,
                    pemasok.kodepos,
                    pembelian.id_pembelian,
                    pembelian.no_faktur,  
                    pembelian.jatuh_tempo,
                    pembelian.no_nota,

                    ifnull(SUM(pembelian.total), 0) as total, 
                    ifnull(SUM(pembelian.bayar), 0) as bayar,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(hutang.jumlah_bayar_hutang, 0) as jumlah_bayar_hutang
                FROM 
                    pemasok
                JOIN
                    pembelian ON pemasok.id_pemasok = pembelian.id_pemasok
                LEFT JOIN
                (
                    SELECT id_pembelian, SUM(retur_beli.total) as jumlah_retur 
                    FROM retur_beli  
                    GROUP BY retur_beli.id_pembelian
                ) as retur ON pembelian.id_pembelian = retur.id_pembelian
                LEFT JOIN
                (
                    SELECT 
                        hutang_detail.id_pembelian, SUM(hutang_detail.total) as jumlah_bayar_hutang
                    FROM 
                        hutang_detail
                    GROUP BY
                        hutang_detail.id_pembelian
                ) as hutang ON pembelian.id_pembelian = hutang.id_pembelian
                WHERE
                    pemasok.status = 1
                    AND
                    pemasok.id_pemasok = $id
                    AND 
                    pembelian.islunas = 0
                GROUP BY 
                    pembelian.id_pembelian
                HAVING
                    (total - bayar - jumlah_retur - jumlah_bayar_hutang) <> 0
                LIMIT $cur_pos, $lim";
}

if ($kode == '5555') {
    $sqlall = "SELECT 
                    pemasok.id_pemasok, 
                    pemasok.nama, 	
                    pemasok.kontak,
                    pemasok.telepon,
                    pemasok.alamat, 
                    pemasok.kota,
                    pemasok.kodepos,
                    pembelian.id_pembelian,
                    pembelian.no_faktur,  
                    pembelian.no_nota,
                    pembelian.jatuh_tempo, 

                    ifnull(SUM(pembelian.total), 0) as total, 
                    ifnull(SUM(pembelian.bayar), 0) as bayar,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(hutang.jumlah_bayar_hutang, 0) as jumlah_bayar_hutang
                FROM 
                    pemasok
                JOIN
                    pembelian ON pemasok.id_pemasok = pembelian.id_pemasok
                LEFT JOIN
                (
                    SELECT pembelian.id_pemasok, SUM(retur_beli.total) as jumlah_retur 
                    FROM retur_beli 
                    JOIN pembelian ON retur_beli.id_pembelian = pembelian.id_pembelian
                    WHERE pembelian.islunas = 0
                    GROUP BY pembelian.id_pemasok
                ) as retur ON pemasok.id_pemasok = retur.id_pemasok
                LEFT JOIN
                (
                    SELECT p.id_pemasok, p.id_pembelian, SUM(hd.total) as jumlah_bayar_hutang
                    FROM pembelian p JOIN hutang_detail hd ON p.id_pembelian = hd.id_pembelian
                    JOIN hutang h ON h.id_hutang = hd.id_hutang
                    WHERE p.islunas = 0
                    GROUP BY h.id_pemasok
                ) as hutang ON pemasok.id_pemasok = hutang.id_pemasok
                WHERE
                    pemasok.status = 1
                    AND
                    pembelian.islunas = 0
                    AND
                    pemasok.nama LIKE '%$search%'
                GROUP BY 
                    pembelian.id_pemasok
                HAVING
                    (total - bayar - jumlah_retur - jumlah_bayar_hutang) > 0";
    
    $sql = "SELECT 
                    pemasok.id_pemasok, 
                    pemasok.nama, 	
                    pemasok.kontak,
                    pemasok.telepon,
                    pemasok.alamat, 
                    pemasok.kota,
                    pemasok.kodepos,
                    pembelian.id_pembelian,
                    pembelian.no_faktur,  
                    pembelian.no_nota,
                    pembelian.jatuh_tempo, 

                    ifnull(SUM(pembelian.total), 0) as total, 
                    ifnull(SUM(pembelian.bayar), 0) as bayar,
                    ifnull(retur.jumlah_retur, 0) as jumlah_retur,
                    ifnull(hutang.jumlah_bayar_hutang, 0) as jumlah_bayar_hutang
                FROM 
                    pemasok
                JOIN
                    pembelian ON pemasok.id_pemasok = pembelian.id_pemasok
                LEFT JOIN
                (
                    SELECT pembelian.id_pemasok, SUM(retur_beli.total) as jumlah_retur 
                    FROM retur_beli 
                    JOIN pembelian ON retur_beli.id_pembelian = pembelian.id_pembelian
                    WHERE pembelian.islunas = 0
                    GROUP BY pembelian.id_pemasok
                ) as retur ON pemasok.id_pemasok = retur.id_pemasok
                LEFT JOIN
                (
                    SELECT p.id_pemasok, p.id_pembelian, SUM(hd.total) as jumlah_bayar_hutang
                    FROM pembelian p JOIN hutang_detail hd ON p.id_pembelian = hd.id_pembelian
                    JOIN hutang h ON h.id_hutang = hd.id_hutang
                    WHERE p.islunas = 0
                    GROUP BY h.id_pemasok
                ) as hutang ON pemasok.id_pemasok = hutang.id_pemasok
                WHERE
                    pemasok.status = 1
                    AND
                    pembelian.islunas = 0
                    AND
                    pemasok.nama LIKE '%$search%'
                GROUP BY 
                    pembelian.id_pemasok
                HAVING
                    (total - bayar - jumlah_retur - jumlah_bayar_hutang) > 0
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
            'id_pemasok' => $row['id_pemasok'],
            'id_pembelian' => $row['id_pembelian'],
            'no_faktur' => $row['no_faktur'],
            'no_nota' => $row['no_nota'],
            'jatuh_tempo' => $row['jatuh_tempo'],
            'nama' => $row['nama'],
            'kontak' => $row['kontak'],
            'telepon' => $row['telepon'],
            'alamat' => $row['alamat'],
            'kota' => $row['kota'],
            'kodepos' => $row['kodepos'],
            'total' => $row['total'],
            'bayar' => $row['bayar'],
            'jumlah_bayar_hutang' => $row['jumlah_bayar_hutang'],
            'jumlah_retur' => $row['jumlah_retur'],
            'totalrow' => $totalrow,
            'totaldata' => $totalrow2
        );
    }
}

echo json_encode($json);
?>