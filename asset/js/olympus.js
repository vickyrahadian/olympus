function fillPagination(hal, totalHalaman) {
    var reValue = '';
    if (hal > 1) {
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + 1 + ')"><< First</span> ';
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal - 1) + ')">< Prev</span> ';
    }

    if (hal - 3 > 0)
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal - 3) + ')">' + (hal - 3) + '</span> ';
    if (hal - 2 > 0)
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal - 2) + ')">' + (hal - 2) + '</span> ';
    if (hal - 1 > 0)
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal - 1) + ')">' + (hal - 1) + '</span> ';

    reValue += '<b><span class="tombol_pagination"><strong><font color="darkred">' + hal + '</font></strong></span></b> ';

    if (hal + 1 <= totalHalaman)
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal + 1) + ')">' + (hal + 1) + '</span> ';
    if (hal + 2 <= totalHalaman)
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal + 2) + ')">' + (hal + 2) + '</span> ';
    if (hal + 3 <= totalHalaman)
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal + 3) + ')">' + (hal + 3) + '</span> ';

    if (hal < totalHalaman) {
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (hal + 1) + ')">Next ></span> ';
        reValue += '<span class="tombol_pagination" onclick="pagingCLick(' + (totalHalaman) + ')">Last >></span> ';
    }


    return reValue;
}

function IsAngka(e) {
    var t = e.which;
    if (t > 31 && (t < 48 || t > 57)) {
        return false
    }
}

function openWindow(e) {
    return window.open(e, 'search items', 'left=40,top=40,width=800,height=550,toolbar=0,resizable=0,scrollbars=1')
}

function cetak(e, id) {
    return window.open(e + '&id=' + id, 'print', 'left=25,top=25,width=830,height=620,toolbar=0,resizable=0,scrollbars=1')
}

function cetakLaporan(e, type, startdate, enddate, id) {
    return window.open(e + '&type=' + type + '&startdate=' + startdate + '&enddate=' + enddate + '&id=' + id, 'print', 'left=25,top=25,width=830,height=620,toolbar=0,resizable=0,scrollbars=1')
}

function printLaporan(e, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10) {
    return window.open(e + '&p1=' + p1 + '&p2=' + p2 + '&p3=' + p3 + '&p4=' + p4 + '&p5=' + p5 + '&p6=' + p6 + '&p7=' + p7 + '&p8=' + p8 + '&p9=' + p9 + '&p10=' + p10, 'print', 'left=25,top=25,width=830,height=620,toolbar=0,resizable=0,scrollbars=1')
}

function toRp(angka) {
    if (angka == '') {
        return 'Rp. 0';
    } else {
        if (angka < 0) {

            angka = angka * -1;

            var rev = parseInt(angka, 10).toString().split('').reverse().join('');
            var rev2 = '';
            for (var i = 0; i < rev.length; i++) {
                rev2 += rev[i];
                if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                    rev2 += '.';
                }
            }

            return 'Rp. -' + rev2.split('').reverse().join('');
        } else {
            var rev = parseInt(angka, 10).toString().split('').reverse().join('');
            var rev2 = '';
            for (var i = 0; i < rev.length; i++) {
                rev2 += rev[i];
                if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                    rev2 += '.';
                }
            }
            return 'Rp. ' + rev2.split('').reverse().join('');
        }
    }
}

function toAngka(angka) {
    var teks = angka;
    var split1 = teks.split(' '); 
    var split3 = split1[1].split('.');

    var banyakArray = split3.length;
    var reValue = '';
    for (i = 0; i < banyakArray; i++) {
        reValue += split3[i];
    }

    return reValue;
}

function changeToRp(nilai) {
    if ($(nilai).val() == '') {
        $(nilai).val('');
    } else {
        $(nilai).val(toRp($(nilai).val()));
    }
}

function changeToAngka(nilai) {
    if ($(nilai).val() == '' || $(nilai).val() == 'Rp. 0,00') {
        $(nilai).val('');
    } else {
        $(nilai).val(toAngka($(nilai).val()));
    }
}

function disableF5(e) {
    if ((e.which || e.keyCode) == 116)
        e.preventDefault();
}

function checkDate(tanggalAwal, tanggalAkhir) {

    var date = tanggalAwal.substring(0, 2);
    var month = tanggalAwal.substring(3, 5);
    var year = tanggalAwal.substring(6, 10);

    var awal = new Date(year, month - 1, date);
    awal.setHours(0, 0, 0, 0);

    date = tanggalAkhir.substring(0, 2);
    month = tanggalAkhir.substring(3, 5);
    year = tanggalAkhir.substring(6, 10);

    var akhir = new Date(year, month - 1, date);
    akhir.setHours(0, 0, 0, 0);

    //alert(awal);
    //alert(akhir);

    if (awal >= akhir) {
        return true;
    }
    else {
        return false;
    }
}

function getTodayDate() {
    var monthname = new Array("Und", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des");

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }
    today = dd + '/' + mm + '/' + yyyy;

    return today;
}

function pindahLokasi(alamatBaru) {
    window.location = '?page=' + alamatBaru;
}

function dateToString(dateIn) {
    var reValue = '';
    var arrayBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    var dateSplit = dateIn.split('-');
    reValue = dateSplit[2] + " " + arrayBulan[dateSplit[1] - 1] + " " + dateSplit[0];
    return reValue;
}

function convertDateToDatabse(dateIn) {
    var reValue = '';
    var dateSplit = dateIn.split('/');
    return dateSplit[2] + '-' + dateSplit[1] + '-' + dateSplit[0];
}

function convertDatabaseToDate(dateIn) {
    var reValue = '';
    var dateSplit = dateIn.split('-');
    return dateSplit[2] + '/' + dateSplit[1] + '/' + dateSplit[0];
}

function terbilang(bilangan) {

    bilangan = String(bilangan);
    var angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
    var kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
    var tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');

    var panjang_bilangan = bilangan.length;

    /* pengujian panjang bilangan */
    if (panjang_bilangan > 15) {
        kaLimat = "Diluar Batas";
        return kaLimat;
    }

    /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
    for (i = 1; i <= panjang_bilangan; i++) {
        angka[i] = bilangan.substr(-(i), 1);
    }

    i = 1;
    j = 0;
    kaLimat = "";


    /* mulai proses iterasi terhadap array angka */
    while (i <= panjang_bilangan) {

        subkaLimat = "";
        kata1 = "";
        kata2 = "";
        kata3 = "";

        /* untuk Ratusan */
        if (angka[i + 2] != "0") {
            if (angka[i + 2] == "1") {
                kata1 = "Seratus";
            } else {
                kata1 = kata[angka[i + 2]] + " Ratus";
            }
        }

        /* untuk Puluhan atau Belasan */
        if (angka[i + 1] != "0") {
            if (angka[i + 1] == "1") {
                if (angka[i] == "0") {
                    kata2 = "Sepuluh";
                } else if (angka[i] == "1") {
                    kata2 = "Sebelas";
                } else {
                    kata2 = kata[angka[i]] + " Belas";
                }
            } else {
                kata2 = kata[angka[i + 1]] + " Puluh";
            }
        }

        /* untuk Satuan */
        if (angka[i] != "0") {
            if (angka[i + 1] != "1") {
                kata3 = kata[angka[i]];
            }
        }

        /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
        if ((angka[i] != "0") || (angka[i + 1] != "0") || (angka[i + 2] != "0")) {
            subkaLimat = kata1 + " " + kata2 + " " + kata3 + " " + tingkat[j] + " ";
        }

        /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
        kaLimat = subkaLimat + kaLimat;
        i = i + 3;
        j = j + 1;

    }

    /* mengganti Satu Ribu jadi Seribu jika diperlukan */
    if ((angka[5] == "0") && (angka[6] == "0")) {
        kaLimat = kaLimat.replace("Satu Ribu", "Seribu");
    }

    return kaLimat + "Rupiah";
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
        vars[key] = value;
    });
    return vars;
}

function toggleForm(param) {
    if (param == 'forminput') {
        if ($('#' + param).css('display') == 'none') {
            $('#' + param).show();
        } else {
            $('#' + param).hide();
        }
    }
}

function echeck(str) {

    var at = "@"
    var dot = "."
    var lat = str.indexOf(at)
    var lstr = str.length
    var ldot = str.indexOf(dot)
    if (str.indexOf(at) == -1) {
        return false
    }

    if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr) {
        return false
    }

    if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr) {
        return false
    }

    if (str.indexOf(at, (lat + 1)) != -1) {
        return false
    }

    if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot) {
        return false
    }

    if (str.indexOf(dot, (lat + 2)) == -1) {
        return false
    }

    if (str.indexOf(" ") != -1) {
        return false
    }

    return true
}
