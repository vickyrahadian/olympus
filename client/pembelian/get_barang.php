<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT SEMUA BARANG
//2222 = UPDATE
//3333 = DELETE
//4444 = INSERT
//5555 = SEARCHSIMPLE AKTIF
//5556 = SEARCHSIMPLE TIDAK AKTIF
//7777 = AKTIFKAN

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

require('../fungsi.php');
konek_db();

$json = array();
$search = $_GET['term'];
       
$sql =  "
        SELECT 
        	b.*, 
        	kb.id_kategori, 
        	kb.nama_kategori,
        	bs.id_satuan_barang,
        	bs.nama_satuan_barang,
        	(
        		SELECT 
        			COUNT(*)
        		FROM 
        			barang
        		WHERE 
        			status = 1
                    AND
                    nama_barang LIKE '%$search%'
        	) as totaldata
        FROM 
        	barang b JOIN barang_kategori kb ON b.id_kategori_barang = kb.id_kategori 
        	JOIN barang_satuan bs ON b.satuan = bs.id_satuan_barang 
        	LEFT JOIN barang_stok bso ON b.id_barang = bso.id_barang
        WHERE 
        	b.status = 1 
            AND
            b.nama_barang LIKE '%$search%'
        GROUP BY b.id_barang
        ORDER BY nama_barang ASC
        
        "; 
    


$result  = mysql_query($sql);
$totalrow  = mysql_num_rows($result);

if($totalrow <= 0){
    $json['data'][] = array(
        'total_row' => 0
    );
} else {
    while($row = mysql_fetch_array($result)){
        $json['data'][] = array(
            'id_barang' => $row['id_barang'],
            'kode_barang' => $row['kode_barang'],
            'barcode' => $row['barcode'] == null ? '-' : $row['barcode'],
            'nama_barang' => $row['nama_barang'],
            'satuan' => $row['satuan'],
            'harga_ecer' => $row['harga_ecer'],
            'stok_terjual' => $row['stok_terjual'],
            'id_kategori' => $row['id_kategori'],
            'nama_kategori' => $row['nama_kategori'],
            'id_satuan_barang' => $row['id_satuan_barang'],
            'nama_satuan_barang' => $row['nama_satuan_barang'],
            'gambar' => $row['gambar'],
            'status' => $row['status'],
            'created_date' => $row['created_date'],
            'created_by' => $row['created_by'],
            'updated_date' => $row['updated_date'],
            'updated_by' => $row['updated_by'],
            'total_row' => $totalrow,
            'total_data' => $row['totaldata']
        );
    }
} 
echo json_encode($json); 

?>