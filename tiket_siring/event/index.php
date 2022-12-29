<?php 
session_start();
include '../functions.php';
 ?>

<!DOCTYPE html>
<html lang="id">

<head>
	<?php include 'link.php'; ?>
<!-- 	<script>
		$(window).ready(function(){
			$('#halaman').hide();
		});
		

	  $(window).load(function() {
	    $('#loading').hide();
	    $('#halaman').show();
	  });
	</script> -->
</head>

<body id="category">

		<!-- <center>
		<div id="loading">
		  <br>
		  <p>Loading...</p>
		  <p><b>Sebentar yaa, pastikan internet kamu dalam keaadan baik.</b></p>
		</div>
		</center> -->

	<div id="halaman">

	<!-- Start Header Area -->
	<?php include 'header.php'; ?>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Event</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Beranda<span class="lnr lnr-arrow-right"></span></a>
						<a href="katalog.php">Event</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<div class="container-m">
		<div class="row">

				<!-- Loop Product Here -->


			<!-- Start Best Seller -->
			<?php $produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY RAND()"); ?>
				<section class="lattest-product-area pb-20 category-list">
					<div class="row">
						<?php foreach ($produk as $data) : ?>


						<div class="col-xl-4 col-lg-4 col-sm-6 col-md-6">
								<div class="single-product">
								<img class="img-fluid" src="../foto/<?= $data['gambar1']; ?>" alt="">
								<div class="product-details">
									<h6 class="font-m j" style="word-wrap: hid"><?= $data['judul']; ?></h6>
									<div class="price">
										<h6 class="text-success font-m">Rp<?= number_format($data['harga'],0,',','.'); ?></h6>
									</div>
									<div class="prd-bottom">
										
											<a href="../produk.php?id=<?= $data['id']; ?>" class="btn btn-sm font-m text-white" style="width:100%;background-color: #6F01A2;">Pesan Tiket <i class="fas fa-long-arrow-alt-right"></i></a>
										

									</div>
								</div>
							</div>
							
						</div>
						<?php endforeach; ?>


						
					</div>
				</section>
				
			</div>
		</div>
	</div>

	<?php include '../footer.php'; ?>

	</div>

	<?php include 'plugin.php'; ?>


	
</body>

</html>