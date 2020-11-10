<?php

$id = $_GET['p1'];

require('asset/php/fpdf17/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->Image('asset/images/logo.png', 6, 7, 40);
$pdf->Line(10, 29, 200, 29);
$pdf->Line(10, 30, 200, 30);
$pdf->SetXY(10, 20);
$pdf->SetFont('Arial', 'BI', 18);
$pdf->Cell(191, 10, 'Surat Jalan', 0, 1, 'R');

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
$kembali = 0;
$jatuhtempo;
$keterangan;
$pegawai;
$pelanggan;

$sql = "SELECT penjualan.*, pelanggan.nama, pelanggan.alamat, pelanggan.kota, pelanggan.kodepos, pegawai.nama as namapegawai, kendaraan.nama as namakendaraan, kendaraan.no_plat as no_plat FROM penjualan, pelanggan, pegawai, kendaraan WHERE penjualan.id_pelanggan = pelanggan.id_pelanggan AND penjualan.createdby = pegawai.id_pegawai AND penjualan.id_kendaraan = kendaraan.id_kendaraan AND id_penjualan = $id LIMIT 1";
$run = mysql_query($sql);

while ($row = mysql_fetch_array($run)) {

    $subtotal = $row['subtotal'];
    $biayakirim = $row['biaya_kirim'];
    $total = $row['total'];
    $bayar = $row['bayar'];
    $kembali = $row['kembali'];
    $jatuhtempo = $row['jatuh_tempo'];
    $keterangan = $row['keterangan'];
    $pegawai = $row['namapegawai'];
    $pelanggan = $row['nama'];

    $pdf->SetXY(140, 34);
    $pdf->Cell(60, 4, gantiTanggal2($row['tanggal_penjualan']), 0, 0, 'R');

    $pdf->SetXY(140, 38);
    $pdf->Cell(60, 4, 'Jenis Kendaraan : ' . $row['namakendaraan'], 0, 0, 'R');
    
    $pdf->SetXY(140, 42);
    $pdf->Cell(60, 4, 'No Plat : ' . $row['no_plat'], 0, 0, 'R');
    
    $pdf->SetXY(10, 34);
    if ($row['nama'] != 'CASH') {
        $pdf->Cell(17, 4, 'No. ', 0);
        $pdf->Cell(30, 4, $row['no_faktur'], 0, 1);
        $pdf->Cell(17, 4, 'Pelanggan', 0);
        $pdf->Cell(30, 4, $pelanggan, 0, 1);
        $pdf->Cell(17, 4, '', 0);
        $pdf->Cell(30, 4, $row['alamat'], 0, 1);
        $pdf->Cell(17, 4, '', 0);
        $pdf->Cell(30, 4, $row['kota'] . ' ' . $row['kodepos'], 0, 1);
    } else {
        $pdf->Cell(10, 4, 'No. ', 0);
        $pdf->Cell(30, 4, $row['no_faktur'], 0, 1);
        $pdf->Cell(10, 4, '', 0);
        $pdf->Cell(30, 4, 'CASH', 0, 1);
    }
}

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(30, 8, 'Kode Barang', 1, 0, 'C');
$pdf->Cell(75, 8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(15, 8, 'Qty', 1, 0, 'C');
$pdf->Cell(30, 8, 'Harga Satuan', 1, 0, 'C');
$pdf->Cell(30, 8, 'Total', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '', 8);

$sql = "SELECT * FROM penjualan_detail, barang WHERE penjualan_detail.id_barang = barang.id_barang AND id_penjualan = $id";
$run = mysql_query($sql);

$i = 1;
while ($row = mysql_fetch_array($run)) {
    $pdf->Cell(10, 4, $i, 'LR', 0, 'C');
    $pdf->Cell(30, 4, $row['kode'], 'LR', 0, 'C');
    $pdf->Cell(75, 4, $row['nama'], 'LR', 0, 'L');
    $pdf->Cell(15, 4, $row['jumlah'], 'LR', 0, 'C');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['harga']), 'LR', 0, 'R');
    $pdf->Cell(30, 4, 'Rp. ' . rupiah($row['jumlah'] * $row['harga']), 'LR', 0, 'R');
    $pdf->Ln();
    $i++;
}
$pdf->Cell(130, 4, '', 'LT', 0, 'C');
$pdf->Cell(30, 4, 'Subtotal', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($subtotal), 1, 1, 'R');
$pdf->SetFont('', 'I');
$pdf->Cell(130, 4, 'Terbilang : ' . terbilangRupiah($total), 'L', 0, 'L');
$pdf->SetFont('', '');
$pdf->Cell(30, 4, 'Biaya Kirim', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($biayakirim), 1, 1, 'R');

$pdf->Cell(130, 4, '', 'L', 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(30, 4, 'Total', 1, 0, 'R');
$pdf->Cell(30, 4, 'Rp. ' . rupiah($total), 1, 1, 'R');

 
$pdf->Cell(40, 4, 'Pengirim,', 1, 0, 'C');
$pdf->Cell(40, 4, 'Supir,', 1, 0, 'C');
$pdf->Cell(40, 4, 'Penerima,', 1, 0, 'C'); 
if($keterangan == ''){
	$pdf->SetFont('', 'I');
	$pdf->Cell(70, 4, 'Keterangan : ', 'LT', 0, 'L');
	$pdf->SetFont('', '');
} else {
	$pdf->SetFont('', 'I');
	$pdf->Cell(70, 4, 'Keterangan : ' . $keterangan, 'LT', 0, 'L');
	$pdf->SetFont('', '');
} 
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