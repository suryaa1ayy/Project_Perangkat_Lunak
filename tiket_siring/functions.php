<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "tiket_siring");


function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	};
	return $rows;
};

function regis($data) {
    global $conn;

    // htmlspecialchars berfungsi untuk tidak menjalankan script
    $username = htmlspecialchars($data["username"]);
    $password_sebelum = htmlspecialchars($data["password"]);
    $level = htmlspecialchars($data["level"]);

    // enkripsi password
    $password = password_hash($password_sebelum, PASSWORD_DEFAULT);
    
        // tambahkan ke database
        // NULL digunakan karena jika dikosongkan maka akan terjadi error di database yang sudah online
        // sedangkan jika masih di localhost, bisa memakai ''
    mysqli_query($conn, "INSERT INTO super_user VALUES(NULl, '$username', '$password', '$level')");
    return mysqli_affected_rows($conn);
}

function upload_foto() {
    $namaFile = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $tmpName = $_FILES['file']['tmp_name'];


    $ekstensifile = explode('.', $namaFile);
    $ekstensifile = strtolower(end($ekstensifile));

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensifile;
    move_uploaded_file($tmpName, 'file/' . $namaFileBaru);

    return $namaFileBaru;
}
