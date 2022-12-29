<?php 
session_start();

include 'functions.php';

$nohp = $_SESSION['nohp'];
error_reporting(0);


$zona_waktu = time() + (60 * 60 * 8);
$tanggal = gmdate('Y-m-d H:i:s', $zona_waktu);

$waktu = strtotime($tanggal);

$pesanan = mysqli_query($conn, "SELECT pesanan.kode_unik as kode_unik, pesanan.batas as batas, pesanan.status as status, pesanan.tanggal as tanggal, pesanan.id as id, pesanan.jumlah as jumlah, produk.judul as judul, produk.deskripsi as deskripsi, produk.harga as harga FROM pesanan JOIN produk ON pesanan.id_produk = produk.id WHERE pesanan.nohp = '$nohp' AND status = 'Sudah Dibayar'");




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
                    <h1>Pesanan Saya</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.php">Beranda<span class="lnr lnr-arrow-right"></span></a>
                        <a href="pesanan.php">Pesanan</a>
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
              <?php foreach($pesanan as $data) : ?>
              <br>
              <div class="text-dark row justify-content-between">
                  <div class="col" style="text-align:left;">
                      <span class="data"><?= $data['judul']; ?></span>
                  </div>
                  <div class="col" style="text-align:right;">
                      <span class="data">x <?= $data['jumlah']; ?></span>
                      <br>
                      <span class="data">Rp<?= number_format($data['harga'],0,',','.'); ?></span>
                  </div>
              </div>
              <br>
                  <div  style="text-align:left;">
                      <?php $total = $data['jumlah'] * $data['harga'];  ?>
                      <span class="data">Total Pesanan : <a class="badge badge-dark text-white" style="font-size:0.8rem;">Rp<?= number_format($total,0,',','.'); ?></a></span>
                  </div>
                  <div  style="text-align:left;" class="mt-2">
                      <span class="data">Tanggal Pesanan : <span class="badge badge-dark" style="font-size:0.8rem;"><?= date("d F Y",strtotime($data["tanggal"])); ?></span>                </div>
              <br>
              <center>
                <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=http://himki.epizy.com/cek-pesanan.php?kode_unik=<?= $data['kode_unik']; ?>" title="Link to Google.com" />
                <p>Kode Tiket : <b><i><?= $data["kode_unik"]; ?></i></b></p>
              </center>
              <div style="border-bottom:2px dotted black;"></div>
            <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
    
   
  



    <!-- Modal -->

    <!-- start footer Area -->
    <?php include 'footer.php'; ?>
    <!-- End footer Area -->

    <?php include 'plugin.php'; ?>


</body>

</html>