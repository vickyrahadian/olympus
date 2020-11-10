<script>

function konfirmasilogout(){
    alertify.confirm('Anda yakin akan logout dari sesi ini ? <br /> &nbsp;', function (e) {
        if (e) {
            window.location = "login.php?proses=logout";
            return true;
        } else {
            return false;
        }
    });
}

</script>

<?php $po = $_SESSION['po']; ?> 

<div id="banner">
  <div id="banner_wrapper">
    <div id="logo"></div>
    <div id="quick_menu">
        
        <?php if ($po == 1 || $po == 3){ ?>
    	<a href="?page=608a4324ee806fc622773000c6c5d59b" class="tombol" id="penjualan">PENJUALAN</a>
        <?php } ?>
        <?php if ($po == 1 || $po == 4){ ?>
        <a href="?page=fbaba39b277f18b03918ded3bf1a747d" class="tombol" id="pembelian">PEMBELIAN</a>
        <a href="?page=fb84909712a613f3b9c1cc777a97dbf6" class="tombol" id="retur_jual">RETUR JUAL</a>
        <a href="?page=23f8b01eb076b38790734eee285fd851" class="tombol" id="retur_beli">RETUR BELI</a>
        <?php } ?>
    </div>
    <div id="profile_box">
    	<p id="username_dp">
<?php
    
    $un = $_SESSION['un'];
    $pict = '';
    $sql = "SELECT * FROM pegawai WHERE username LIKE '$un'";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)){
        $pict = $row['gambar'];
    }

	if (file_exists("asset/images/pegawai/$pict")) {
		echo "<img src=asset/images/pegawai/$pict width=28px height=38px />";
	} else {
		echo "<img src=\"asset/images/ina.jpg\" height=\"38px\" width=\"28px\" />";
	}
?>
        </p>
    	<p id="username"><?php echo $_SESSION['un']; ?></p>
        <p id="username_profile"><a href="?page=3664659fb51a05aadf77898278645031"></a><a href="#" onclick="return konfirmasilogout();">logout</a></p>        
    </div>
  </div>
</div> 