<?php

@$id = $_GET['id'];
@$type = $_GET['type'];
@$startdate = $_GET['startdate'];
@$enddate = $_GET['enddate'];
setlocale(LC_ALL, 'IND');
$date = date('d M Y', time());

$pelanggan = "";
$sql = "SELECT * FROM pelanggan WHERE id_pelanggan = $id";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$pelanggan = $row['nama'];

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
$pdf->Cell(0, 5, 'Laporan Penjualan Barang', 0, 1, 'C');
$pdf->SetFont('', '', 9);
if ($type == 2) {
    $pdf->Cell(0, 5, 'Periode : ' . gantiTanggal2($startdate) . ' s/d ' . gantiTanggal2($enddate), 0, 1, 'C');
    if ($id > 0) {
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan 
                WHERE penj.id_pelanggan = $id
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan            
            AND penj.tanggal_penjualan between '$startdate' and '$enddate'
            AND penj.id_pelanggan = $id";

        $pdf->Cell(0, 5, 'Pelanggan : ' . $pelanggan, 0, 1, 'C');
    } else {
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan                        
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan            
            AND penj.tanggal_penjualan between '$startdate' and '$enddate'";
    }
} else {
    if ($id > 0) {
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan       
                WHERE penj.id_pelanggan = $id
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan
            AND penj.id_pelanggan = $id";


        $pdf->Cell(0, 5, 'Pelanggan : ' . $pelanggan, 0, 1, 'C');
    } else {
        $sql = "SELECT penj.*, pela.nama, pela.alamat, pela.kota, pela.kodepos,
            (
                SELECT COUNT(*) 
                FROM penjualan                        
            ) as totaldata 
            FROM penjualan penj, pelanggan pela
            WHERE penj.id_pelanggan = pela.id_pelanggan";
    }
}
$run = mysql_query($sql);

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C'); 
$pdf->Cell(40, 8, 'No. Faktur', 1, 0, 'C');
$pdf->Cell(45, 8, 'Tanggal Penjualan', 1, 0, 'C');
$pdf->Cell(50, 8, 'Pelanggan', 1, 0, 'C');
$pdf->Cell(45, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '');

$i = 1;
$total = 0;
while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(10, 5, $i, 1, 0, 'C');
    $pdf->Cell(40, 5, $row['no_faktur'], 1, 0, 'C');
    $pdf->Cell(45, 5, gantiTanggal2($row['tanggal_penjualan']), 1, 0, 'C');
    $pdf->Cell(50, 5, $row['nama'], 1, 0, 'C');
    $pdf->Cell(45, 5, 'Rp. ' . rupiah($row['total']), 1, 0, 'C');
    $pdf->Ln();
    $total += $row['total'];
    $i++;
}

$pdf->Cell(145, 5, 'Total', 1, 0, 'C');
$pdf->Cell(45, 5, 'Rp. ' . rupiah($total), 1, 0, 'C');
$pdf->Ln();

$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, 'Bandung, ' . strftime("%#d %B %Y"), 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, 'Penjualan / Sales,', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, 'Keuangan,', 0, 1, 'C');
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
$pdf->Cell(40, 4, '(____________________)', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '(____________________)', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');

$pdf->Output();
?>