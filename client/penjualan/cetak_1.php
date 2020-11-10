<?php

$id = $_GET['id'];
require('asset/php/fpdf17/fpdf.php');

$sql = "SELECT penjualan_detail.*, SUM(jumlah) as jumlahs, barang.nama, barang.kode FROM penjualan_detail, barang WHERE penjualan_detail.id_barang = barang.id_barang AND id_penjualan = $id GROUP BY id_barang";
$run = mysql_query($sql);
$totaldata = mysql_num_rows($run);
$tinggikertas = ($totaldata * 5) + 75;
if ($tinggikertas <= 90) {
    $pdf = new FPDF('L', 'mm', array(90, $tinggikertas));
} else {
    $pdf = new FPDF('P', 'mm', array(90, $tinggikertas));
}

$pdf->AddPage();
$pdf->SetLeftMargin(2);
$pdf->SetTopMargin(2);
$pdf->SetFont('Courier', 'B', 13);
$pdf->SetTextColor(84, 21, 104);
$pdf->SetDrawColor(84, 21, 104);
$pdf->Cell(0, 0, '', 0, 1, 'C');
$pdf->Cell(85, 7, 'TOKO BAHAN BANGUNAN PALANGJAYA', 0, 1, 'C');
$pdf->SetFont('Courier', '', 7);
$pdf->Cell(85, 3, 'Jalan Raya Barat No. 149 Cicalengka Kabupaten Bandung', 0, 1, 'C');
$pdf->Cell(85, 3, 'Telepon (022) 7948337', 0, 1, 'C');
$pdf->Cell(85, 3, '', 0, 1, 'L');
$pdf->Cell(85, 3, '=========================================================', 0, 1, 'C');
$total = 0;
while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(85, 3, $row['nama'], 0, 1, 'L');
    $pdf->Cell(10, 4, '', 0, 0, 'L');
    $pdf->Cell(55, 4, $row['jumlahs'] . ' x ' . $row['harga'], 0, 0, 'L');
    $pdf->Cell(20, 4, 'Rp. ' . number_format(($row['jumlahs'] * $row['harga']), 0, ',', '.'), 0, 1, 'R');
    $total += ($row['jumlahs'] * $row['harga']);
}
$pdf->Cell(85, 3, '=========================================================', 0, 1, 'C');
$pdf->Cell(65, 3, 'TOTAL', 0, 0, 'L');
$pdf->Cell(20, 4, 'Rp. ' . number_format($total, 0, ',', '.'), 0, 1, 'R');

$sql = "SELECT * FROM penjualan WHERE id_penjualan = $id";
$row = mysql_fetch_array(mysql_query($sql));
$bayar = $row['bayar'];
$kembali = $row['kembali'];

$pdf->Cell(65, 3, 'Bayar', 0, 0, 'L');
$pdf->Cell(20, 4, 'Rp. ' . number_format($bayar, 0, ',', '.'), 0, 1, 'R');

if ($kembali > 0) {
    $pdf->Cell(65, 3, 'Kembali', 0, 0, 'L');
    $pdf->Cell(20, 4, 'Rp. ' . number_format($kembali, 0, ',', '.'), 0, 1, 'R');
}

$pdf->Cell(85, 3, '', 0, 1, 'L');
$pdf->Cell(85, 3, '-- Terima Kasih Atas Kunjungan Anda ;D --', 0, 1, 'C');
$pdf->Output(); 