<?php 
require 'functions.php';

function hapus_pesanan($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM pesanan WHERE id = $id");

	return mysqli_affected_rows($conn);
}

$id = $_GET["id"];
if (hapus_pesanan($id) > 0 ) {
	echo "
		<script>
			document.location.href = 'keranjang.php';
		</script>
	";
    } else {
	echo "
		<script>
			document.location.href = 'keranjang.php';
		</script>
	";
	}
 ?>