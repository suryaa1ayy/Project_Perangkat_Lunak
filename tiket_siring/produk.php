<?php 
session_start();

include 'functions.php';

if (!isset($_SESSION['nohp'])) {
	echo "<script>
		window.location.href='login.php';
	</script>";
	exit;
}
if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$produk = query("SELECT * FROM produk WHERE id = $id")[0];
}


function addKeranjang($data) {
    global $conn;

    // htmlspecialchars berfungsi untuk tidak menjalankan script
    $nohp = htmlspecialchars($data["nohp"]);
    $id_produk = htmlspecialchars($data["id_produk"]);
    $jumlah = htmlspecialchars($data["keyword"]);
    $stok = htmlspecialchars($data["stok"]);
    $status = 'Menunggu Pembayaran';

    $zona_waktu = time() + (60 * 60 * 8);
    $tanggal = gmdate('Y-m-d H:i:s', $zona_waktu);

    $waktu = strtotime($tanggal);
    $batas = $waktu + 1800;

   

		$data_pesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_produk = '$id_produk' AND status = 'Menunggu Pembayaran' AND batas > '$waktu'");

		$selesai = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_produk = '$id_produk' AND status = 'Sudah Dibayar'");

	  $stok_awal = $stok;


	  $stok_kurang = 0;
		foreach ($data_pesanan as $dt) {
			$stok_kurang += $dt['jumlah'];
		}

		foreach ($selesai as $dt_selesai) {
			$stok_kurang += $dt_selesai['jumlah'];
		}

		$fstok = $stok_awal - $stok_kurang;


    if ($fstok < $jumlah) { 
		    echo "<script>
					    alert('Stok Tidak Mencukupi, Kurangi Jumlah Pesanan Anda');
					    window.location.href='produk.php?id=" . $id_produk . "'
					    </script>";
		    exit;
		} 

		mysqli_query($conn, "INSERT INTO pesanan VALUES(NULL, '$nohp', '$id_produk', '$jumlah', '$tanggal', '$waktu', '$batas', '$status', NULL, NULL, NULL, NULL)");
    return mysqli_affected_rows($conn);		    	
  	
}

if (isset($_POST["add"])) {

  if (addKeranjang($_POST) > 0 ) {
  	echo "<script>window.location.href='keranjang.php';</script>";
				    exit;
  } else {
    echo mysqli_error($conn);
  }

}

 ?>

<!DOCTYPE html>
<html lang="id" class="no-js">

<head>
	<?php include 'link.php'; ?>
</head>

<body>


	<!-- Start Header Area -->
	<?php include 'header.php'; ?>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Detail Produk</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Beranda<span class="lnr lnr-arrow-right"></span></a>
						<a href="katalog.php">Katalog<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Detail Produk</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Single Product Area =================-->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="">
						<div class="single-prd-item">
							<img class="img-fluid" src="foto/<?= $produk['gambar1']; ?>" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?= $produk['judul']; ?></h3>
						<h2> Rp<?= number_format($produk['harga'],0,',','.'); ?></h2>
						<ul class="list">
							<?php $idp = $produk['id']; ?>
							<?php $fitur = mysqli_query($conn, "SELECT * FROM fitur WHERE id_produk = '$idp'"); ?>
							<?php foreach ($fitur as $key) : ?>
							<li><a class="active"><span><?= $key['judul']; ?></span> : <b><?= $key['isi']; ?></b></a></li>
							<?php endforeach; ?>
						</ul>
						<p><?= $produk['deskripsi']; ?></p>

						<form action="" method="post">
						<input type="hidden" name="nohp" id="nohp" value="<?= $_SESSION['nohp']; ?>">
						<input type="hidden" name="id_produk" id="id_produk" value="<?= $produk['id']; ?>">
						<input type="hidden" name="stok" id="stok" value="<?= $produk['stok']; ?>">
						
						<div class="product_count">
							<?php 
						  $zona_waktu = time() + (60 * 60 * 8);
						  $tanggal_sekarang = gmdate('Y-m-d H:i:s', $zona_waktu);
						  $waktu_sekarang = strtotime($tanggal_sekarang);



							$data_pesanan = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_produk = '$id' AND status = 'Menunggu Pembayaran' AND batas > '$waktu_sekarang'");

							$selesai = mysqli_query($conn, "SELECT * FROM pesanan WHERE id_produk = '$id' AND status = 'Sudah Dibayar'");

						  $stok = $produk['stok'];


						  $stok_kurang = 0;
							foreach ($data_pesanan as $dt) {
								$stok_kurang += $dt['jumlah'];
							}

							foreach ($selesai as $dt_selesai) {
								$stok_kurang += $dt_selesai['jumlah'];
							}

							$fstok = $stok - $stok_kurang;




					    
					    ?>
							<label for="jumlah">Tiket Tersedia : <b><?= $fstok; ?></b></label>
						</div>

						<?php if ($fstok <= 0) : ?>
						<div class="card_area d-flex align-items-center">
							<button type='button' class="btn btn-danger">&nbsp; Maaf Tiket Habis</button>
						</div>
						<?php else: ?>
						<div class="card_area d-flex align-items-center">
							<button type='button' style="outline:none !important;border: none !important;box-shadow: 2px 2px 10px lightgrey;" class="btn primary-btn" data-toggle='modal' data-target='#checkout_modal'>&nbsp; Pesan Tiket</button>
						</div>
						<?php endif; ?>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->

	<!-- Modal -->

    <div class="modal fade" id="checkout_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-fullscreen-md-down modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="LoginModalLabel">
                Checkout
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" onsubmit="return cekpayment();" enctype="multipart/form-data">
            	<label for="keterangan">Jumlah Tiket : </label>
              <div class="mb-3 input-group flex-nowrap">
                <input type="number" class="form-control" name="keyword" id="keyword" placeholder="Masukkan Jumlah" required>
              </div>
              <br>
              <input type="hidden" id="id_produk" name="id_produk" value="<?= $produk['id']; ?>">
              <input type="hidden" id="stok" name="stok" value="<?= $produk['stok']; ?>">

              <div id="container2">
              	
              </div>
              
            	<!-- <label for="keterangan">Nama Lengkap : </label>
              <div class="mb-3 input-group flex-nowrap">
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Nama Lengkap">
              </div>
           	  <?php include 'rekening.php'; ?>
              <label class="mb-2" for="file"><i class="fas text-danger fa-long-arrow-alt-down"></i> Upload Bukti Pembayaran <i class="fas text-danger fa-long-arrow-alt-down"></i></label>
              <div class="mb-3 input-group">
                <input type="file" class="" name="file" id="file" onchange="Filevalidation()">
              </div>
              <div class="mb-3">
                  <input type="checkbox" required> Saya menyetujui <a href="sk.php">Syarat dan Ketentuan</a>
              </div> -->
              
          </div>
          <div class="modal-footer">
            <?php $nomor = $_SESSION['nohp']; ?>
            <input type="hidden" id="nohp" name="nohp" value="<?= $nomor; ?>">
            <button type="submit" name="add" class="btn text-white w-100" style="background-color:#6F01A2;">
                <i class="fas fa-sign-in-alt"></i> Konfirmasi Pesanan
            </button>
            </form>
          </div>
        </div>
      </div>
    </div>


	<!-- start footer Area -->
	<br><br><br>
	<?php include 'footer.php'; ?>
	<!-- End footer Area -->

	<?php include 'plugin.php'; ?>

	<?php if (isset($success)) : ?>
      <script>
          swal({
					  title: "Berhasil Masuk Keranjang",
					  text: "Silahkan Cek Keranjang Anda",
					  icon: "success"
					});
      </script> 
    <?php endif; ?>

    <script src="ajax.js"></script>

</body>

</html>