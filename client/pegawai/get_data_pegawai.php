<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
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

@$user   = $data[0][1];
@$id     = $data[0][2];
@$search = $data[0][96];
@$kode   = $data[0][97];
@$hal    = $data[0][98];
@$lim    = $data[0][99];

$json = array();
@$tabel = $_GET['tabel'];

if ($hal == "" || $hal < 1) {
    $hal = 1;
}  

$cur_pos = ($hal - 1) * $lim;

//VARIABLE FROM POST 
$username       = $data[0][3];
$oripassword    = $data[0][4];
$password       = md5($data[0][4]);
$nama           = gantiHurufKapital($data[0][5]);
$alamat         = gantiHurufKapital($data[0][6]); 
$telepon        = $data[0][7];
$id_posisi      = $data[0][8];
$status         = $data[0][9];
$gambar         = $data[0][10];
 
    if($kode == '1111'){
        $sql =  "SELECT pe.*, po.nama_posisi as namaposisi, 
                    (
                            SELECT
                            COUNT(*)
                            FROM
                            pegawai
                            WHERE
                            status = 1
                    ) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 1
                ORDER BY
                    nama           
                LIMIT $cur_pos, $lim"; 
    }
    
    else if($kode == '1112'){
        $sql =  "SELECT pe.*, po.nama_posisi as namaposisi, 
				(
					SELECT
					COUNT(*)
					FROM
					pegawai
					WHERE
					status = 0
				) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 0
                ORDER BY
                    nama           
                LIMIT $cur_pos, $lim"; 
    }
    
    else if($kode == '1115'){
        $sql =  "SELECT pe.*, po.nama_posisi as namaposisi, 
				(
					SELECT
					COUNT(*)
					FROM
					pegawai
					WHERE
					username LIKE '$search'
				) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    pe.username LIKE '$search'
                ORDER BY
                    nama           
                LIMIT $cur_pos, $lim";
    }
    
    else if($kode == '2222'){      
        if($oripassword == ""){
            $sqlupdate  = "
                UPDATE 
                    pegawai
                SET 
                    nama = '$nama', 
                    alamat =  '$alamat',
                    telepon = '$telepon', 
                    id_posisi = '$id_posisi', 
                    gambar = '$gambar', 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user
                WHERE 
                    id_pegawai = $id                
                ";
        } else {
            $sqlupdate  = "
                UPDATE 
                    pegawai
                SET 
                    nama = '$nama', 
                    password = '$password',
                    alamat =  '$alamat',
                    telepon = '$telepon', 
                    id_posisi = '$id_posisi', 
                    gambar = '$gambar', 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user
                WHERE 
                    id_pegawai = $id                
                ";
        }
        
		
        mysql_query($sqlupdate);
        
        $sql =  "SELECT pe.*, po.nama_posisi as namaposisi, 
				(
					SELECT
					COUNT(*)
					FROM
					pegawai
					WHERE
					status = 1
				) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 1
                ORDER BY
                    updateddate DESC           
                LIMIT 1";
    }
    
    else if($kode == '3333'){
        $sqldelete  = 
                "UPDATE pegawai
                    SET status = 0, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user 
                WHERE id_pegawai = $id";
                
        mysql_query($sqldelete);
        
        $sql = "SELECT pe.*, po.nama_posisi as namaposisi, 
				(
					SELECT
					COUNT(*)
					FROM
					pegawai
					WHERE
					status = 1
				) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 1
                ORDER BY
                    nama           
                LIMIT $cur_pos, $lim"; 
    }
	
    else if($kode == '4444'){
        $sqlinsert = "                
                INSERT INTO 
                    pegawai
                VALUES 
                    (
                        NULL,
                        '$username',
                        '$password',
                        '$nama',
                        '$alamat',
                        '$telepon',
                        '$id_posisi',
                        '1',
                        CURRENT_TIMESTAMP,
                        $user,
                        NULL,
                        '',
                        '$gambar'
                    )                
                ";  
        
        mysql_query($sqlinsert);
        
        $sql =  "SELECT pe.*, po.nama_posisi as namaposisi, (2-1) as totaldata
				FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 1
                ORDER BY
                    createddate DESC           
                LIMIT 1"; 
    }
    
    else if($kode == '5555'){        
        $sql =  "SELECT pe.*, po.nama_posisi as namaposisi,
				(
					SELECT
					COUNT(*)
					FROM
					pegawai
					WHERE
					status = 1
					AND
					(
						username LIKE '%$search%'
						OR
						nama LIKE '%$search%'
					)
				) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 1
                    AND
                    (
                        pe.username LIKE '%$search%'
                        OR
                        pe.nama LIKE '%$search%'
                    )
                ORDER BY
                    nama           
                LIMIT $cur_pos, $lim"; 
    }
    
    else if($kode == '5556'){        
        $sql =  "SELECT pe.*, po.nama_posisi as namaposisi,
				(
					SELECT
					COUNT(*)
					FROM
					pegawai
					WHERE
					status = 0
					AND
					(
						username LIKE '%$search%'
						OR
						nama LIKE '%$search%'
					)
				) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 0
                    AND
                    (
                        pe.username LIKE '%$search%'
                        OR
                        pe.nama LIKE '%$search%'
                    )
                ORDER BY
                    nama           
                LIMIT $cur_pos, $lim"; 
    }
    
    else if($kode == '7777'){
		$sqlactivate  = 
                "UPDATE pegawai
                    SET status = 1, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user 
                WHERE id_pegawai = $id";
                
        mysql_query($sqlactivate);
        
        $sql = "SELECT pe.*, po.nama_posisi as namaposisi,
				(
					SELECT
					COUNT(*)
					FROM
					pegawai
					WHERE
					status = 0
				) as totaldata
                FROM 
                    pegawai pe, pegawai_posisi po
                WHERE
                    pe.id_posisi = po.id_posisi
                    AND
                    status = 0
                ORDER BY
                    nama           
                LIMIT $cur_pos, $lim"; 
    }

$result  = mysql_query($sql);
$totalrow  = mysql_num_rows($result);

if($totalrow <= 0){
    $json['data'][] = array(
        'totalrow' => 0
    );
} else {
    while($row = mysql_fetch_array($result)){
        $json['data'][] = array(
            'id_pegawai' => $row['id_pegawai'],
            'username' => $row['username'],
            'nama' => $row['nama'],
            'alamat' => $row['alamat'], 
            'telepon' => $row['telepon'],
            'id_posisi' => $row['id_posisi'],
            'namaposisi' => $row['namaposisi'],
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