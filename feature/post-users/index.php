<?php
require "../../function.php";
log_visited("../..");
if(!isset($_GET["post"]) || $_GET["post"] == "0" || $_GET["post"] == null){
  readfile("../../404.php");
  die();
}
$i = $_GET["post"] - 1;
$icon = "../../static/icon/?newest=newest";
$j1 = json_decode(file_get_contents("../upload/DB-user.json"), true);
$totalPost = count($j1["Date_Upload"]);
if($_GET["post"] > $totalPost || $j1["url"][$i] == "" ){
  readfile("../../404.php");
  die();
}
$author = $j1["username"][$i];
$date = $j1["Date_Upload"][$i];
$title = $j1["title_post"][$i];
$desc = $j1["Description_Upload"][$i];
$url = $j1["url"][$i];
$extension = $j1["extension"][$i];

$userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if($date == ""){
  $date = "???";
}
if($title == ""){
  $title = "???";
}
if($desc == ""){
  $desc = "No Description";
}
if($_GET["post"] == "1"){
  $entah = "st";
}else if($_GET["post"] == "2"){
  $entah = "nd";
}else{
  $entah = "th";
}
$prefix = "gambar";
if($userLang != "id"){
  $userLang = "en";
  $prefix = "image";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>(<?= $title; ?>) <?= $_GET["post"]; ?>'<?= $entah; ?> Post By <?= $author;?></title>
     <!-- icon -->
  <link rel="shortcut icon" href="<?= $icon; ?>" type="image/x-icon" />
  <!-- boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../../framework/bootstrap.min.css?<?= filemtime("../../framework/bootstrap.min.css");?>" type="text/css" media="all" />
    <script src="../../framework/bootstrap.bundle.min.js?<?= filemtime("../../framework/bootstrap.bundle.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="../../p/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
    <script src="../../framework/jquery-3.6.0.min.js?<?= filemtime("../../framework/jquery-3.6.0.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <script src="../../framework/js.cookie.min.js?<?= filemtime("../../framework/js.cookie.min.js");?>" type="text/javascript" charset="utf-8"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="container-post">
          <div class="head clearfix mt-3 mx-2 px-2">
            <!-- -->
            <img class="float-start rounded-circle d-inline" src="<?= $icon; ?>" alt="Default Image" />
            <!-- -->
            <p class="d-inline mx-1 fw-bold"><?= $author;?></p>
            <p class="float-end d-inline-block"><i class="bi-three-dots" style="line-height:100%;font-size:18px;"></i></p>
          </div>
          <div class="info mx-2 mt-1">
            <?php if($extension != "mp4"):?>
            <img id="post" class="img-fluid img-center post-img" src="<?= $url; ?>" />
            <?php else: ?>
            <video title="(<?= $title; ?>) <?= $_GET["post"]; ?>'<?= $entah; ?> Post By <?= $author;?>" src="<?= $url;?>" class="post-video" autoplay="false" onclick="play_video(this)"></video>
            <?php endif; ?>
            <div class="clearfix bg-light" style="font-size:25px;">
              <div class="float-start py-1 px-1">
                <i class="bi-heart"></i>
                <i class="bi-chat mx-2"></i>
                <i class="bi-share"></i>
              </div>
              <div class="float-end py-1 px-1">
                <i class="bi-bookmarks"></i>
              </div>
            </div>
            <p class="desc-post my-1"><b><?=$author;?> </b><?= $desc; ?></p>
            <p class="text-muted d-inline-block" style="font-size:12px;">on <?= $date; ?></p>
            <a class="btn d-block btn-success" href="../galery/"><r>#!</r>Tap here to back</a>
          </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" charset="utf-8">
       /* let width = $("#post").width();
        $(".post-img").css("height",`${width}`);
        */
        var IsDark = Cookies.get("theme");
        if(IsDark == "dark"){
          $("*").toggleClass("bg-dark");
          $("*").toggleClass("text-light");
        }
        $(document).ready(function(){      
   });
    </script>
    <script type="text/javascript" src="../../clear-wm.js"></script>
  </body>
</html>