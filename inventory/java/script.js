$(document).ready(function () {
  $(".cetak").click(function () {
    $(".laporan").toggle();
  });
});

$(document).ready(function () {
  $(".profil").click(function () {
    $(".banner1").toggle();
  });
});

let tambah = document.querySelector("#tambah");

tambah.addEventListener("click", () => {
  $(".banner").toggle();
});
