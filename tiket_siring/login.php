<?php 

session_start();
require 'functions.php';

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}


 if (isset($_POST["login"])) {
  
  $nohp = mysqli_real_escape_string($conn, $_POST["nohp"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  $user = query("SELECT * FROM user WHERE nohp = '$nohp'");
  foreach ($user as $a) {}

  ini_set("display_errors", 0);
  
if ($nohp == $a['nohp']) {

    $result = mysqli_query($conn, "SELECT * FROM user WHERE nohp = '$nohp'");


  if (mysqli_num_rows($result) === 1 ) {
    

    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {

                $_SESSION["login"] = true;
                $_SESSION["user"] = true;
                $_SESSION["nohp"] = $nohp;

                header("Location: event/");
                exit;
    }

  } 

}


$error = true;
  
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

			<?php if (isset($error)) : ?>

		        <script>
		            swal({
		              text: "Nomor Handphone / Password Salah",
		              icon: "error"
		            });
		        </script>

		    <?php endif; ?>


			<center>
				<div class="container mt-10">
					<img src="img/ulm.png" width="50" alt=""> 
					<br><br>
					<h3>Login</h3>
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
								<button type="submit" name="login" class="primary-btn nohp">Login</button>
								<!-- <a href="#">Forgot Password?</a> -->
							</div>
						</form>
					</div>
					<br>
					<p align="center">Belum Memiliki Akun? Daftar <a href="register.php"><u>disini</u></a></p>
					
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