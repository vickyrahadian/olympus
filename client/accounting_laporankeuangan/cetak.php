<?php

@$id = $_GET['p4'];
@$type = $_GET['p1'];
@$tanggal_mulai = $_GET['p2'];
@$tanggal_akhir = $_GET['p3'];
setlocale(LC_ALL, 'IND');
$date = date('d M Y', time());

$pemasok = "";
$sql = "SELECT * FROM pemasok WHERE id_pemasok = $id";
$query = mysql_query($sql);
while ($row = mysql_fetch_array($query)) {
    $pemasok = $row['nama'];
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
$pdf->Cell(0, 5, 'Laporan Keuangan Perusahaan', 0, 1, 'C');

$pendapatanpenjualand = 0;
$pendapatanpenjualank = 0;
$biayaangkutpenjualand = 0;
$biayaangkutpenjualank = 0;
$returjuald = 0;
$returjualk = 0;
$penjualanbersihd = 0;
$penjualanbersihk = 0;
$hppd = 0;
$hppk = 0;
$biayaangkutpembelian = 0;
$labarugid = 0;
$labarugik = 0;
//
$kasd = 0;
$kask = 0;
$piutangd = 0;
$piutangk = 0;
$persediaand = 0;
$persediaank = 0;
$utangd = 0;
$utangk = 0;
$modald = 0;
$modalk = 0;

if ($type == 2) {
    $sql = "SELECT d.id_daftarakun, d.kode_akun, d.nama_akun, ifnull(SUM(j.debit), 0) as sumdebit, ifnull(SUM(j.kredit), 0) as sumkredit FROM daftar_akun d LEFT JOIN jurnal_umum j ON d.id_daftarakun = j.id_kodeakun AND j.tanggal between '$tanggal_mulai' and '$tanggal_akhir' GROUP BY d.id_daftarakun ORDER BY d.id_daftarakun";
    $pdf->SetFont('', '', 9);
    $pdf->Cell(0, 5, 'Periode : ' . gantiTanggal2($tanggal_mulai) . ' s/d ' . gantiTanggal2($tanggal_akhir), 0, 1, 'C');
} else {
    $sql = "SELECT d.id_daftarakun, d.kode_akun, d.nama_akun, ifnull(SUM(j.debit), 0) as sumdebit, ifnull(SUM(j.kredit), 0) as sumkredit FROM daftar_akun d LEFT JOIN jurnal_umum j ON d.id_daftarakun = j.id_kodeakun GROUP BY d.id_daftarakun ORDER BY d.id_daftarakun";
}
$run = mysql_query($sql);

while ($row = mysql_fetch_array($run)) {
    $id = $row['id_daftarakun'];
    $debit = $row['sumdebit'];
    $kredit = $row['sumkredit'];

    if ($id == 1) {
        $kasd = $debit;
        $kask = $kredit;
    } else if ($id == 2) {
        $piutangd = $debit;
        $piutangk = $kredit;
    } else if ($id == 3) {
        $persediaand = $debit;
        $persediaank = $kredit;
    } else if ($id == 4) {
        $utangd = $debit;
        $utangk = $kredit;
    } else if ($id == 5) {
        $pendapatanpenjualank = $kredit;
    } else if ($id == 6) {
        $returjuald = $debit;
    } else if ($id == 7) {
        $biayaangkutpenjualank = $kredit;
    } else if ($id == 10) {
        $biayaangkutpembelian = $debit;
    } else if ($id == 11) {
        $hppd = $debit;
        $hppk = $kredit;
    }
}

$penjualanbersihk = $pendapatanpenjualank + $biayaangkutpenjualank - $returjuald;
$hpp = ($hppd - $hppk);
$labarugi = $penjualanbersihk - $hpp;
           
$modalk = $labarugi;
$modald = 0;

$jumlahdebit  = $kasd + $piutangd + $utangd + $persediaand + $modald + $biayaangkutpembelian;
$jumlahkredit = $kask + $piutangk + $utangk + $persediaank + $modalk;

$pdf->SetFont('', 'B', 9);
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->Cell(190, 6, 'Laporan Laba Rugi', 0, 1, 'C');
$pdf->SetFont('', '', 9);
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->Cell(90, 5, 'Pendapatan Penjualan', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($pendapatanpenjualank), 0, 1, 'R');
$pdf->Cell(90, 5, 'Biaya Angkut Penjualan', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($biayaangkutpenjualank), 0, 1, 'R');
$pdf->Cell(90, 5, 'Retur dan Pengurangan Penjualan', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($returjuald), 0, 0, 'R');
$pdf->Cell(50, 5, '', 0, 1, 'L');
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->Cell(90, 5, 'Penjualan Bersih', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($penjualanbersihk), 0, 1, 'R');
$pdf->Cell(90, 5, 'Harga Pokok Penjualan', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp.' . rupiah($hpp), 0, 0, 'R');
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->Cell(50, 5, '', 0, 1, 'L');
$pdf->Cell(90, 5, 'Laba / Rugi Bersih', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($labarugi), 0, 1, 'R');

$pdf->Ln();
$pdf->SetFont('', 'B', 9);
$pdf->Cell(190, 4, '', 'T', 1, 'C');
$pdf->Cell(190, 6, 'Neraca Keuangan', 0, 1, 'C');
$pdf->SetFont('', '', 9);
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->Cell(90, 5, 'Aktiva', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 1, 'L');
$pdf->Cell(90, 5, '     Kas', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($kasd), 0, 0, 'R');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($kask), 0, 1, 'R');
$pdf->Cell(90, 5, '     Piutang Dagang', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($piutangd), 0, 0, 'R');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($piutangk), 0, 1, 'R');
$pdf->Cell(90, 5, '     Persedian Barang Dagang', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($persediaand), 0, 0, 'R');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($persediaank), 0, 1, 'R');
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->Cell(90, 5, 'Kewajiban', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 1, 'L');
$pdf->Cell(90, 5, '     Utang Dagang', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($utangd), 0, 0, 'R');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($utangk), 0, 1, 'R');
$pdf->Cell(90, 5, '     Biaya Angkut Pembelian', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($biayaangkutpembelian), 0, 0, 'R');
$pdf->Cell(50, 5, 'Rp. 0,00', 0, 0, 'R');
$pdf->Cell(50, 5, '', 0, 1, 'L');
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->Cell(90, 5, 'Ekuitas', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 0, 'L');
$pdf->Cell(50, 5, '', 0, 1, 'L');
$pdf->Cell(90, 5, '     Laba Rugi', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($modald), 0, 0, 'R');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($modalk), 0, 1, 'R');
$pdf->Cell(190, 4, '', 0, 1, 'C');
$pdf->SetFont('', 'B', 9);
$pdf->Cell(90, 5, 'Jumlah', 0, 0, 'L');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($jumlahdebit), 0, 0, 'R');
$pdf->Cell(50, 5, 'Rp. ' . rupiah($jumlahkredit), 0, 1, 'R');
$pdf->SetFont('', '', 9);

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
$pdf->Cell(40, 4, '', 0, 0, 'C');
$pdf->Cell(70, 4, '', 0, 0, 'C');
$pdf->Cell(40, 4, '(____________________)', 0, 1, 'C');
$pdf->Cell(20, 4, '', 0, 0, 'C');

$pdf->Output();
