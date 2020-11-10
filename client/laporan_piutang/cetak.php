<?php

@$id = $_GET['p4'];
@$type = $_GET['p1'];
@$startdate = $_GET['p2'];
@$enddate = $_GET['p3'];
setlocale(LC_ALL, 'IND');
$date = date('d M Y', time());

$pelanggan = "";
$sql = "SELECT * FROM pelanggan WHERE id_pelanggan = $id";
$query = mysql_query($sql);
while ($row = mysql_fetch_array($query)) {
    $pelanggan = $row['nama'];
}

require('asset/php/fpdf17/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->Image('asset/images/logo.png', 6, 7, 40);
$pdf->Line(10, 27, 200, 27);
$pdf->Line(10, 28, 200, 28);
$pdf->SetXY(10, 20);
$pdf->SetFont('Arial', 'B', 12);

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

$pdf->SetXY(10, 30);
$pdf->SetFont('', 'B', 11);
$pdf->Cell(0, 5, 'Laporan Pembayaran Piutang', 0, 1, 'C');
$pdf->SetFont('', '', 9);
if ($type == 2) {
    $pdf->Cell(0, 5, 'Periode : ' . gantiTanggal2($startdate) . ' s/d ' . gantiTanggal2($enddate), 0, 1, 'C');
    if ($id > 0) {
        $sql = "SELECT piutang.*, pelanggan.nama, pelanggan.alamat, pelanggan.kota, pelanggan.kodepos 
            FROM piutang 
            JOIN pelanggan 
            ON piutang.id_pelanggan = pelanggan.id_pelanggan
            WHERE pelanggan.id_pelanggan = $id
            AND tanggal_pembayaran between '$startdate' and '$enddate'               
            ORDER BY CREATEDDATE DESC";
        
        $pdf->Cell(0, 5, 'Pelanggan : ' . $pelanggan, 0, 1, 'C');
    } else {
        $sql = "SELECT piutang.*, pelanggan.nama, pelanggan.alamat, pelanggan.kota, pelanggan.kodepos 
            FROM piutang 
            JOIN pelanggan 
            ON piutang.id_pelanggan = pelanggan.id_pelanggan 
            AND tanggal_pembayaran between '$startdate' and '$enddate'               
            ORDER BY CREATEDDATE DESC";
    }
} else {
    if ($id > 0) {
        $sql = "SELECT piutang.*, pelanggan.nama, pelanggan.alamat, pelanggan.kota, pelanggan.kodepos 
            FROM piutang 
            JOIN pelanggan 
            ON piutang.id_pelanggan = pelanggan.id_pelanggan
            WHERE pelanggan.id_pelanggan = $id               
            ORDER BY CREATEDDATE DESC";

        $pdf->Cell(0, 5, 'Pelanggan : ' . $pelanggan, 0, 1, 'C');
    } else {
        $sql = "SELECT piutang.*, pelanggan.nama, pelanggan.alamat, pelanggan.kota, pelanggan.kodepos 
            FROM piutang 
            JOIN pelanggan 
            ON piutang.id_pelanggan = pelanggan.id_pelanggan             
            ORDER BY CREATEDDATE DESC";
    }
}
$run = mysql_query($sql);

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(50, 8, 'No. Nota Pembayaran', 1, 0, 'C'); 
$pdf->Cell(45, 8, 'Tanggal Pembayaran', 1, 0, 'C');
$pdf->Cell(50, 8, 'Pemasok', 1, 0, 'C');
$pdf->Cell(35, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '');

$i = 1;
$total = 0;

while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(10, 5, $i, 1, 0, 'C');
    $pdf->Cell(50, 5, $row['no_nota'], 1, 0, 'C'); 
    $pdf->Cell(45, 5, gantiTanggal2($row['tanggal_pembayaran']), 1, 0, 'C');
    $pdf->Cell(50, 5, $row['nama'], 1, 0, 'C');
    $pdf->Cell(35, 5, 'Rp. ' . rupiah($row['total']), 1, 0, 'C');
    $pdf->Ln();
    $total += $row['total'];
    $i++;
}

$pdf->Cell(155, 5, 'Total', 1, 0, 'C');
$pdf->Cell(35, 5, 'Rp. ' . rupiah($total), 1, 0, 'C');
$pdf->Ln();

$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, 'Bandung, ' . strftime("%#d %B %Y"), 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, ',', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, 'Bagian Keuangan,', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '(____________________)', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');

$pdf->Output(); 