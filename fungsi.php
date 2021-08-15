<?php

function konek_db() {
    $server = "ckshdphy86qnz0bj.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
    $userna = "gvjkwi50cgkiacqp";
    $passwo = "trpblstl5hfbf5r4";
    $dbname = "v4lvfzueuwuf1o7q";

    $konek_db = mysqli_connect($server, $userna, $passwo) or die('Cannot connect to database server');
    $selec_db = mysqli_select_db($dbname, $konek_db) or die('Cannot select database name');
}

function gantiTanggal($tanggal) {
    $originalDate = $tanggal;
    $newDate = date("d F Y, G:i", strtotime($originalDate));
    return $newDate;
}

function gantiTanggal2($tanggal) { 
    setlocale(LC_ALL, 'IND');
    $newDate = strftime("%#d %B %Y", strtotime($tanggal));
    return $newDate;
}

function gantiTanggalDatabase($tanggal) {
    $old_date = explode('/', $tanggal);
    $new_date = $old_date[2] . '-' . $old_date[1] . '-' . $old_date[0];
    return $new_date;
}

function gantiHurufKapital($kalimat) {
    $kataSplit = explode(" ", $kalimat);
    $reValue = "";
    for ($i = 0; $i < count($kataSplit); $i++) {
        $kataawal = $kataSplit[$i];
        if ($kataawal == 'PT' || $kataawal == 'CV') {
            $kataberes = $kataawal;
        } else {
            $karakterawal = substr($kataawal, 0, 1);
            $karaktersisa = strtolower(substr($kataawal, 1, strlen($kataawal)));
            $karakterawaluppercase = strtoupper($karakterawal);
            $kataberes = $karakterawaluppercase . $karaktersisa;
        }
        $reValue .= $kataberes . " ";
    }

    $reValue = substr($reValue, 0, -1);

    return $reValue;
}

function potongKalimat($kalimat) {

    if (strlen($kalimat) > 30) {
        $kalimat = substr($kalimat, 0, 30);
        $kalimat = $kalimat . '...';
    }

    return $kalimat;
}

function getSettingValue($name) {
    $revalue = '';
    $sql = "SELECT * FROM sys_setting WHERE setting_name LIKE '$name'";
    $run = mysqli_query($sql);
    while ($row = mysqli_fetch_array($run)) {
        $revalue = $row['setting_value'];
    }
    return $revalue;
}

function rupiah($angka) {
    $rupiah = number_format($angka, 0, '', '.');
    return $rupiah;
}

function terbilang($angka) {
    // pastikan kita hanya berususan dengan tipe data numeric
    $angka = (float) $angka;

    // array bilangan 
    // sepuluh dan sebelas merupakan special karena awalan 'se'
    $bilangan = array(
        '',
        'Satu',
        'Dua',
        'Tiga',
        'Empat',
        'Lima',
        'Enam',
        'Tujuh',
        'Delapan',
        'Sembilan',
        'Sepuluh',
        'Sebelas'
    );

    // pencocokan dimulai dari satuan angka terkecil
    if ($angka < 12) {
        // mapping angka ke index array $bilangan
        return $bilangan[$angka];
    } else if ($angka < 20) {
        // bilangan 'belasan'
        // misal 18 maka 18 - 10 = 8
        return $bilangan[$angka - 10] . ' belas';
    } else if ($angka < 100) {
        // bilangan 'puluhan'
        // misal 27 maka 27 / 10 = 2.7 (integer => 2) 'dua'
        // untuk mendapatkan sisa bagi gunakan modulus
        // 27 mod 10 = 7 'tujuh'
        $hasil_bagi = (int) ($angka / 10);
        $hasil_mod = $angka % 10;
        return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
    } else if ($angka < 200) {
        // bilangan 'seratusan' (itulah indonesia knp tidak satu ratus saja? :))
        // misal 151 maka 151 = 100 = 51 (hasil berupa 'puluhan')
        // daripada menulis ulang rutin kode puluhan maka gunakan
        // saja fungsi rekursif dengan memanggil fungsi terbilang(51)
        return sprintf('Seratus %s ', terbilang($angka - 100));
    } else if ($angka < 1000) {
        // bilangan 'ratusan'
        // misal 467 maka 467 / 100 = 4,67 (integer => 4) 'empat'
        // sisanya 467 mod 100 = 67 (berupa puluhan jadi gunakan rekursif terbilang(67))
        $hasil_bagi = (int) ($angka / 100);
        $hasil_mod = $angka % 100;
        return trim(sprintf('%s Ratus %s ', $bilangan[$hasil_bagi], terbilang($hasil_mod)));
    } else if ($angka < 2000) {
        // bilangan 'seribuan'
        // misal 1250 maka 1250 - 1000 = 250 (ratusan)
        // gunakan rekursif terbilang(250)
        return trim(sprintf('Seribu %s ', terbilang($angka - 1000)));
    } else if ($angka < 1000000) {
        // bilangan 'ribuan' (sampai ratusan ribu
        $hasil_bagi = (int) ($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
        $hasil_mod = $angka % 1000;
        return sprintf('%s Ribu %s', terbilang($hasil_bagi), terbilang($hasil_mod));
    } else if ($angka < 1000000000) {
        // bilangan 'jutaan' (sampai ratusan juta)
        // 'satu puluh' => SALAH
        // 'satu ratus' => SALAH
        // 'satu juta' => BENAR 
        // @#$%^ WT*
        // hasil bagi bisa satuan, belasan, ratusan jadi langsung kita gunakan rekursif
        $hasil_bagi = (int) ($angka / 1000000);
        $hasil_mod = $angka % 1000000;
        return trim(sprintf('%s Juta %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000) {
        // bilangan 'milyaran'
        $hasil_bagi = (int) ($angka / 1000000000);
        // karena batas maksimum integer untuk 32bit sistem adalah 2147483647
        // maka kita gunakan fmod agar dapat menghandle angka yang lebih besar
        $hasil_mod = fmod($angka, 1000000000);
        return trim(sprintf('%s Milyar %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else if ($angka < 1000000000000000) {
        // bilangan 'triliun'
        $hasil_bagi = $angka / 1000000000000;
        $hasil_mod = fmod($angka, 1000000000000);
        return trim(sprintf('%s Triliun %s', terbilang($hasil_bagi), terbilang($hasil_mod)));
    } else {
        return 'Wow...';
    }
}

function terbilangRupiah($x) {
    return terbilang($x) . ' Rupiah';
}

function getPeriodeAktif() {
    $sql = "SELECT * FROM periode ORDER BY id_periode DESC LIMIT 1";
    $result = mysqli_query($sql);
    $revalue;

    while ($row = mysqli_fetch_array($result)) {
        $revalue = $row['id_periode'];
    }
    return $revalue;
}

function cek_tanggal() {
    konek_db();
    $date = strftime("%d", time());
    $month = strftime("%M", time());
    $year = strftime("%Y", time());

    $lastdate;

    if ($date == "1") {
        $sql = "SELECT * FROM periode ORDER BY id_periode DESC LIMIT 1";
        $query = mysqli_query($sql);
        while ($row = mysqli_fetch_array($query)) {
            $lastdate = $row['periode_awal'];
        }

        $exdate = explode("-", $lastdate);

        $lastdate = $exdate[2];
        $lastmonth = $exdate[1];
        $lastyear = $exdate[0]; 
        
        
    }
}
