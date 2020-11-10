<?php

$id = $_GET['id'];

require('asset/php/fpdf17/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage('L', 'A5');
$pdf->Image('asset/images/logo.png', 6, 7, 40);
$pdf->Line(10, 29, 200, 29);
$pdf->Line(10, 30, 200, 30);
$pdf->SetXY(10, 20);
$pdf->SetFont('Arial', 'BI', 18);
$pdf->Cell(191, 10, 'Purchase Order', 0, 1, 'R');

$pdf->SetXY(10, 9);
$pdf->SetFont('', 'B', 9);
$pdf->Cell(28, 4, '');
$pdf->Cell(20, 4, getSettingValue('companyname'));
$pdf->Ln();
$pdf->SetFont('', '');
$pdf->Cell(28, 4, '');
$pdf->Cell(20, 4, getSettingValue('companyaddress'));
$pdf->Ln();
$pdf->Cell(28, 4, '');
$pdf->Cell(20, 4, getSettingValue('companycity') . ' ' . getSettingValue('companypostcode'));
$pdf->Ln();
$pdf->Cell(28, 4, '');
$pdf->Cell(20, 4, getSettingValue('companyphone'));

$pdf->SetFont('', '', 8);

$total = 0;
$keterangan;
$pegawai;

$sql = "SELECT purchase_order.*, pemasok.nama, pemasok.alamat, pemasok.kota, pemasok.kodepos, pegawai.nama as namapegawai FROM purchase_order, pemasok, pegawai WHERE purchase_order.id_pemasok = pemasok.id_pemasok AND purchase_order.createdby = pegawai.id_pegawai AND id_purchaseorder = $id LIMIT 1";
$run = mysql_query($sql);

while ($row = mysql_fetch_array($run)) {

    $total = $row['total'];
    $keterangan = $row['keterangan'];
    $pegawai = $row['namapegawai'];

    $pdf->SetXY(140, 34);
    $pdf->Cell(60, 4, gantiTanggal2($row['tanggal_order']), 0, 0, 'R');

    $pdf->SetXY(10, 34);
    $pdf->Cell(15, 4, 'No.', 0);
    $pdf->Cell(30, 4, $row['no_nota'], 0, 1);
    $pdf->Cell(15, 4, 'Kepada', 0);
    $pdf->Cell(30, 4, $row['nama'], 0, 1);
    $pdf->Cell(15, 4, '', 0);
    $pdf->Cell(30, 4, $row['alamat'], 0, 1);
    $pdf->Cell(15, 4, '', 0);
    $pdf->Cell(30, 4, $row['kota'] . ' ' . $row['kodepos'], 0, 1);
}

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(74, 8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(30, 8, 'Satuan', 1, 0, 'C');
$pdf->Cell(15, 8, 'Qty', 1, 0, 'C');
$pdf->Cell(30, 8, 'Harga Satuan', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '', 8);

$sql = "SELECT *, barang.nama as namabarang, barang_satuan.nama as namasatuan FROM purchase_order_detail, barang, barang_satuan WHERE purchase_order_detail.id_barang = barang.id_barang AND barang.id_satuan = barang_satuan.id_barangsatuan AND id_purchaseorder = $id";
$run = mysql_query($sql);

$i = 1;
while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(10, 4, $i, 'LR', 0, 'C');
    $pdf->Cell(74, 4, $row['namabarang'], 'LR', 0, 'L');
    $pdf->Cell(30, 4, $row['namasatuan'], 'LR', 0, 'C');
    $pdf->Cell(15, 4, $row['jumlah'], 'LR', 0, 'C');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['harga']), 'LR', 0, 'R');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['jumlah'] * $row['harga']), 'LR', 0, 'R');
    $pdf->Ln();
    $i++;
}

$pdf->Cell(129, 4, '', 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 4, 'Total :', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($total), 1, 1, 'R');
$pdf->SetFont('', 'I');
$pdf->Cell(189, 4, 'Terbilang : ' . terbilangRupiah($total), 'LR', 1, 'L');
$pdf->SetFont('', '');

$pdf->Cell(50, 4, 'Inventori,', 1, 0, 'C'); 
$pdf->Cell(50, 4, 'Keuangan,', 1, 0, 'C');  
if($keterangan == ''){
	$pdf->SetFont('', 'I');
	$pdf->Cell(89, 4, 'Keterangan : ', 'LT', 0, 'L');
	$pdf->SetFont('', '');
} else {
	$pdf->SetFont('', 'I');
	$pdf->Cell(89, 4, 'Keterangan : ' . $keterangan, 'LT', 0, 'L');
	$pdf->SetFont('', '');
} 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(89, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(89, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(89, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(89, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(89, 4, '', 'LR', 1, 'C');  

$pdf->Cell(50, 4, '(____________________)', 'LR', 0, 'C');
$pdf->Cell(50, 4, '(____________________)', 'LR', 0, 'C');
$pdf->Cell(89, 4, '', 'LR', 1, 'C');  
$pdf->Cell(50, 4, '', 'LBR', 0, 'C');
$pdf->Cell(50, 4, '', 'LRB', 0, 'C');
$pdf->Cell(89, 4, '', 'LBR', 1, 'C');  

$pdf->Output();
?>