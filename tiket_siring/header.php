

<header class="header_area sticky-header">
	<div class="main_menu">
		<nav class="navbar navbar-expand-lg navbar-light main_box">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<a class="navbar-brand logo_h" href="index.php"><img src="img/ulm.png" alt="" width="75"></a>
				<button style="border: none;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
				 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if(isset($_SESSION['user'])) : ?>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
					<ul class="nav navbar-nav menu_nav ml-auto">
						<li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i>  Beranda</a></li>
						<li class="nav-item"><a class="nav-link" href="event/"><i class="fas fa-thumbtack"></i> Event</a></li>
						<li class="nav-item"><a class="nav-link" href="keranjang.php"><i class="fas fa-shopping-cart"></i> Keranjang</a></li>
						<li class="nav-item"><a class="nav-link" href="pesanan.php"><i class="fas fa-history"></i> Riwayat Pesanan</a></li>
						<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
					</ul>
				</div>
				<?php else: ?>
					<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
					<ul class="nav navbar-nav menu_nav ml-auto">
						<li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i> Beranda</a></li>
						<li class="nav-item"><a class="nav-link" href="event/"><i class="fas fa-thumbtack"></i> Event</a></li>
						<li class="nav-item"><a class="nav-link" href="#" onclick="return error();"><i class="fas fa-shopping-cart"></i> Keranjang</a></li>
						<li class="nav-item"><a class="nav-link" href="#" onclick="return error();"><i class="fas fa-history"></i> Riwayat Pesanan</a></li>
						<li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</nav>
	</div>
</header>