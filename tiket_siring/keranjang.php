<?php 
session_start();

include 'functions.php';

$nohp = $_SESSION['nohp'];
error_reporting(0);

function paymentFun($data) {
    global $conn;

    $zona_waktu = time() + (60 * 60 * 8);
    $tanggal = gmdate('Y-m-d H:i:s', $zona_waktu);

    $waktu = strtotime($tanggal);

    // htmlspecialchars berfungsi untuk tidak menjalankan script
    $nohp = htmlspecialchars($data["nohp"]);
    $file = upload_foto();
    $keterangan = htmlspecialchars($data["keterangan"]);

    $zona_waktu = time() + (60 * 60 * 8);
    $tanggal_sekarang = gmdate('d', $zona_waktu);
    $date = gmdate('YmdHis', $zona_waktu);


    $user = query("SELECT id FROM user WHERE nohp = '$nohp'")[0];
    $id = $user['id'];
    $kode_unik = $id . $date;

    $query = "UPDATE pesanan SET 
        status = 'Sudah Dibayar',
        file = '$file',
        keterangan = '$keterangan',
        kode_unik = '$kode_unik'
        WHERE nohp = '$nohp' AND status = 'Menunggu Pembayaran' AND batas > '$waktu'
      ";


      
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

if (isset($_POST["add"])) {

  if (paymentFun($_POST) > 0 ) {

        $success = true;

  } else {
    echo mysqli_error($conn);
  }

}

$zona_waktu = time() + (60 * 60 * 8);
$tanggal = gmdate('Y-m-d H:i:s', $zona_waktu);

$waktu = strtotime($tanggal);

$pesanan = mysqli_query($conn, "SELECT pesanan.batas as batas, pesanan.status as status, pesanan.tanggal as tanggal, pesanan.id as id, pesanan.jumlah as jumlah, produk.judul as judul, produk.deskripsi as deskripsi, produk.harga as harga FROM pesanan JOIN produk ON pesanan.id_produk = produk.id WHERE pesanan.nohp = '$nohp' AND status = 'Menunggu Pembayaran' AND pesanan.batas > '$waktu'");




 ?>

<!DOCTYPE html>
<html lang="id" class="no-js">

<head>
    <?php include 'link.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timecircles/1.5.3/TimeCircles.min.js" integrity="sha512-FofOhk0jW4BYQ6CFM9iJutqL2qLk6hjZ9YrS2/OnkqkD5V4HFnhTNIFSAhzP3x//AD5OzVMO8dayImv06fq0jA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                    <h1>Keranjang</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Beranda<span class="lnr lnr-arrow-right"></span></a>
                        <a href="riwayat.php">Keranjang</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <?php if (isset($success)) : ?>

        <script>
            swal({
              title: "Pesanan Berhasil Dikonfirmasi",
              text: "Silahkan Cek Riwayat Pesanan Anda",
              icon: "success"
            });
        </script>

    <?php endif; ?>


    <!--================Cart Area =================-->
    <div class="container mb-2 mt-5">
        <div class="text-center">
            
        </div>
    </div>

    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <p><b>Geser untuk detail pesanan anda <i class="fas fa-long-arrow-alt-right"></i></b></p>
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2">Status</th>
                                <th scope="col">Event</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Tanggal Pesanan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pesanan as $data) : ?>
                            <tr>
                                <td>
                                    <h5>
                                            <?= $data['status']; ?>
                                    </h5> <br>
                                    <?php 
                                        $zona_waktu = time() + (60 * 60 * 8);
                                        $tanggal = gmdate('Y-m-d H:i:s', $zona_waktu);
                                        $waktu = strtotime($tanggal); 
                                    ?>
                                    <?php $batass = $data['batas']; ?>
                                    <?php 

                                    $time_left = $batass - $waktu;

                                    $min = floor($time_left / 60);
                                    $time_left %= 60;

                                    $sec = $time_left; ?>

                                    <?php $dl = $batass - $waktu; ?>
                                    <p>Deadline Pembayaran : <b class="text-danger"><?= $min; ?> Menit <?= $sec; ?> Detik</b></p>

                                </td>
                                
                                <td>
                                    <p><?= $data['judul']; ?></p>
                                </td>
                                <td>
                                    <h5>Rp<?= number_format($data['harga'],0,',','.'); ?></h5>
                                </td>
                                <td>
                                    <h5>x <?= $data['jumlah']; ?></h5>
                                </td>
                                <td>
                                    <?php $total = $data['harga'] * $data['jumlah']; ?>
                                    <h5>Rp<?= number_format($total,0,',','.'); ?></h5>
                                </td>
                                <td>
                                    <span><h5><b><?= date("d F Y",strtotime($data["tanggal"])); ?></b></h5></span>
                                </td>
                                <td>
                                    <a class="text-danger" href="hapus-item.php?id=<?= $data['id']; ?>"><i class="fas fa-times-circle fa-2x"></i></a>
                                </td>
                            </tr>
                            <?php $total_belanja += $total; ?>
                            <?php endforeach; ?>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <a style="width:100%;cursor: pointer;color: white;" data-toggle='modal' data-target='#checkout_modal'>
    <nav class=" fixed-bottom text-center py-3" style="box-shadow: 2px 2px 20px lightgrey;background-color: #6F01A2;">
      <center>
        &nbsp; Bayar Sekarang
    </center>
    </nav>
    </a>
    
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
              <input type="hidden" id="id_produk" name="id_produk" value="<?= $produk['id']; ?>">
              <input type="hidden" id="stok" name="stok" value="<?= $produk['stok']; ?>">

              <h4 align="center">Total Pembayaran : <b>Rp<?= number_format($total_belanja,0,',','.'); ?></b></h4>
            
              <?php include 'rekening.php'; ?>
              <label class="mb-2" for="file"><i class="fas text-danger fa-long-arrow-alt-down"></i> Upload Bukti Pembayaran <i class="fas text-danger fa-long-arrow-alt-down"></i></label>
              <div class="mb-3 input-group">
                <input type="file" class="" name="file" id="file" onchange="Filevalidation()">
              </div>
              <label for="keterangan">Nama Lengkap : </label>
              <div class="mb-3 input-group flex-nowrap">
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Nama Lengkap">
              </div>
<!--               <div class="mb-3">
                  <input type="checkbox" required> Saya menyetujui <a href="sk.php">Syarat dan Ketentuan</a>
              </div>
               -->
          </div>
          <div class="modal-footer">
            <?php $nomor = $_SESSION['nohp']; ?>
            <input type="hidden" id="nohp" name="nohp" value="<?= $nomor; ?>">
            <button type="submit" name="add" class="btn w-100 text-white" style="background-color:#6F01A2;">
                <i class="fas fa-sign-in-alt"></i> Konfirmasi Pesanan
            </button>
            </form>
          </div>
        </div>
      </div>
    </div>




    <!-- Modal -->

    <!-- start footer Area -->
    <?php include 'footer.php'; ?>
    <!-- End footer Area -->

    <script>
        function cekpayment() {
        var file = document.getElementById('file');
        var keterangan = document.getElementById('keterangan');
        var tgl_ambil = document.getElementById('tgl_ambil');

        var filePath = file.value;
        var allowedExtensions =
                    /(\.jpg|\.pdf|\.JPG|\.HEIC|\.heic|\.jpeg|\.JPEG|\.png|\.PNG)$/i;

        if (filePath != '') {

            if (!allowedExtensions.exec(filePath)) {
                fileType();
                return false;
            }

        }

        if(file.value == ''){
          error();
          file.focus();
          return false;
        } else if(keterangan.value == ''){
          error();
          keterangan.focus();
          return false;
        } else if(tgl_ambil.value == ''){
          error();
          tgl_ambil.focus();
          return false;
        } 

        function error() {
            swal({
              text: "Mohon lengkapi isian form yang masih kosong yaa",
              icon: "warning"
            });

        }
      }

        function fileType() {
            swal({
              text: "Gaboleh Upload File Selain Gambar Yaa",
              icon: "warning"
            });
        }
    </script>
    
    <?php include 'plugin.php'; ?>
</body>

</html>