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


if ($kode == '5557') {
    $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos, 
			(
				SELECT COUNT(*) 
				FROM pembelian pemb, pemasok pema
				WHERE pemb.id_pemasok = pema.id_pemasok 
				AND pemb.id_pembelian = $search
			) as totaldata 
			FROM pembelian pemb, pemasok pema
			WHERE pemb.id_pemasok = pema.id_pemasok 
			AND pemb.id_pembelian = $search 
			LIMIT 1";
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