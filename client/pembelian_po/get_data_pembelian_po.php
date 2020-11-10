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
$total = $data[0][3];
$keterangan = $data[0][4];
$id_pemasok = $data[0][5];
$tanggal_po = $data[0][6];

if ($kode == '1111') {
    $sql = "SELECT po.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM purchase_order                        
            ) as totaldata 
            FROM purchase_order po, pemasok pema
            WHERE po.id_pemasok = pema.id_pemasok 
            ORDER BY createddate DESC
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '1114') {
    $sql = "SELECT po.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*) 
                FROM purchase_order                        
            ) as totaldata 
            FROM purchase_order po, pemasok pema
            WHERE po.id_pemasok = pema.id_pemasok 
            AND po.isaccepted = 0
            ORDER BY createddate DESC
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '1115') {
    $sql = "SELECT po.*, pema.nama, pema.alamat, pema.kota, pema.kodepos, 1 as totaldata
            FROM purchase_order po, pemasok pema
            WHERE po.id_pemasok = pema.id_pemasok 
            AND po.isaccepted = 0
            AND po.id_purchaseorder = $id
            ORDER BY createddate DESC
            LIMIT $cur_pos, $lim";
    
}else if ($kode == '4444') {

    //AMBIL MAX ID
    $last_id = '';
    $todaydate = date('Y') . date('m') . date('d');

    $sqlgetmaxid = "SELECT MAX(id_purchaseorder) as maxid FROM purchase_order;";
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

    $no_nota = 'PJ/PO/' . $todaydate . '/' . $last_id;

    $sqlinsert = "
        INSERT INTO purchase_order
        (  
            no_nota, 
            total, 
            keterangan, 
            id_pemasok, 
            tanggal_order,  
            createdby
        ) 
        VALUES 
        (
            '$no_nota',
            $total,
            '$keterangan',
            $id_pemasok,
            '$tanggal_po',
            $user
        )";

    mysql_query($sqlinsert);

    $sql = "SELECT po.*, pema.nama, pema.alamat, pema.kota, pema.kodepos, 1 as totaldata 
            FROM purchase_order po, pemasok pema
            WHERE po.id_pemasok = pema.id_pemasok 
            ORDER BY createddate DESC
            LIMIT 1";
    
} else if ($kode == '5555') {
    $sql = "SELECT po.*, pema.nama, pema.alamat, pema.kota, pema.kodepos,
            (
                SELECT COUNT(*)
                FROM purchase_order po, pemasok pema
                WHERE po.id_pemasok = pema.id_pemasok 
                AND 
                (
                    po.no_nota LIKE '%$search%'
                    OR
                    pema.nama LIKE '%$search%'
                )
            ) as totaldata 
            FROM purchase_order po, pemasok pema
            WHERE po.id_pemasok = pema.id_pemasok 
            AND 
                (
                    po.no_nota LIKE '%$search%'
                    OR
                    pema.nama LIKE '%$search%'
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
            'id_purchaseorder' => $row['id_purchaseorder'],
            'no_nota' => $row['no_nota'],
            'total' => $row['total'],
            'keterangan' => $row['keterangan'],
            'id_pemasok' => $row['id_pemasok'],
            'tanggal_order' => $row['tanggal_order'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'isaccepted' => $row['isaccepted'],
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