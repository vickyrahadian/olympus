<div id="navbar">
    <div id="navbar_wrapper">
        <?php $po = $_SESSION['po']; ?> 
        <div id="myslidemenu" class="jqueryslidemenu">
            <ul>

                <li><a href="index.php">HOME</a></li>
                <?php if ($po == 1){ ?>
                <li class="submenu"><a href="#">MASTER</a>
                    <ul>
                        <li><a href="?page=56e25509f5ada40a37a7c8388a64ea84">Barang</a>
                            <ul>
                                <li><a href="?page=56e25509f5ada40a37a7c8388a64ea84">Barang</a></li>
                                <li><a href="?page=535a57301992483d8910aec4beb7208c">Kategori Barang</a></li>
                                <li><a href="?page=96059108d1008f9de37504f43979e559">Satuan Barang</a></li>				
                            </ul>
                        </li>
                        <li><a href="?page=0f172aefd042aea1b9268d8ff7f3417e">Pegawai</a></li>
                        <li><a href="?page=49ca1406a878ded388044d03ce8f5846">Pelanggan</a></li>
                        <li><a href="?page=f5f8cf854f17cc58f640fbef37e690cd">Pemasok</a></li>
                        <li><a href="?page=41c770049d3c13e7e55695877bc2b139">Kendaraan</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($po == 1 || $po == 4 || $po == 3){ ?>
                <li class="submenu"><a href="#">TRANSAKSI</a>		
                    <ul>
                        <?php if ($po == 1 || $po == 4){ ?>
                        <li class="submenu"><a href="#">Pembelian</a>
                            <ul> 
                                <li><a href="?page=a517d25e3c5a0b46409a951ea6aaa1f7">Daftar Purchase Order</a></li>
                                <li><a href="?page=a09fb5efbe1d0486945f17991b632be8">Purchase Order</a></li>
                                <li><a href="?page=6f416c9ab6e7943b97d9308270197c40">Terima Barang</a></li>
                                <li><a href="?page=a9805a79b1a735be6c57f758dbbf8b05">Daftar Pembelian</a></li>
                                <li><a href="?page=fbaba39b277f18b03918ded3bf1a747d">Pembelian</a></li> 
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if ($po == 1 || $po == 3){ ?>
                        <li class="submenu"><a href="#">Penjualan</a>
                            <ul>                                
                                <li><a href="?page=18b80da66b885a22a8fbbec0f888da1a">Daftar Penjualan</a></li>
                                <li><a href="?page=608a4324ee806fc622773000c6c5d59b">Penjualan</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if ($po == 1 || $po == 4){ ?>
                        <li class="submenu"><a href="#">Hutang</a>
                            <ul>
                                <li><a href="?page=147cc23e964c5c51e136736d7b42e80f">Daftar Pembayaran Hutang</a></li>
                                <li><a href="?page=76783aae08a43f788a6109bff6cbd6e0">Pembayaran Hutang</a></li>
                            </ul>
                        </li>

                        <li class="submenu"><a href="#">Piutang</a>
                            <ul>
                                <li><a href="?page=c148691af9f007f22f5119788523ef2a">Daftar Pembayaran Piutang</a></li>
                                <li><a href="?page=49b76978c8167d798f38920f40bbc0d0">Pembayaran Piutang</a></li>
                            </ul>
                        </li>

                        <li class="submenu"><a href="#">Retur Beli</a>
                            <ul>
                                <li><a href="?page=3abc99ecf059ea26308765a86f94efa1">Daftar Retur Beli</a></li>
                                <li><a href="?page=23f8b01eb076b38790734eee285fd851">Retur Beli</a></li>
                            </ul>
                        </li>

                        <li class="submenu"><a href="#">Retur Jual</a>
                            <ul>
                                <li><a href="?page=e731ec68a8dbd5da28e04a704d4234d3">Daftar Retur Jual</a></li>
                                <li><a href="?page=fb84909712a613f3b9c1cc777a97dbf6">Retur Jual</a></li>
                            </ul>
                        </li>								
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if ($po == 1 || $po == 5){ ?>
                <li class="submenu"><a href="#">LAPORAN</a>
                    <ul>
                        <li><a href="?page=f1ff762d3b9a0ec95fa4ded87d57907d">Laporan Pembelian</a></li>				
                        <li><a href="?page=8446b9a991fdd4fd421ba5e2838a2b4c">Laporan Penjualan</a></li>
                        <li><a href="?page=eecd45073e784f79de84744073cd5fbc">Laporan Retur Beli</a></li>
                        <li><a href="?page=9ad85a6459db33ed502f7f2e7f3c3b6f">Laporan Retur Jual</a></li>
                        <li><a href="?page=0cee9fcdd3224e9013c43b0fca3b42c3">Laporan Pembayaran Hutang</a></li>
                        <li><a href="?page=8cdd98ff904265e6609b0c64b10a4c00">Laporan Pembayaran Piutang</a></li>
<!--                        <li><a href="?page=bfd35f0554c41ba4017aa74fdb774840">Laporan Stok Barang</a></li>-->
                    </ul>
                </li>
                <?php } ?>
                <?php if ($po == 1 || $po == 5 || $po == 2){ ?>
                <li class="submenu"><a href="#">ACCOUNTING</a>
                    <ul>
                        <li><a href="?page=a119d737f8697651c2e632f4cf9381d4">Laporan Keuangan</a></li>
                        <li><a href="?page=193279320513d8052fccdf0f35273f58">Kode Akun</a></li>
                        <li><a href="?page=160c3e33f770904a49769c312bcad317">Jurnal Umum</a></li> 
                        <li><a href="?page=ba9d8f49676bac747f2667492836ab2d">Buku Besar</a></li> 
                    </ul>
                </li>			

				<li class="submenu"><a href="?page=c46d87dec8167eb342fa1c6e4f8c7daa">FORECASTING</a>
                    <!--<ul>
               			<li><a href="?page=c46d87dec8167eb342fa1c6e4f8c7daa">Per Barang</a></li>
               			<li><a href="?page=1895d02d5806616bfe0e48481c9b72f4">Semua Barang</a></li>
                    </ul>-->
                </li>					
                <?php } ?>
                
                <?php if ($po == 1 || $po == 4){ ?>
<!--                <li class="submenu"><a href="#">INVENTORI</a>
                    <ul>
                        <li><a href="?page=2a63cc72f0c419ccc386216d0cb5510a">Stok Barang</a></li>
                        <li><a href="#">Opname Stok Barang</a></li>
                    </ul>
                </li>-->
                <?php } ?>
                
<!--                <li><a href="#">SETTING</a></li>-->
                
            </ul> 
            <br style="clear: left" />            
        </div>

    </div>
</div>