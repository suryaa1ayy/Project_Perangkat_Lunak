<?php 

session_start();
require 'functions.php';

function registrasi($data) {
    global $conn;

    // htmlspecialchars berfungsi untuk tidak menjalankan script
    $nohp = htmlspecialchars($data["nohp"]);
    $password_sebelum = htmlspecialchars($data["password"]);

    // cek nohp user sudah ada atau belum

	$ceknohpuser = "SELECT * FROM user where nohp = '$nohp'";
	$prosescek= mysqli_query($conn, $ceknohpuser);

	if (mysqli_num_rows($prosescek)>0) { 
	    echo "<script>alert('Nomor Sudah Digunakan!');history.go(-1) </script>";
	    exit;
	}

	// enkripsi password
	$password = password_hash($password_sebelum, PASSWORD_DEFAULT);
       
        // tambahkan ke database
        // NULL digunakan karena jika dikosongkan maka akan terjadi error di database yang sudah online
        // sedangkan jika masih di localhost, bisa memakai ''
    mysqli_query($conn, "INSERT INTO user VALUES(NULl, '$nohp', '$password')");
    return mysqli_affected_rows($conn);
}

if (isset($_POST["register"])) {
  
  if (registrasi($_POST) > 0 ) {
     $success = true;
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

	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section>
		<div class="container">

			<?php if (isset($success)) : ?>

		        <script>
		            swal({
		              title: "Berhasil Mendaftar",
		              text: "Silahkan Login",
		              icon: "success"
		            });
		        </script>

		    <?php endif; ?>

			<center>
				<div class="container mt-10">
					<img src="img/ulm.png" width="50" alt=""> 
					<br><br>
					<h3>Daftar</h3>
				</div>
			</center>


			<div class="row">
				<div class="col">
					<div class="">
						<form class="row login_form" action="" method="post" id="contactForm" novalidate="novalidate" onsubmit="return cekLogin();">
							<div class="col-md-12 form-group">
								<div class="row">
									<div class="col-2">
										<input type="text" value="+62" readonly>
									</div>
									<div class="col-10">
										<input type="number" class="form-control nohp" id="nohp" name="nohp" placeholder="Masukkan Nomor Handphone / Whatsapp">
									</div>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control nohp" id="password" name="password" placeholder="Masukkan Password">
							</div>
							<!-- <div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div>
							-->
							<div class="col-md-12 form-group">
								<button type="submit" name="register" class="primary-btn nohp">Daftar</button>
							</div>
						</form>
					</div>
					<br>
					<p align="center">Sudah Memiliki Akun? Login <a href="login.php"><u>disini</u></a></p>
					
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<nav class=" fixed-bottom text-center py-3" style="box-shadow: 2px 2px 20px lightgrey;">
      <center>
      	<span style="font-size:0.9rem;">Whatsapp Admin &nbsp; <i class="fas fa-long-arrow-alt-right"></i> &nbsp; <a class="nohp" style="color:white;background-color: #03DC03;padding: 5px 10px;border-radius: 7px;" href=""><i class="fab fa-whatsapp"></i> (0511) 3306694</a>
						</span>
					</center>
    </nav>


	<?php include 'plugin.php'; ?>

	<script>
		function cekLogin() {

			var nohp = document.getElementById('nohp');
			var password = document.getElementById('password');

			if (nohp.value == "") {
				swal({
              text: "Mohon Mengisi Nomor Handphone",
              icon: "warning"
            });
	            return false;
			}

			if (password.value == "") {
				swal({
              text: "Mohon Mengisi Password",
              icon: "warning"
            });
	            return false;
			}
		}
	</script>
</body>

</html>