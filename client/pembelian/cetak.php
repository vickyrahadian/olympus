<?php

$id = $_GET['id'];

require('asset/php/fpdf17/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->Image('asset/images/logo.png', 6, 7, 40);
$pdf->Line(10, 29, 200, 29);
$pdf->Line(10, 30, 200, 30);
$pdf->SetXY(10, 20);
$pdf->SetFont('Arial', 'BI', 18);
$pdf->Cell(191, 10, 'Pembelian', 0, 1, 'R');

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

$subtotal = 0; 
$biayapajak = 0;
$total = 0;
$bayar = 0;
$jatuhtempo;
$keterangan;
$pegawai;

$sql = "SELECT pembelian.*, pemasok.nama, pemasok.alamat, pemasok.kota, pemasok.kodepos, pegawai.nama as namapegawai FROM pembelian, pemasok, pegawai WHERE pembelian.id_pemasok = pemasok.id_pemasok AND pembelian.createdby = pegawai.id_pegawai AND id_pembelian = $id LIMIT 1";
$run = mysql_query($sql);

while ($row = mysql_fetch_array($run)) {

    $subtotal = $row['subtotal']; 
    $biayakirim = $row['biaya_kirim']; 
    $total = $row['total'];
    $bayar = $row['bayar'];
    $jatuhtempo = $row['jatuh_tempo'];
    $keterangan = $row['keterangan']; 
    $pegawai = $row['namapegawai'];
    
    $pdf->SetXY(140, 34);
    $pdf->Cell(60, 4, 'Tanggal Pembelian ' . gantiTanggal2($row['tanggal_pembelian']), 0, 0, 'R');

    $pdf->SetXY(10, 34);
    $pdf->Cell(24, 4, 'No. Nota', 0);
    $pdf->Cell(30, 4, $row['no_nota'], 0, 1);
    $pdf->Cell(24, 4, 'No. Faktur', 0);
    $pdf->Cell(30, 4, $row['no_faktur'], 0, 1);
    $pdf->Cell(24, 4, 'Pemasok', 0);
    $pdf->Cell(30, 4, $row['nama'], 0, 1);
    $pdf->Cell(24, 4, '', 0);
    $pdf->Cell(30, 4, $row['alamat'], 0, 1);
    $pdf->Cell(24, 4, '', 0);
    $pdf->Cell(30, 4, $row['kota'] . ' ' . $row['kodepos'], 0, 1);
}

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(30, 8, 'Kode Barang', 1, 0, 'C');
$pdf->Cell(74, 8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(15, 8, 'Qty', 1, 0, 'C');
$pdf->Cell(30, 8, 'Harga Satuan', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '', 8);

$sql = "SELECT * FROM pembelian_detail, barang WHERE pembelian_detail.id_barang = barang.id_barang AND id_pembelian = $id";
$run = mysql_query($sql);

$i = 1;
while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(10, 4, $i, 'LR', 0, 'C');
    $pdf->Cell(30, 4, $row['kode'], 'LR', 0, 'C');
    $pdf->Cell(74, 4, $row['nama'], 'LR', 0, 'L');
    $pdf->Cell(15, 4, $row['jumlah'], 'LR', 0, 'C');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['harga']), 'LR', 0, 'R');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['jumlah'] * $row['harga']), 'LR', 0, 'R');
    $pdf->Ln();
    $i++;
}

$pdf->Cell(129, 4, '', 'LT', 0, 'C');
$pdf->Cell(30, 4, 'Subtotal', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($subtotal), 1, 1, 'R');
$pdf->SetFont('', 'I');
$pdf->Cell(129, 4, 'Terbilang : ' . terbilangRupiah($total), 'L', 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(30, 4, 'Biaya Kirim', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($biayakirim), 1, 1, 'R');


if (($total - $bayar) > 0) {
    $pdf->SetFont('', 'I');
    $pdf->Cell(129, 4, 'Jatuh Tempo ' . gantiTanggal2($jatuhtempo), 'L', 0, 'L');
    $pdf->SetFont('', '');
} else {
    $pdf->Cell(129, 4, '', 'L', 0, 'L');
}
$pdf->SetFont('', 'B');
$pdf->Cell(30, 4, 'Total', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($total), 1, 1, 'R');
 
$pdf->Cell(129, 4, '', 'L', 0, 'L');
 
$pdf->SetFont('', '');
$pdf->Cell(30, 4, 'Bayar', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($bayar), 1, 1, 'R');

if (($total - $bayar) > 0) {
    $pdf->Cell(129, 4, '', 'LB', 0, 'C');
    $pdf->Cell(30, 4, 'Sisa', 1, 0, 'R');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($total - $bayar), 1, 1, 'R');
}
 
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

