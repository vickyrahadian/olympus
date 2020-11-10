<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT SEMUA
//2222 = UPDATE
//3333 = DELETE
//4444 = INSERT
//5555 = SEARCHSIMPLE AKTIF
//5556 = SEARCHSIMPLE TIDAK AKTIF
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
@$tabel = $_GET['tabel'];

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim;

//VARIABLE FROM POST 
$nama = gantiHurufKapital($data[0][3]);
$nama_kontak = gantiHurufKapital($data[0][4]);
$alamat = gantiHurufKapital($data[0][5]);
$kota = gantiHurufKapital($data[0][6]);
$kodepos = $data[0][7];
$telepon = $data[0][8];
$fax = $data[0][9];
$email = $data[0][10];
$website = $data[0][11];
$gambar = $data[0][12];

if ($kode == '1111') {
    $sql = "SELECT *, ( SELECT COUNT(*) FROM pelanggan WHERE status = 1 ) as totaldata
            FROM pelanggan
            WHERE status = 1
            ORDER BY nama           
            LIMIT $cur_pos, $lim";

} else if ($kode == '1112') {
    $sql = "SELECT *, ( SELECT COUNT(*) FROM pelanggan WHERE status = 0 ) as totaldata
            FROM pelanggan
            WHERE status = 0
            ORDER BY nama           
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '2222') {
    $sqlupdate = "
                UPDATE 
                    pelanggan 
                SET 
                    nama = '$nama', 
                    kontak = '$nama_kontak', 
                    alamat =  '$alamat',
                    kota = '$kota', 
                    kodepos = '$kodepos',            
                    telepon = '$telepon',
                    fax = '$fax',
                    email = '$email',
                    website = '$website',
                    gambar = '$gambar', 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user
                WHERE 
                    id_pelanggan = $id";

    mysql_query($sqlupdate);

    $sql = "SELECT *, ( SELECT COUNT(*) FROM pelanggan WHERE status = 1 ) as totaldata
            FROM pelanggan
            WHERE status = 1
            ORDER BY updateddate DESC           
            LIMIT 1";
    
} else if ($kode == '3333') {
    $sqldelete = "UPDATE pelanggan
                SET status = 0, 
                updateddate = CURRENT_TIMESTAMP, 
                updatedby = $user 
                WHERE id_pelanggan = $id";

    mysql_query($sqldelete);

    $sql = "SELECT *, ( SELECT COUNT(*) FROM pelanggan WHERE status = 1 ) as totaldata
            FROM pelanggan
            WHERE status = 1
            ORDER BY nama           
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '4444') {
    //AMBIL MAX ID
    $last_id = ''; 

    $sqlgetmaxid = "SELECT MAX(id_pelanggan) as maxid FROM pelanggan;";
    $run = mysql_query($sqlgetmaxid);
    while($row = mysql_fetch_array($run)){
        $last_id = $row['maxid'];
    }                
    $last_id++;

    if($last_id<10){
        $last_id = '000' . $last_id;
    } else if ($last_id >= 10 && $last_id < 100){
        $last_id = '00' . $last_id;
    } else if ($last_id >= 100 && $last_id < 1000){
        $last_id = '0' . $last_id;
    }        

    $kode = 'C' . $last_id;

    $sqlinsert = 
            "INSERT INTO 
                pelanggan
            VALUES 
            (
                NULL, 
                '$kode', 
                '$nama', 
                '$nama_kontak', 
                '$alamat', 
                '$kota', 
                '$kodepos', 
                '$telepon', 
                '$fax', 
                '$email', 
                '$website', 
                '$gambar', 
                '1', 
                CURRENT_TIMESTAMP, 
                '$user', 
                NULL, 
                NULL
            )";  

    mysql_query($sqlinsert);

    $sql = "SELECT *, ( SELECT COUNT(*) FROM pelanggan WHERE status = 1 ) as totaldata
            FROM pelanggan
            WHERE status = 1
            ORDER BY createddate DESC           
            LIMIT 1";
    
} else if ($kode == '5555') {
    $sql = "SELECT *, 
            (
                SELECT
                    COUNT(*)
                FROM
                    pelanggan
                WHERE
                    status = 1
                    AND
                    (
                        nama LIKE '%$search%'
                        OR
                        kontak LIKE '%$search%'
                    )                                                        
            ) as totaldata
            FROM 
                pelanggan
            WHERE
                status = 1
                AND
                (
                    nama LIKE '%$search%'
                    OR
                    kontak LIKE '%$search%'
                )
            ORDER BY
                nama           
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '5556') {
    $sql = "SELECT *, 
            (
                SELECT
                    COUNT(*)
                FROM
                    pelanggan
                WHERE
                    status = 0
                    AND
                    (
                        nama LIKE '%$search%'
                        OR
                        kontak LIKE '%$search%'
                    )                                                        
            ) as totaldata
            FROM 
                pelanggan
            WHERE
                status = 0
                AND
                (
                    nama LIKE '%$search%'
                    OR
                    kontak LIKE '%$search%'
                )
            ORDER BY
                nama           
            LIMIT $cur_pos, $lim";

} else if ($kode == '7777') {
    $sqlactive = "UPDATE pelanggan 
                    SET status = 1, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user 
                WHERE id_pelanggan = $id";

    mysql_query($sqlactive);

    $sql = "SELECT *, ( SELECT COUNT(*) FROM pelanggan WHERE status = 0 ) as totaldata
            FROM pelanggan
            WHERE status = 0
            ORDER BY nama           
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
            'id_pelanggan' => $row['id_pelanggan'],
            'kode' => $row['kode'],
            'nama' => $row['nama'],
            'kontak' => $row['kontak'],
            'alamat' => $row['alamat'],
            'kota' => $row['kota'],
            'kodepos' => $row['kodepos'],
            'telepon' => $row['telepon'],
            'fax' => $row['fax'],
            'email' => $row['email'],
            'website' => $row['website'],
            'gambar' => $row['gambar'],
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