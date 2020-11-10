<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1114 = SELECT DROPDOWN
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

//VARIABLE FROM POST 
$nama = $data[0][3];
$no_plat = $data[0][4];

if ($kode == '1111') {
    $sql = "SELECT *, 
                (
                    SELECT COUNT(*) 
                    FROM kendaraan
                    WHERE status = 1
                ) as totaldata 
                FROM kendaraan 
                WHERE status = 1 
                ORDER BY nama ASC 
                LIMIT $cur_pos, $lim";
} else if ($kode == '1112') {
    $sql = "SELECT *, 
                (
                    SELECT COUNT(*) 
                    FROM kendaraan
                    WHERE status = 0
                ) as totaldata 
                FROM kendaraan 
                WHERE status = 0 
                ORDER BY nama ASC 
                LIMIT $cur_pos, $lim";
}
//SELECT DROPDOWN
else if ($kode == '1114') {
    $sql = "SELECT *, 
                (
                    SELECT COUNT(*) 
                    FROM kendaraan
                    WHERE status = 1
                ) as totaldata 
                FROM kendaraan 
                WHERE status = 1 
                ORDER BY nama ASC";    
} else if ($kode == '2222') {
    $sqlupdate = "UPDATE kendaraan SET 
                    nama        = '$nama',
                    no_plat     = '$no_plat', 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby   = $user 
                WHERE id_kendaraan = $id";

    mysql_query($sqlupdate);

    $sql = "SELECT *, (1) as totaldata 
                FROM kendaraan 
                WHERE status = 1 
                ORDER BY updateddate DESC                
                LIMIT 1";
} else if ($kode == '3333') {
    $sqldelete = "UPDATE kendaraan 
                    SET status = 0, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user 
                WHERE id_kendaraan = $id";

    mysql_query($sqldelete);

    $sql = "
                SELECT *, 
                (
                    SELECT COUNT(*) 
                    FROM kendaraan 
                    WHERE status = 1
                ) as totaldata 
                FROM kendaraan 
                WHERE status = 1 
                ORDER BY nama ASC 
                LIMIT $cur_pos, $lim";
} else if ($kode == '4444') {
    $sqlinsert = "INSERT INTO 
                    kendaraan
                VALUES
                (
                    NULL,
                    '$nama',
                    '$no_plat',
                    1,
                    CURRENT_TIMESTAMP,                            
                    $user, 
                    NULL, 
                    NULL
                )";

    $result = mysql_query($sqlinsert);

    $sql = "
                SELECT *, (1) as totaldata 
                FROM kendaraan
                WHERE status = 1 
                ORDER BY createddate DESC                
                LIMIT 1";
} else if ($kode == '5555') {
    $sql = "SELECT *, 
            (
                SELECT COUNT(*) 
                FROM 
                    kendaraan 
                WHERE                         
                    status = 1
                    AND
                    (
                        nama LIKE '%$search%' 
                        OR
                        no_plat LIKE '%$search%' 
                    )
            ) as totaldata 
            FROM 
                kendaraan 
            WHERE 
                status = 1
                AND
                (
                    nama LIKE '%$search%' 
                    OR
                    no_plat LIKE '%$search%' 
                )
            ORDER BY nama ASC
            LIMIT $cur_pos, $lim";
} else if ($kode == '5556') {
    $sql = "SELECT *, 
            (
                SELECT COUNT(*) 
                FROM 
                    kendaraan 
                WHERE                         
                    status = 0
                    AND
                    (
                        nama LIKE '%$search%' 
                        OR
                        no_plat LIKE '%$search%' 
                    )
            ) as totaldata 
            FROM 
                kendaraan 
            WHERE 
                status = 0
                AND
                (
                    nama LIKE '%$search%' 
                    OR
                    no_plat LIKE '%$search%' 
                )
            ORDER BY nama ASC
            LIMIT $cur_pos, $lim";
} else if ($kode == '7777') {
    $sqlactivate = "UPDATE kendaraan 
                    SET status = 1, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user 
                WHERE id_kendaraan = $id";

    mysql_query($sqlactivate);

    $sql = "
                SELECT *, 
                (
                    SELECT COUNT(*) 
                    FROM kendaraan 
                    WHERE status = 0
                ) as totaldata 
                FROM kendaraan 
                WHERE status = 0 
                ORDER BY nama ASC 
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
            'id_kendaraan' => $row['id_kendaraan'],
            'nama' => $row['nama'],
            'no_plat' => $row['no_plat'],
            'status' => $row['status'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'updateddate' => $row['updateddate'],
            'updatedby' => $row['updatedby'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>