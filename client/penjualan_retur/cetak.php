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
$pdf->Cell(191, 10, 'Retur Penjualan', 0, 1, 'R');

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
$biayalain = 0;
$biayakirim = 0;
$biayapajak = 0;
$total = 0;
$bayar = 0;
$jatuhtempo;
$keterangan;
$pegawai;

$sql = "SELECT r.*, p.no_faktur as nofakturpenjualan, p.tanggal_penjualan as tanggalpenjualan, p.total as totalpenjualan, pe.id_pelanggan as idpelanggan, pe.nama as namapelanggan, pe.alamat as alamatpelanggan, pe.kota, pe.kodepos, peg.nama as namapegawai
        FROM retur_jual r
        JOIN penjualan p ON p.id_penjualan = r.id_penjualan
        JOIN pelanggan pe ON p.id_pelanggan = pe.id_pelanggan
        JOIN pegawai peg ON peg.id_pegawai = r.createdby
        WHERE id_returjual = $id
        LIMIT 1;";
$run = mysql_query($sql);

while ($row = mysql_fetch_array($run)) {

    $total = $row['total'];
    $keterangan = $row['keterangan'];
    $pegawai = $row['namapegawai'];

    $pdf->SetXY(10, 34);
    $pdf->Cell(35, 4, 'No. Faktur Penjualan', 0);
    $pdf->Cell(95, 4, $row['nofakturpenjualan'], 0, 0);
    $pdf->Cell(60, 4, 'Tanggal Penjualan : ' . gantiTanggal2($row['tanggalpenjualan']), 0, 1, 'R');
    $pdf->Cell(35, 4, 'No. Ref. Retur', 0);
    $pdf->Cell(95, 4, $row['no_nota'], 0, 0);
    $pdf->Cell(60, 4, 'Tanggal Retur : ' . gantiTanggal2($row['tanggal_retur']), 0, 1, 'R');
    $pdf->Ln();
    $pdf->Cell(20, 4, 'Pelanggan', 0);
    $pdf->Cell(25, 4, $row['namapelanggan'], 0, 1);
    $pdf->Cell(20, 4, '', 0);
    $pdf->Cell(25, 4, $row['alamatpelanggan'], 0, 1);
    $pdf->Cell(20, 4, '', 0);
    $pdf->Cell(30, 4, $row['kota'] . ' ' . $row['kodepos'], 0, 1);
}

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(30, 8, 'Kode Barang', 1, 0, 'C');
$pdf->Cell(70, 8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(20, 8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(30, 8, 'Harga Jual', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '', 8);

$sql = "SELECT * FROM retur_jual_detail, barang WHERE retur_jual_detail.id_barang = barang.id_barang AND id_returjual = $id";
$run = mysql_query($sql);

$i = 1;
while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(10, 4, $i, 'LR', 0, 'C');
    $pdf->Cell(30, 4, $row['kode'], 'LR', 0, 'C');
    $pdf->Cell(70, 4, $row['nama'], 'LR', 0, 'L');
    $pdf->Cell(20, 4, $row['jumlah'], 'LR', 0, 'C');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['harga']), 'LR', 0, 'R');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['jumlah'] * $row['harga']), 'LR', 0, 'R');
    $pdf->Ln();
    $i++;
}

$pdf->SetFont('', 'I');
$pdf->Cell(130, 4, 'Terbilang : ' . terbilangRupiah($total), 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 4, 'Total Retur:', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($total), 1, 1, 'R');


$pdf->SetFont('', '');
$pdf->Cell(40, 4, 'Inventori,', 1, 0, 'C');
$pdf->Cell(40, 4, 'Keuangan,', 1, 0, 'C');
$pdf->Cell(40, 4, 'Pelanggan,', 1, 0, 'C');

$pdf->SetFont('', 'I');
if ($keterangan == '') {
    $pdf->Cell(70, 4, 'Keterangan : ', 'LT', 0, 'L');
} else {
    $pdf->Cell(70, 4, 'Keterangan : ' . $keterangan, 'LT', 0, 'L');
}

$pdf->SetFont('', '');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(70, 4, '', 'LR', 1, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(70, 4, '', 'LR', 1, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(70, 4, '', 'LR', 1, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(40, 4, '', 'LR', 0, 'C');
$pdf->Cell(70, 4, '', 'LR', 1, 'C');
$pdf->Cell(40, 4, '(______________________)', 'LR', 0, 'C');
$pdf->Cell(40, 4, '(______________________)', 'LR', 0, 'C');
$pdf->Cell(40, 4, '(______________________)', 'LR', 0, 'C');
$pdf->Cell(70, 4, '', 'LR', 1, 'C');
$pdf->Cell(40, 4, '', 'LBR', 0, 'C');
$pdf->Cell(40, 4, '', 'LBR', 0, 'C');
$pdf->Cell(40, 4, '', 'LBR', 0, 'C');
$pdf->Cell(70, 4, '', 'LBR', 1, 'C');

$pdf->Output();
?>