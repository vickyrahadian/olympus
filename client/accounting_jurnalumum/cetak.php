<?php

@$id = $_GET['p4'];
@$type = $_GET['p1'];
@$startdate = $_GET['p2'];
@$enddate = $_GET['p3'];
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
$pdf->Cell(0, 5, 'Jurnal Umum', 0, 1, 'C');
$pdf->SetFont('', '', 9);
if ($type == 2) {
    $sql = "SELECT *
            FROM jurnal_umum
            JOIN daftar_akun
            ON jurnal_umum.id_kodeakun = daftar_akun.id_daftarakun
            WHERE jurnal_umum.tanggal between '$startdate' and '$enddate'
            ORDER BY id_jurnalumum ASC";     
    $pdf->Cell(0, 5, 'Periode : ' . gantiTanggal2($startdate) . ' s/d ' . gantiTanggal2($enddate), 0, 1, 'C');
} else {
    $sql = "SELECT *
            FROM jurnal_umum
            JOIN daftar_akun
            ON jurnal_umum.id_kodeakun = daftar_akun.id_daftarakun
            ORDER BY id_jurnalumum ASC";
    $pdf->Cell(0, 5, '', 0, 1, 'C');
}
$run = mysql_query($sql);

$pdf->SetFont('', 'B');
$pdf->Cell(60, 4, '', 0, 1, 'C');
$pdf->Cell(10, 8, 'No', 1, 0, 'C');
$pdf->Cell(37, 8, 'Tanggal', 1, 0, 'C');  
$pdf->Cell(30, 8, 'Kode Akun', 1, 0, 'C');
$pdf->Cell(53, 8, 'Nama Akun', 1, 0, 'C');
$pdf->Cell(30, 8, 'Debit', 1, 0, 'C');
$pdf->Cell(30, 8, 'Kredit', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('', '');

$i = 1;
$total1 = 0;
$total2 = 0;

$c1 = 1;
$c2 = 1;

$tanggal = '';

while ($row = mysql_fetch_array($run)) {
    
    if($c1 == 1 && $c2 == 44){
        $pdf->Cell(10, 5, $i, 'LBR', 0, 'C'); 
        $pdf->Cell(37, 5, gantiTanggal2($row['tanggal']), 'LBR', 0, 'C'); 
        $pdf->Cell(30, 5, $row['kode_akun'], 'LBR', 0, 'C');
        if ($row['kredit'] > 0) {
            $pdf->Cell(53, 5, '      ' . $row['nama_akun'], 'LBR', 0, 'L');  
        } else {  
            $pdf->Cell(53, 5, $row['nama_akun'], 'LBR', 0, 'L');
        }
        $pdf->Cell(30, 5, ($row['debit'] == 0 ? '' : 'Rp. ' . rupiah($row['debit'])), 'LBR', 0, 'R');
        $pdf->Cell(30, 5, ($row['kredit'] == 0 ? '' : 'Rp. ' . rupiah($row['kredit'])), 'LBR', 0, 'R');
    } else if($c1 == 1 && $c2 == 45){
        $pdf->SetFont('', 'B');
        $pdf->Cell(60, 4, '', 0, 1, 'C');
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(37, 8, 'Tanggal', 1, 0, 'C');  
        $pdf->Cell(30, 8, 'Kode Akun', 1, 0, 'C');
        $pdf->Cell(53, 8, 'Nama Akun', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Debit', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kredit', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('', '');
        
        $pdf->Cell(10, 5, $i, 'LR', 0, 'C'); 
        $pdf->Cell(37, 5, gantiTanggal2($row['tanggal']), 'LR', 0, 'C'); 
        $pdf->Cell(30, 5, $row['kode_akun'], 'LR', 0, 'C');
        if ($row['kredit'] > 0) {
            $pdf->Cell(53, 5, '      ' . $row['nama_akun'], 'LR', 0, 'L');  
        } else {  
            $pdf->Cell(53, 5, $row['nama_akun'], 'LR', 0, 'L');
        }
        $pdf->Cell(30, 5, ($row['debit'] == 0 ? '' : 'Rp. ' . rupiah($row['debit'])), 'LR', 0, 'R');
        $pdf->Cell(30, 5, ($row['kredit'] == 0 ? '' : 'Rp. ' . rupiah($row['kredit'])), 'LR', 0, 'R');
        $c1++;
        $c2 = 1;
    } else if($c1 > 1 && $c2 == 50){
        $pdf->Cell(10, 5, $i, 'LBR', 0, 'C'); 
        $pdf->Cell(37, 5, gantiTanggal2($row['tanggal']), 'LBR', 0, 'C'); 
        $pdf->Cell(30, 5, $row['kode_akun'], 'LBR', 0, 'C');
        if ($row['kredit'] > 0) {
            $pdf->Cell(53, 5, '      ' . $row['nama_akun'], 'LBR', 0, 'L');  
        } else {  
            $pdf->Cell(53, 5, $row['nama_akun'], 'LBR', 0, 'L');
        }
        $pdf->Cell(30, 5, ($row['debit'] == 0 ? '' : 'Rp. ' . rupiah($row['debit'])), 'LBR', 0, 'R');
        $pdf->Cell(30, 5, ($row['kredit'] == 0 ? '' : 'Rp. ' . rupiah($row['kredit'])), 'LBR', 0, 'R');
    } else if($c1 > 1 && $c2 == 51){
        $pdf->SetFont('', 'B');
        $pdf->Cell(60, 4, '', 0, 1, 'C');
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(37, 8, 'Tanggal', 1, 0, 'C');  
        $pdf->Cell(30, 8, 'Kode Akun', 1, 0, 'C');
        $pdf->Cell(53, 8, 'Nama Akun', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Debit', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kredit', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('', '');
        
        $pdf->Cell(10, 5, $i, 'LR', 0, 'C'); 
        if(gantiTanggal2($row['tanggal']) == $tanggal){
            $pdf->Cell(37, 5, '', 'LR', 0, 'C'); 
        } else {            
            $pdf->Cell(37, 5, gantiTanggal2($row['tanggal']), 'LR', 0, 'C'); 
        }
        
        $tanggal = gantiTanggal2($row['tanggal']);
        
        $pdf->Cell(30, 5, $row['kode_akun'], 'LR', 0, 'C');
        if ($row['kredit'] > 0) {
            $pdf->Cell(53, 5, '      ' . $row['nama_akun'], 'LR', 0, 'L');  
        } else {  
            $pdf->Cell(53, 5, $row['nama_akun'], 'LR', 0, 'L');
        }
        $pdf->Cell(30, 5, ($row['debit'] == 0 ? '' : 'Rp. ' . rupiah($row['debit'])), 'LR', 0, 'R');
        $pdf->Cell(30, 5, ($row['kredit'] == 0 ? '' : 'Rp. ' . rupiah($row['kredit'])), 'LR', 0, 'R');
        $c1++;
        $c2 = 1;
    } else {
        $pdf->Cell(10, 5, $i, 'LR', 0, 'C'); 
        $pdf->Cell(37, 5, gantiTanggal2($row['tanggal']), 'LR', 0, 'C'); 
        $pdf->Cell(30, 5, $row['kode_akun'], 'LR', 0, 'C');
        if ($row['kredit'] > 0) {
            $pdf->Cell(53, 5, '      ' . $row['nama_akun'], 'LR', 0, 'L');  
        } else {  
            $pdf->Cell(53, 5, $row['nama_akun'], 'LR', 0, 'L');
        }
        $pdf->Cell(30, 5, ($row['debit'] == 0 ? '' : 'Rp. ' . rupiah($row['debit'])), 'LR', 0, 'R');
        $pdf->Cell(30, 5, ($row['kredit'] == 0 ? '' : 'Rp. ' . rupiah($row['kredit'])), 'LR', 0, 'R');
    }   
    
    $pdf->Ln();  
    $total1 += $row['debit'];
    $total2 += $row['kredit'];
    $i++;
    $c2++;
}

$pdf->Cell(130, 5, 'Total', 1, 0, 'C');
$pdf->Cell(30, 5, 'Rp. ' . rupiah($total1), 1, 0, 'R');
$pdf->Cell(30, 5, 'Rp. ' . rupiah($total2), 1, 0, 'R');
$pdf->Ln(); 
$pdf->Ln(); 
$pdf->Ln(); 

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