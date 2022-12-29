<?php 
session_start();
require 'functions.php';

// if (!isset($_SESSION['user'])) {
//     header("Location: login.php");
//     exit;
// }

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

	<!-- start banner Area -->
	<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">
					<div class="">
						<!-- single-slide -->
						<div class="row single-slide align-items-center d-flex mt-5">
							<div class="col-lg-6 col-md-6">
								<div class="banner-content">
									<h2>Selamat Datang di Official Website E-Tiket Wisata Kelotok Siring Bekantan</h2>
									<button onclick="window.location.href='event/'" style="background-color:#6F01A2;" class="btn  text-white">Lihat Tiket <i class="fas fa-long-arrow-alt-right px-1"></i></button>
								</div>
							</div>
							<div class="col-lg-5">
								
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->

	<!-- start features Area -->
	<h2 class="my-5 text-center"><span style="border-bottom:2px solid blueviolet;">Informasi Terkini</span></h2>

	<?php $info = mysqli_query($conn, "SELECT * FROM info ORDER BY id DESC"); ?>
	<?php foreach ($info as $key) : ?>
	    <div class="mb-3">
	      <div class="card-body">
	      	<h3 class="judul-info"><?= $key['judul']; ?></h3>
	        <img src="foto/<?= $key['gambar']; ?>" class="img-fluid info" alt="">
	      </div>
	    </div>
	<?php endforeach; ?>


	<!-- end features Area -->

	<!-- Start Lokasi -->
	<!-- <section class="category-area">
		<div class="container">
			<div class="section-title text-center">
				<h1>Lokasi Kami</h1>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d418.68753152007207!2d114.59768017927861!3d-3.2882385857366536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de4236bdd451561%3A0xbd202d032d155744!2sKembar%20Laundry!5e0!3m2!1sid!2sid!4v1659440036415!5m2!1sid!2sid" style="width:100%;height: 400px; border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	</section>
	<br><br><br> -->
	<!-- End Lokasi Area -->
	

	<!-- start footer Area -->
	<?php include 'footer.php'; ?>
	<!-- End footer Area -->

	<?php include 'plugin.php'; ?>
</body>

</html>