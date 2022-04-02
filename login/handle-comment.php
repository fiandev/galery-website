<?php
date_default_timezone_set('Asia/Jakarta');
$icon = "../static/icon/?newest=active";
$userLangFromServer = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$userLang = "id";
$prefix = "gambar";
$title = "Galeri Ku";
$aboutPrefix = "tentang";
$getPrefix = "halaman=";
if($userLangFromServer != "id"){
  $userLang = "en";
  $prefix = "image";
  $title = "My Galery";
  $aboutPrefix = "about";
  $getPrefix = "";
}

//$db_comment = json_decode(file_get_contents("../comment.json"),true);
require "../config.php";
$json_adminDb = file_get_contents("./db_admin.json");
$adminDb = json_decode($json_adminDb,true);
$muchData = count($db_comment["comment"]);
function whoAreYou(){
  readfile("./whoAreYou.php");
}
function giftAlert($pesan){
    echo "<div style='transform:translateY(0%);transition:1s;' class='alert text-center fixed-top bg-success text-light'>$pesan</div>";
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(-200%)");clear()},1000)</script>';
}
/*
session_start();
if(!isset($_SESSION["expired"])){
  whoAreYou();
  die();
}
*/
session_start();
if(isset($_GET["commit"])){
  $usercomment = $db_comment["username_comment"];
  $tglnya = $db_comment["dateComment"];
  $total_comment = $db_comment["total_comment"];
    if(isset($_GET["delete_comment"]) && isset($_SESSION["isAdmin"])){
      if($total_comment == 0){
        echo "tidak ada komentar yang bisa dihapus lagi!";
      }
      $indexComment = $_GET["delete_comment"];
      $db_comment["username_comment"][$indexComment] = "unknown";
      $db_comment["comment"][$indexComment] = "";
      $db_comment["dateComment"][$indexComment] = date("D, d M Y h:i:s A");
      //print_r($db_comment);
     // print_r($data);
      file_put_contents("../comment.json",json_encode($db_comment,JSON_PRETTY_PRINT));
      echo "<script>window.location.href='../login/handle-comment.php?commit=read'</script>";
    }else if($_GET["commit"] == "deleteAll" && isset($_SESSION["isAdmin"])){
      if($total_comment == 0){
        echo "tidak ada komentar yang bisa dihapus lagi!";
      }
      for ($indexComment = 0; $indexComment < count($db_comment["comment"]); $indexComment++) {
      $db_comment["username_comment"][$indexComment] = "unknown";
      $db_comment["comment"][$indexComment] = "";
      $db_comment["dateComment"][$indexComment] = date("D, d M Y h:i:s A");
      }
      //print_r($db_comment);
     // print_r($data);
      file_put_contents("../comment.json",json_encode($db_comment,JSON_PRETTY_PRINT));
      header("Location: ?commit=read");
      die();
    }else if(!isset($_SESSION["isAdmin"])){
      whoAreYou();
      die();
    }
}
?>
<?php if($_GET["commit"] == "read" && isset($_SESSION["isAdmin"])): ?>
<?php
$adminDb["data_comment"] = $muchData;
$res = json_encode($adminDb,JSON_PRETTY_PRINT);
file_put_contents("./db_admin.json",$res);
giftAlert("Hi ".$db_config["authorName"]." !");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>data comments</title>
     <!-- boostrap -->
    <link rel="shortcut icon" href="<?= $icon; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../framework/bootstrap.min.css?<?= filemtime("../framework/bootstrap.min.css");?>" type="text/css" media="all" />
    <script src="../framework/bootstrap.bundle.min.js?<?= filemtime("../framework/bootstrap.bundle.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <script src="../framework/jquery-3.6.0.min.js?<?= filemtime("../framework/jquery-3.6.0.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <style type="text/css" media="all">
    table {
      width: 100%;
    }
      #comment_section {
        width: 120px;
        overflow-x: scroll;
      }
    </style>
  </head>
  <body>
    <?php $data = $db_comment["comment"]; ?>
    <?php if(count($data) != 0):?>
    <div class="container mx-auto clearfix">
    <h1 class="text-center bg-primary py-1">Data komentar!</h1>
    <table class="table border bordered">
  <thead class="bg-info">
    <tr>
      <th scope="col">username</th>
      <th scope="col">tanggal</th>
      <th scope="col" id="comment_section">comment</th>
      <th scope="col">fungsi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($data as $i => $dt):?>
    <?php if($dt != "" || $dt != null):?>
    <?php
    ?>
    <tr>
      <th scope="row"><?= $db_comment["username_comment"][$i];?></th>
      <th scope="row" class="time"><?= $db_comment["dateComment"][$i];?></th>
      <td><?= $dt; ?></td>
      <td><a class="btn btn-sm btn-danger" href="?commit=read&delete_comment=<?= $i;?>">delete</a></td>
    </tr>
    <?php endif; ?>
    <?php endforeach;?>
  </tbody>
</table>
<a class="btn btn-success" href="../<?= $userLang;?>.php">back to <?= $userLang; ?>.php</a>
<a class="btn btn-danger" href="?commit=deleteAll">delete all</a>
<a class="btn btn-primary" href="./">back</a>
</div>
<?php else: ?>
<h1 class="text-center"> empty </h1>
<?php endif; ?>
     <script type="text/javascript" charset="utf-8">
       let elems = document.querySelectorAll(".time");
       for (let i = 0; i < elems.length; i++) {
         let self = elems[i]
         let date = elems[i].innerHTML;
         let time_comment = new Date(date).getTime();
        let time_now = new Date().getTime();
        let selisihWaktu = time_now - time_comment;
        var d = Math.round(selisihWaktu / (1000 * 60 * 60 * 24));
        var h = Math.floor((selisihWaktu % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var m = Math.floor((selisihWaktu % (1000 * 60 * 60)) / (1000 * 60));
        var s = Math.floor((selisihWaktu % (1000 * 60)) / 1000);
        let msg;
        if (s == 0 && m < 1 && d < 1) {
          msg = `baru saja`;
        } else if(s < 60 && m < 1 && d < 1){
          msg = `${s} detik lalu`;
        } else if(m < 60 && h < 1 && d < 1){
          msg = `${m} menit yang lalu`;
        } else if(h < 60 && d < 1){
          msg = `${h} jam yang lalu`;
        } else if(d > 7 && d < 30){
          d = Math.floor(d / 7);
          msg = `${d} minggu yang lalu`;
        } else if(d >= 30 && d < 365){
          d = Math.floor(d / 30);
          msg = `${d} bulan yang lalu`;
        } else if(d >= 365 || d >= 366){
          d = Math.round(d / 365.25);
          msg = `${d} tahun yang lalu`;
        }
        self.innerHTML=msg;
       }
     </script>
     <script type="text/javascript" src="../clear-wm.js"></script>
  </body>
</html>

<?php else: ?>
<?php whoAreYou(); ?>
<?php endif;?>