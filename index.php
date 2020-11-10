<?php
session_start();
@$role = $_SESSION['po'];

if (isset($_SESSION['un'])) {
    require('fungsi.php');
    cek_tanggal();
    konek_db();

    @$cetak = $_GET['cetak'];
    @$page = $_GET['page'];
    @$popup = $_GET['popup'];

    if ($cetak == '1e04a1720c57aaa75b1d45eae45dfda8') {
        require('client/pembelian/cetak.php');        
    } else if ($cetak == '69a344a8d280d7ef8da2c73ed290ad57') {
        require('client/pembelian_po/cetak.php');
    } else if ($cetak == '72224b44309ffc2fc381c64295d64e92') {
        require('client/pembelian_retur/cetak.php');
    } else if ($cetak == '29b63e558b09ce6d0898459ea5ed9b27') {
        require('client/hutang/cetak.php');
    } else if ($cetak == 'd218d389d7dfc4f77c3bc12b71a1a51b') {
        require('client/penjualan/cetak.php');
    } else if ($cetak == 'f81c48c0dbfdbf0df9b04a2771e7eaed') {
        require('client/penjualan/cetak_1.php');
    } else if ($cetak == 'e2e1677134e890a57cb4607abd42c37f') {
        require('client/penjualan/cetak_surat_jalan.php');        
    } else if ($cetak == '6750c8feff18cbffd53544189d2372fb') {
        require('client/penjualan_retur/cetak.php');
    } else if ($cetak == 'a51dd137973b67eab9fa1097fd512afe') {
        require('client/piutang/cetak.php');
    } else if ($cetak == '4f77bfc1b16f286c42dfc6cfa8caf733') {
        require('client/laporan_pembelian/pembelian_cetak.php');
    } else if ($cetak == '0a660f4c7cac6c65667f6acdd4605e5d') {
        require('client/laporan_penjualan/cetak.php');
    } else if ($cetak == '0ae4a3d44d945832edcf2d5b579bfe8b') {
        require('client/laporan_retur_beli/cetak.php');
    } else if ($cetak == '3318229a0e7668cecc196eedfc6b3a87') {
        require('client/laporan_retur_jual/cetak.php');
    } else if ($cetak == '6d8cfb04d407d520f9da9f5a06d2c46e') {
        require('client/laporan_hutang/cetak.php');
    } else if ($cetak == 'e09c7f79ae7dfbee0ea2ef41e8a51ccf') {
        require('client/laporan_piutang/cetak.php');
    } else if ($cetak == 'aa58fe302cd47e9db1154285af8cb8d2') {
        require('client/accounting_jurnalumum/cetak.php');
    } else if ($cetak == '682f8c5261ae5a53cbdf433d9b289fbe') {
        require('client/accounting_bukubesar/cetak.php');
    } else if ($cetak == 'db05f210afc7a3f0c6a8292d8af3c8b9') {
        require('client/accounting_periode/cetak.php');
    } else if ($cetak == '257a3007200d55d50bfef4dbec3d5082') {
        require('client/accounting_laporankeuangan/cetak.php');
    } else {
        ?>
        <html>
            <head>
                <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <link href="asset/css/reset.css" rel="stylesheet" type="text/css" />
                <link href="asset/css/style.css" rel="stylesheet" type="text/css" />
                <link href="asset/css/jquery.datepick.css" rel="stylesheet" type="text/css" />
                <link href="asset/css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
                <link href="asset/css/alertify.core.css" rel="stylesheet" type="text/css" />
                <link href="asset/css/alertify.default.css" rel="stylesheet" type="text/css" /> 
                <link href="asset/css/jquery.jqplot.css" rel="stylesheet" type="text/css" /> 
                <link href="asset/css/jquery.qtip.css" rel="stylesheet" type="text/css" /> 

                <!--
                <link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
                <link href='http://fonts.googleapis.com/css?family=Denk+One' rel='stylesheet' type='text/css'>    
                -->

                <script type="text/javascript" src="asset/js/jquery.js"></script> 
                <script type="text/javascript" src="asset/js/olympus.js"></script> 
                <script type="text/javascript" src="asset/js/jquery.datepick.js"></script>
                <script type="text/javascript" src="asset/js/file_uploads.js"></script> 
                <script type="text/javascript" src="asset/js/shortcut.js"></script>
                <script type="text/javascript" src="asset/js/jqueryslidemenu.js"></script>
                <script type="text/javascript" src="asset/js/alertify.min.js"></script> 
                <script type="text/javascript" src="asset/js/jquery.jqplot.js"></script>
                <script type="text/javascript" src="asset/js/jquery.qtip.js"></script>
                <!--[if lt IE 9]><script type="text/javascript" src="asset/js/excanvas.js"></script><![endif]-->

                <script type="text/javascript" src="asset/js/plugins-grafik/jqplot.dateAxisRenderer.min.js"></script>
                <script type="text/javascript" src="asset/js/plugins-grafik/jqplot.canvasTextRenderer.min.js"></script>
                <script type="text/javascript" src="asset/js/plugins-grafik/jqplot.canvasAxisTickRenderer.min.js"></script>
                <script type="text/javascript" src="asset/js/plugins-grafik/jqplot.categoryAxisRenderer.min.js"></script>
                <script type="text/javascript" src="asset/js/plugins-grafik/jqplot.barRenderer.min.js"></script>

                <?php
                //tes
                ?>
                <script>

                    const USERNAME = "<?php echo $_SESSION['un']; ?>";
                    const USERID = "<?php echo $_SESSION['id']; ?>";
                    const USERPOSITION = "<?php echo $_SESSION['po']; ?>";
                    $(document).ready(function() {

                        $(document).attr('title', 'Olympus v0.1 - Sistem Informasi Penjualan, Pembelian dan Persediaan Barang - Palangjaya');
                        alertify.set({delay: 3000});
                        $('input').keyup(function() {
                            $(this).css('background-color', 'white');
                        });

                    });
                </script>
            </head>

            <body>

                <?php
                //FORM PURCHASE ORDER
                if ($page == '39a8251472a0ea048654481ca53cd62a') {
                    require('client/pembelian_po/popup_pemasok.php');
                } else if ($page == '7ca200aa02d3729ea04d8fa5e3d4e723') {
                    require('client/pembelian_po/popup_barang.php');
                } else if ($page == '518f2282e4255da235d5c5dc1f0e0d7e') {
                    require('client/pembelian_po/popup_order.php');
                }                
                
                //FORM PEMBELIAN
                else if ($page == 'eef3ece3b25077f1449cdc39ebd87125') {
                    require('client/pembelian/popup_pemasok.php');
                } else if ($page == '8bb19631b2135c1a4ca3b278b98805fe') {
                    require('client/pembelian/popup_barang.php');
                }

                //FORM RETUR BELI
                else if ($page == '4b155af3ecd847b960cd0d8d2e6338cc') {
                    require('client/pembelian_retur/popup_pembelian.php');
                }

                //FORM PEMBAYARAN HUTANG			
                else if ($page == '99ee36095c8580cdc6ec6a3b55eac16f') {
                    require('client/hutang/popup_pemasok.php');
                }

                //FORM PENJUALAN
                else if ($page == '34c364a07301067bee97a99b1904f43e') {
                    require('client/penjualan/popup_pelanggan.php');
                } else if ($page == 'b55857d896af521ddadfc2a62e4a0b6a') {
                    require('client/penjualan/popup_barang.php');
                }

                //FORM RETUR JUAL
                else if ($page == 'e0c0d984d33cbdd6ad56e714da479a3d') {
                    require('client/penjualan_retur/popup_penjualan.php');
                }

                //FORM PEMBAYARAN PIUTANG
                else if ($page == 'e5140a17d0a38aa41471c69c4f6391fe') {
                    require('client/piutang/popup_pelanggan.php');
                }

                //FORECASTING
                else if ($page == '992aadacd760fa01e53fc9f4ca3610d8') {
                    require('client/forecasting/popup_barang.php');
                }

                //LAPORAN PEMBELIAN
                else if ($page == '4a4875fc8931624b0daeed8ff621e7e9') {
                    require('client/laporan_pembelian/popup_pemasok.php');
                }

                //LAPORAN PENJUALAN
                else if ($page == 'a1d65ca2b4f53fa1e0131bba95686d24') {
                    require('client/laporan_penjualan/popup_pelanggan.php');
                }

                //LAPORAN RETUR PEMBELIAN
                else if ($page == 'a04482673f2f92a1b01d82365db904ba') {
                    require('client/laporan_retur_beli/popup_pemasok.php');
                }

                //LAPORAN RETUR PENJUALAN
                else if ($page == '9d30099200ef101108a7739587fa5c97') {
                    require('client/laporan_retur_jual/popup_pelanggan.php');
                }
                
                //LAPORAN PEMBAYARAN UTANG
                else if ($page == 'f70f32dc3f0862dbfb257c365fe97be4') {
                    require('client/laporan_hutang/popup_pemasok.php');
                }
                
                //LAPORAN PEMBAYARAN PIUTANG
                else if ($page == '56a21daaa04eab1a1dac93fba3355827') {
                    require('client/laporan_piutang/popup_pelanggan.php');
                }

                //LAPORAN STOK BARANG
                else if ($page == '3d4e2020b15512aaab0a426457a4b03e') {
                    require('client/laporan_stok/popup_barang.php');
                }

                //FORM LAIN
                else {
                    require('navbar.php');
                    require('banner.php');
                    ?>
                    <div id="content">
                        <div id="content_wrapper">
                            <?php
                            //master

                            if ($page == '56e25509f5ada40a37a7c8388a64ea84') {
                                require('client/barang/barang.php');
                            } else if ($page == '535a57301992483d8910aec4beb7208c') {
                                require('client/barang_kategori/barang_kategori.php');
                            } else if ($page == '96059108d1008f9de37504f43979e559') {
                                require('client/barang_satuan/barang_satuan.php');
                            } else if ($page == '0f172aefd042aea1b9268d8ff7f3417e') {
                                require('client/pegawai/pegawai.php');
                            } else if ($page == '49ca1406a878ded388044d03ce8f5846') {
                                require('client/pelanggan/pelanggan.php');
                            } else if ($page == 'f5f8cf854f17cc58f640fbef37e690cd') {
                                require('client/pemasok/pemasok.php');
                            } else if ($page == '41c770049d3c13e7e55695877bc2b139') {
                                require('client/kendaraan/kendaraan.php');
                            }

                            //pembelian 
                            else if ($page == 'fbaba39b277f18b03918ded3bf1a747d') {
                                require('client/pembelian/pembelian.php');
                            } else if ($page == 'a9805a79b1a735be6c57f758dbbf8b05') {
                                require('client/pembelian/pembelian_daftar.php');
                            } else if ($page == 'a09fb5efbe1d0486945f17991b632be8') {
                                require('client/pembelian_po/pembelian_po.php');
                            } else if ($page == 'a517d25e3c5a0b46409a951ea6aaa1f7') {
                                require('client/pembelian_po/pembelian_po_daftar.php');
                            } else if ($page == '6f416c9ab6e7943b97d9308270197c40') {
                                require('client/pembelian_po/pembelian_po_terimabarang.php');
                            }

                            //retur beli
                            else if ($page == '23f8b01eb076b38790734eee285fd851') {
                                require('client/pembelian_retur/pembelian_retur.php');
                            } else if ($page == '3abc99ecf059ea26308765a86f94efa1') {
                                require('client/pembelian_retur/pembelian_retur_daftar.php');
                            }

                            //hutang
                            else if ($page == '76783aae08a43f788a6109bff6cbd6e0') {
                                require('client/hutang/hutang_pembayaran.php');
                            } else if ($page == '147cc23e964c5c51e136736d7b42e80f') {
                                require('client/hutang/hutang_pembayaran_daftar.php');
                            }

                            //penjualan 
                            else if ($page == '608a4324ee806fc622773000c6c5d59b') {
                                require('client/penjualan/penjualan.php');
                            } else if ($page == '18b80da66b885a22a8fbbec0f888da1a') {
                                require('client/penjualan/penjualan_daftar.php');
                            }

                            //retur jual
                            else if ($page == 'fb84909712a613f3b9c1cc777a97dbf6') {
                                require('client/penjualan_retur/penjualan_retur.php');
                            } else if ($page == 'e731ec68a8dbd5da28e04a704d4234d3') {
                                require('client/penjualan_retur/penjualan_retur_daftar.php');
                            }

                            //piutang
                            else if ($page == '49b76978c8167d798f38920f40bbc0d0') {
                                require('client/piutang/piutang_pembayaran.php');
                            } else if ($page == 'c148691af9f007f22f5119788523ef2a') {
                                require('client/piutang/piutang_pembayaran_daftar.php');
                            }

                            //inventori
                            else if ($page == '2a63cc72f0c419ccc386216d0cb5510a') {
                                require('client/inventori/inventori.php');
                            }

                            //forecasting
                            else if ($page == 'c46d87dec8167eb342fa1c6e4f8c7daa') {
                                require('client/forecasting/forecasting.php');
                            } else if ($page == '1895d02d5806616bfe0e48481c9b72f4') {
                                require('client/forecasting_all/forecasting.php');
                            }

                            //accounting
                            else if ($page == '193279320513d8052fccdf0f35273f58') {
                                require('client/accounting_koderekening/koderekening.php');
                            } else if ($page == '160c3e33f770904a49769c312bcad317') {
                                require('client/accounting_jurnalumum/jurnalumum.php');
                            } else if ($page == 'a119d737f8697651c2e632f4cf9381d4') {
                                require('client/accounting_laporankeuangan/laporankeuangan.php');
                            } else if ($page == 'ba9d8f49676bac747f2667492836ab2d') {
                                require('client/accounting_bukubesar/bukubesar.php');
                            }

                            //laporan
                            else if ($page == 'f1ff762d3b9a0ec95fa4ded87d57907d') {
                                require('client/laporan_pembelian/laporan_pembelian.php');
                            } else if ($page == '8446b9a991fdd4fd421ba5e2838a2b4c') {
                                require('client/laporan_penjualan/laporan_penjualan.php');
                            } else if ($page == 'eecd45073e784f79de84744073cd5fbc') {
                                require('client/laporan_retur_beli/laporan_retur_beli.php');
                            } else if ($page == '9ad85a6459db33ed502f7f2e7f3c3b6f') {
                                require('client/laporan_retur_jual/laporan_retur_jual.php');
                            } else if ($page == '0cee9fcdd3224e9013c43b0fca3b42c3') {
                                require('client/laporan_hutang/laporan_hutang.php');
                            } else if ($page == '8cdd98ff904265e6609b0c64b10a4c00') {
                                require('client/laporan_piutang/laporan_piutang.php');
                            } else if ($page == 'bfd35f0554c41ba4017aa74fdb774840') {
                                require('client/laporan_stok/laporan_stok.php');
                            }
                            
                            //other
                            else if ($page == '3664659fb51a05aadf77898278645031') {
                                require('client/other/profil.php');
                            } else {
                                require('client/other/mainpage.php');
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    require('footer.php');
                }
                ?>

            </body>
        </html>
        <?php
    }
} else {
    ?>

    <script type="text/javascript">
        <!-- 
            window.location = "login.php";
    -->
    </script>

    <?php
}
?>

    <!--
    
    LICENCE CODE        : 89dca2cd55405c6a17b90ec6e06f31ce
    REGISTERED EMAIL    : vicky.rahadian@gmail.com
    
    -WARNING-
    
    Sistem informasi penjualan dan pembelian pada 
    toko bangunan palangjaya ini merupakan produk dari saya, 
    Vicky Rahadian Firmansyah. Jika anda ingin menggunakan 
    aplikasi ini untuk keperluan komersil (diluar dari 
    lingkup tujuan pendidikan dari institusi 
    Universitas Kristen Maranatha) maka
    anda bisa menghubungi saya untuk mendapatkan kode lisensi secara gratis.
    Lisensi ini akan bermanfaat jika anda ingin melakukan customisasi 
    atau perubahan dan penambahan modul lain pada sistem.
    
    Lisensi tersebut adalah bukti otentik bahwa saya sebagai 
    pembuat sistem telah memberikan hak dan izin kepada anda untuk
    menggunakan sistem informasi ini untuk kepentingan
    komersil anda. Mari hargai developer lokal untuk
    terus berkarya demi kemajuan dunia IT di Indonesia
    
    Pembuat aplikasi bisa dihubungi di 
    Email : vicky.rahadian@gmail.com
    FB    : facebook.com/mn3mon1x
    Twitter : @_viiickyyy
    
    silahkan kirimkan data sebagai berikut :
    Nama 
    No Telepon
    Email
    Nama Perusahaan / Institusi
    
    -->