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
$pdf->Cell(191, 10, 'Credit Payment', 0, 1, 'R');

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
$sisa = 0;
$pegawai;
$pelanggan;

$sql = "SELECT k.*, p.nama as namapelanggan, p.alamat as alamatpelanggan, p.kota, p.kodepos, peg.nama as namapegawai
        FROM piutang k
        JOIN pelanggan p ON k.id_pelanggan= p.id_pelanggan
        JOIN pegawai peg ON k.createdby = peg.id_pegawai
        WHERE k.id_piutang = $id
        LIMIT 1;";
$run = mysql_query($sql);

while ($row = mysql_fetch_array($run)) {

    $total = $row['total'];
    $keterangan = $row['keterangan'];
    $pegawai = $row['namapegawai'];
    $pelanggan = $row['namapelanggan'];

    $pdf->SetXY(140, 34);
    $pdf->Cell(60, 4, 'Tanggal Pembayaran ' . gantiTanggal2($row['tanggal_pembayaran']), 0, 0, 'R');

    $pdf->SetXY(10, 34);
    $pdf->Cell(24, 4, 'No. Referensi', 0);
    $pdf->Cell(30, 4, $row['no_nota'], 0, 1);
    $pdf->Cell(24, 4, 'Pelanggan', 0);
    $pdf->Cell(30, 4, $row['namapelanggan'], 0, 1);
    $pdf->Cell(24, 4, '', 0);
    $pdf->Cell(30, 4, $row['alamatpelanggan'], 0, 1);
    $pdf->Cell(24, 4, '', 0);
    $pdf->Cell(30, 4, $row['kota'] . ' ' . $row['kodepos'], 0, 1);
}

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(100, 8, 'No Faktur', 1, 0, 'C');
$pdf->Cell(40, 8, 'Total Pembayaran', 1, 0, 'C');
$pdf->Cell(40, 8, 'Sisa', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '', 8);

$sql = "
    
        SELECT 
            pelanggan.id_pelanggan, 
            pelanggan.nama, 	
            pelanggan.kontak,
            pelanggan.telepon,
            pelanggan.alamat, 
            pelanggan.kota,
            pelanggan.kodepos,
            penjualan.id_penjualan,
            penjualan.no_faktur,  
            penjualan.jatuh_tempo,
            penjualan.total as total,
            bayar.total as totalbayar,
            bayar.sisa as sisabayar                      
        FROM 
            pelanggan
        JOIN
            penjualan ON pelanggan.id_pelanggan = penjualan.id_pelanggan
        JOIN
            piutang ON piutang.id_pelanggan = pelanggan.id_pelanggan 
        LEFT JOIN
        (
            SELECT 
                piutang_detail.id_penjualan, piutang_detail.total, piutang_detail.sisa
            FROM 
                piutang_detail
            WHERE
                piutang_detail.id_piutang = $id
            GROUP BY
                piutang_detail.id_penjualan
        ) as bayar ON penjualan.id_penjualan = bayar.id_penjualan
        WHERE
            piutang.id_piutang= $id
       ";


$run = mysql_query($sql);

$i = 1;
$sisa = 0;
while ($row = mysql_fetch_array($run)) {
    if($row['totalbayar'] == 0) {
        
    } else { 
        $sisa += ($row['sisabayar']);
        $pdf->Cell(10, 4, $i, 'LR', 0, 'C');
        $pdf->Cell(100, 4, $row['no_faktur'], 'LR', 0, 'C');
        $pdf->Cell(40, 4, 'Rp. ' . rupiah($row['totalbayar']), 'LR', 0, 'R');
        $pdf->Cell(40, 4, 'Rp. ' . rupiah($row['sisabayar']), 'LR', 0, 'R');
        $pdf->Ln();
        $i++;
    }
}

$pdf->SetFont('', 'B');
$pdf->Cell(110, 4, 'Total', 1, 0, 'R');
$pdf->Cell(40, 4, 'Rp. ' . rupiah($total), 1, 0, 'R');
$pdf->Cell(40, 4, 'Rp. ' . rupiah($sisa), 1, 1, 'R');
$pdf->SetFont('', '');

$pdf->SetFont('', 'I');
$pdf->Cell(190, 4, 'Terbilang : ' . terbilangRupiah($total), 'LR', 1, 'L');

$pdf->SetFont('', '');
$pdf->Cell(50, 4, getSettingValue('companyname2'), 1, 0, 'C'); 
$pdf->Cell(50, 4, $pelanggan, 1, 0, 'C');  

$pdf->SetFont('', 'I');
if($keterangan == ''){ 
	$pdf->Cell(90, 4, 'Keterangan : ', 'LT', 0, 'L');
	
} else {
	$pdf->Cell(90, 4, 'Keterangan : ' . $keterangan, 'LT', 0, 'L');
} 
$pdf->SetFont('', '');

$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(90, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(90, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(90, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(90, 4, '', 'LR', 1, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C'); 
$pdf->Cell(50, 4, '', 'LR', 0, 'C');  
$pdf->Cell(90, 4, '', 'LR', 1, 'C');  

$pdf->Cell(50, 4, '(____________________)', 'LR', 0, 'C');
$pdf->Cell(50, 4, '(____________________)', 'LR', 0, 'C');
$pdf->Cell(90, 4, '', 'LR', 1, 'C');  
$pdf->Cell(50, 4, '', 'LBR', 0, 'C');
$pdf->Cell(50, 4, '', 'LRB', 0, 'C');
$pdf->Cell(90, 4, '', 'LBR', 1, 'C');  

$pdf->Output();
?>