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
$pdf->Cell(191, 10, 'Retur Beli', 0, 1, 'R');

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
$uang_muka = 0;
$jatuhtempo;
$keterangan;
$pegawai;

$sql = "SELECT r.*, p.no_nota as nonotapembelian, p.no_faktur as nofakturpembelian, p.tanggal_pembelian as tanggalpembelian, p.total as totalpembelian, pe.id_pemasok as idpemasok, pe.nama as namapemasok, pe.alamat as alamatpemasok, pe.kota, pe.kodepos, peg.nama as namapegawai
        FROM retur_beli r
        JOIN pembelian p ON p.id_pembelian = r.id_pembelian
        JOIN pemasok pe ON p.id_pemasok = pe.id_pemasok
        JOIN pegawai peg ON peg.id_pegawai = r.createdby
        WHERE id_returbeli = $id
        LIMIT 1;";
$run = mysql_query($sql);

while ($row = mysql_fetch_array($run)) {

    $total = $row['total'];
    $keterangan = $row['keterangan'];
    $pegawai = $row['namapegawai'];

    $pdf->SetXY(10, 34);
    $pdf->Cell(30, 4, 'No. Ref. Pembelian', 0);
    $pdf->Cell(100, 4, $row['nonotapembelian'], 0, 0);
    $pdf->Cell(60, 4, 'Tanggal Pembelian : ' . gantiTanggal2($row['tanggalpembelian']), 0, 1, 'R');
    $pdf->Cell(30, 4, 'No. Ref. Retur', 0);
    $pdf->Cell(100, 4, $row['no_nota'], 0, 0);
    $pdf->Cell(60, 4, 'Tanggal Retur : ' . gantiTanggal2($row['tanggal_retur']), 0, 1, 'R');
    $pdf->Ln();
    $pdf->Cell(30, 4, 'Pemasok', 0);
    $pdf->Cell(30, 4, $row['namapemasok'], 0, 1);
    $pdf->Cell(30, 4, '', 0);
    $pdf->Cell(30, 4, $row['alamatpemasok'], 0, 1);
    $pdf->Cell(30, 4, '', 0);
    $pdf->Cell(30, 4, $row['kota'] . ' ' . $row['kodepos'], 0, 1);
}

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(30, 8, 'Kode Barang', 1, 0, 'C');
$pdf->Cell(70, 8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(20, 8, 'Jumlah Retur', 1, 0, 'C');
$pdf->Cell(30, 8, 'Harga Satuan', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '', 8);

$sql = "SELECT * FROM retur_beli_detail, barang WHERE retur_beli_detail.id_barang = barang.id_barang AND id_returbeli = $id";
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

$pdf->Cell(130, 4, '', 1, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 4, 'Total Retur:', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($total), 1, 1, 'R');

$pdf->SetFont('', 'I');
$pdf->Cell(190, 4, 'Terbilang : ' . terbilangRupiah($total), 'LR', 1, 'L');

$pdf->SetFont('', '');
$pdf->Cell(40, 4, 'Inventori,', 1, 0, 'C');
$pdf->Cell(40, 4, 'Keuangan,', 1, 0, 'C');
$pdf->Cell(40, 4, 'Supplier,', 1, 0, 'C');

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