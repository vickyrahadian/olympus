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
$pdf->Cell(0, 5, 'Laporan Retur Jual Barang', 0, 1, 'C');
$pdf->SetFont('', '', 9);
if ($type == 2) {
    $pdf->Cell(0, 5, 'Periode : ' . gantiTanggal2($startdate) . ' s/d ' . gantiTanggal2($enddate), 0, 1, 'C');
    if ($id > 0) {
        $sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_jual) as totaldata
            FROM retur_jual r
            JOIN penjualan p ON p.id_penjualan = r.id_penjualan
            JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan
            WHERE pe.id_pelanggan = $id
            AND r.tanggal_retur between '$startdate' and '$enddate'   
            ORDER BY r.createddate DESC";
        
        $pdf->Cell(0, 5, 'Pelanggan : ' . $pelanggan, 0, 1, 'C');
    } else {
        $sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_jual) as totaldata
            FROM retur_jual r
            JOIN penjualan p ON p.id_penjualan = r.id_penjualan
            JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan 
            AND r.tanggal_retur between '$startdate' and '$enddate'   
            ORDER BY r.createddate DESC";
    }
} else {
    if ($id > 0) {
        $sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_jual) as totaldata
            FROM retur_jual r
            JOIN penjualan p ON p.id_penjualan = r.id_penjualan
            JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan
            WHERE pe.id_pelanggan = $id 
            ORDER BY r.createddate DESC";

        $pdf->Cell(0, 5, 'Pelanggan : ' . $pelanggan, 0, 1, 'C');
    } else {
        $sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, (SELECT COUNT(*) FROM retur_jual) as totaldata
            FROM retur_jual r
            JOIN penjualan p ON p.id_penjualan = r.id_penjualan
            JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan 
            ORDER BY r.createddate DESC";
    }
}
$run = mysql_query($sql);

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(40, 8, 'No. Referensi Retur', 1, 0, 'C');
$pdf->Cell(35, 8, 'No. Faktur', 1, 0, 'C');
$pdf->Cell(35, 8, 'Tanggal Retur', 1, 0, 'C');
$pdf->Cell(40, 8, 'Pelanggan', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '');

$i = 1;
$total = 0;

while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(10, 5, $i, 1, 0, 'C');
    $pdf->Cell(40, 5, $row['no_nota'], 1, 0, 'C');
    $pdf->Cell(35, 5, $row['nofakturpenjualan'], 1, 0, 'C');
    $pdf->Cell(35, 5, gantiTanggal2($row['tanggal_retur']), 1, 0, 'C');
    $pdf->Cell(40, 5, $row['namapelanggan'], 1, 0, 'C');
    $pdf->Cell(30, 5, 'Rp. ' . rupiah($row['total']), 1, 0, 'C');
    $pdf->Ln();
    $total += $row['total'];
    $i++;
}

$pdf->Cell(160, 5, 'Total', 1, 0, 'C');
$pdf->Cell(30, 5, 'Rp. ' . rupiah($total), 1, 0, 'C');
$pdf->Ln();

$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(129, 4, '', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, 'Bandung, ' . strftime("%#d %B %Y"), 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, 'Inventori,', 0, 0, 'C');
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