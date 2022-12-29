function error() {
	swal({
      title: "Akses Ditolak",
      text: "Silahkan Login Terlebih Dahulu",
      icon: "warning"
    });
}
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})