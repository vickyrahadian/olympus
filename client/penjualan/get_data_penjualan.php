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
$subtotal = $data[0][4];
$biaya_kirim = $data[0][5];
$biaya_lain = $data[0][6];
$biaya_pajak = $data[0][7];
$total = $data[0][8];
$bayar = $data[0][9];
$status_pembayaran = $data[0][10];
$keterangan = $data[0][11];
$id_pelanggan = $data[0][12];
$jatuh_tempo = $data[0][14];
$kembali = $data[0][17];
$iskirim = $data[0][19];

if($iskirim == 1){
    $id_kendaraan = $data[0][18];
} else {
    $id_kendaraan = 0;
}

if($id_pelanggan == 0){
    $id_pelanggan = 1;
} 

if ($kode == '1111') {
    $sql = "SELECT pen.*, pel.nama, pel.alamat, 
            (
                SELECT COUNT(*) FROM penjualan
            ) as totaldata 
            FROM penjualan pen, pelanggan pel
            WHERE pen.id_pelanggan = pel.id_pelanggan
            ORDER BY pen.createddate DESC
            LIMIT $cur_pos, $lim";
} else if ($kode == '4444') {

    //AMBIL MAX ID
    $last_id = '';
    $todaydate = date('Y') . date('m') . date('d');

    $sqlgetmaxid = "SELECT MAX(id_penjualan) as maxid FROM penjualan;";
    $run = mysql_query($sqlgetmaxid);
    while ($row = mysql_fetch_array($run)) {
        $last_id = $row['maxid'];
    }
    $last_id++;

    if ($last_id < 10) {
        $last_id = '000' . $last_id;
    } else if ($last_id >= 10 && $last_id < 100) {
        $last_id = '00' . $last_id;
    } else if ($last_id >= 100 && $last_id < 1000) {
        $last_id = '0' . $last_id;
    }

    $no_faktur = 'PJ/2/' . $todaydate . '/' . $last_id;

    $sqlinsert = "INSERT INTO `penjualan`(`no_faktur`, `subtotal`, `biaya_kirim`, `total`, `bayar`, `kembali`, `status_pembayaran`, `keterangan`, `id_pelanggan`, `tanggal_penjualan`, `jatuh_tempo`, `createdby`, `islunas`, `id_kendaraan`) VALUES ('$no_faktur', $subtotal, $biaya_kirim, $total, $bayar, $kembali, $status_pembayaran, '$keterangan', $id_pelanggan, CURRENT_TIMESTAMP, '$jatuh_tempo', $user, $status_pembayaran, $id_kendaraan)";
    mysql_query($sqlinsert); 
    
    $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos , 1 as totaldata 
            FROM penjualan pemb, pelanggan pema
            WHERE pemb.id_pelanggan = pema.id_pelanggan 
            ORDER BY createddate DESC
            LIMIT 1";   
 
} else if ($kode == '5555') {
    $sql = "SELECT pen.*, pel.nama, pel.alamat, 
            (
                SELECT COUNT(*)
                FROM penjualan pen, pelanggan pel
                WHERE pen.id_pelanggan = pel.id_pelanggan
                AND
                (
                    pen.no_faktur LIKE '%$search%'
                    OR
                    pel.nama LIKE '%$search%'
                )
            ) as totaldata 
            FROM penjualan pen, pelanggan pel
            WHERE pen.id_pelanggan = pel.id_pelanggan
            AND
                (
                    pen.no_faktur LIKE '%$search%'
                    OR
                    pel.nama LIKE '%$search%'
                )
            ORDER BY createddate DESC
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
            'id_kendaraan' => $row['id_kendaraan'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>