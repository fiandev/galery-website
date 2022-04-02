<?php
require "../function.php";
require "../config.php";
log_visited("..");
if(isset($_POST["addLikePostAdmin"])){
  if ($_POST["addLikePostAdmin"] == "true") {
    $data = json_decode(file_get_contents("".$_POST["dir_name"]."/data.json"), true);
    $data["like"] = $data["like"] + 1;
    file_put_contents("".$_POST["dir_name"]."/data.json",my_json_encode($data));
  } else {
    $data = json_decode(file_get_contents("".$_POST["dir_name"]."/data.json"), true);
    $like = $data["like"];
    $data["like"] = $data["like"] - 1;
    file_put_contents("".$_POST["dir_name"]."/data.json",my_json_encode($data));
  }
}

if (isset($_POST["sendCommentPost"])) {
  $dir = $_POST["dir"];
  $res = json_decode(file_get_contents("".$dir."/data.json"),true);
  $i = count($res["comments"]);
  $urlApi = "https://flagcdn.com";
  $sizeFlag = "/16x12/";
  $imageFlag = $userLangFromServer.".png";
  $res["flags"][$i] = $urlApi.$sizeFlag.$imageFlag;
  $res["comments"][$i] = htmlspecialchars($_POST["comment"]);
  $res["ip"][$i] = $ip_user;
  file_put_contents("".$dir."/data.json",my_json_encode($res));
}
if(!isset($_GET["post"]) || $_GET["post"] == "0" || $_GET["post"] == null){
  readfile("../404.php");
  die();
}
$i = $_GET["post"] - 1;
$icon = "../static/icon/?newest=newest";
$j1 = json_decode(file_get_contents("../DB.json"), true);
$db_config = json_decode(file_get_contents("../config.json"), true);
$author = $db_config["authorName"];
$totalPost = count($j1["Date_Upload"]);
if($_GET["post"] > $totalPost){
  readfile("../404.php");
  die();
}
$date = $j1["Date_Upload"][$i];
$title = $j1["title_post"][$i];
$desc = $j1["Description_Upload"][$i];
$path = $j1["path"][$i];
$extension = $j1["extension"][$i];
$userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
if ($path == "") {
  readfile("../hasbeen-remove.php");
  die();
}
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
session_start();
if (isset($_SESSION["path_save"])) {
  $pathSaved = $_SESSION["path_save"];
}
$dir_name = "../".$j1["dir_name"][$i];
$dataThisPost = json_decode(file_get_contents($dir_name."/data.json"),true);
$like = $dataThisPost["like"];
$dislike = $dataThisPost["dislike"];
$idSection = uniqid("section_");


?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>(<?= $title; ?>) <?= $_GET["post"]; ?>'<?= $entah; ?> Post By <?= $author;?></title>
     <!-- icon -->
  <link rel="shortcut icon" href="<?= "$icon"; ?>" type="image/x-icon" />
  <!-- boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../framework/bootstrap.min.css?<?= filemtime("../framework/bootstrap.min.css");?>" type="text/css" media="all" />
    <script src="../framework/bootstrap.bundle.min.js?<?= filemtime("../framework/bootstrap.bundle.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../style.css" type="text/css" media="all" />
    <script src="../framework/jquery-3.6.0.min.js?<?= filemtime("../framework/jquery-3.6.0.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <script src="../framework/js.cookie.min.js?<?= filemtime("../framework/js.cookie.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <style type="text/css" media="all">
        
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col" id="content">
          <div class="container-post">
          <div class="head clearfix mt-2 mx-2 px-2">
            <img class="float-start rounded-circle d-inline" src="<?= $icon; ?>" alt="" />
            <p class="d-inline mx-2 fw-bold"><?= $author;?></p>
            <p class="float-end d-inline-block"><i class="bi-three-dots" style="line-height:100%;font-size:18px;"></i></p>
          </div>
          <div class="info mx-2 mt-1">
            <?php if($extension != "mp4"):?>
            <img id="post" class="img-fluid img-center post-img" src="<?= $path; ?>" alt="(<?= $title; ?>) <?= $_GET["post"]; ?>'<?= $entah; ?> Post By <?= $author;?>" />
            <?php else: ?>
            <video title="(<?= $title; ?>) <?= $_GET["post"]; ?>'<?= $entah; ?> Post By <?= $author;?>" src="<?= $path;?>" class="post-video" autoplay="false" onclick="play_video(this)"></video>
            <?php endif; ?>
            <div class="clearfix bg-light" style="font-size:25px;">
              <div class="float-start py-1 px-1">
                <i class="bi-heart" onclick="likeAdminPost(this,'<?= $dir_name; ?>',<?= $i; ?>)"></i>
                <i class="bi-chat mx-2" onclick="showCommentField('<?= $dir_name;?>','<?= $idSection; ?>')"></i>
                <i class="bi-share" onclick="share_event('<?= $protocol.$domain;?>/p/?post=<?= $i + 1 ;?>')"></i>
              </div>
              <div class="float-end py-1 px-1">
                <i class="bi-bookmarks"></i>
              </div>
            </div>
            <p class="desc-post my-1">like <b id="countLike_<?= $i; ?>"><?=$like;?></b></p>
            <p class="desc-post my-1"><b><?=$author;?> </b><?= $desc; ?></p>
            <p class="text-muted d-inline-block" style="font-size:12px;">on <?= $date; ?></p>
            <a class="text-auto d-block btn btn-primary" id="exitBtn"><r>#! </r>Tap here to back</a>
          </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" charset="utf-8">
     $("#exitBtn").on("click",function(){
        <?php if(isset($_SESSION["path_save"])):?>
        window.location.href="<?= $pathSaved; ?>";
        <?php else:?>
        window.location.href="../";
        
        <?php endif;?>
      })
       /* let width = $("#post").width();
        $(".post-img").css("height",`${width}`);
        */
        function play_video(argument){
          let elem = argument;
          elem.play();
          elem.loop = true;
          elem.style.filter="blur(0)";
          $(elem).attr("onclick","");
          setTimeout(() => {
          $(elem).attr("controls", true);
          }, 1000);
        }
        var IsDark = Cookies.get("theme");
        if(IsDark == "dark"){
          $("*").toggleClass("bg-dark");
          $("*").toggleClass("text-light");
        }
        
    </script>
    <script>
      const userLang = "<?= $userLang; ?>";
      const authorName = "<?= $author; ?>";
    </script>
    <script src="../event-btn.js"></script>
    <script src="../clear-wm.js"></script>
  </body>
</html>