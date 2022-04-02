<?php
require __DIR__."/config.php";
require __DIR__."/function.php";
$id = bin2hex(random_bytes(20));
$userBrowser = get_browser_name($_SERVER["HTTP_USER_AGENT"]);
/* script api */
if(isset($_GET["api"])){
  $q = $_GET["api"];
  if($q == "acak"){
    $arr = [];
    $arr["status"] = 200;
    $arr["random_image"] = getRandomImg();
    $arr["author"] = $authorName;
    /* $arr["folder"] = "img"; */
    header('Content-Type: application/json');
    echo api_json_encode($arr,JSON_UNESCAPED_SLASHES);
    die();
  }
}

if(isset($_GET["acak"])){
    $arr = [];
    $arr["status"] = 200;
    $arr ["parameter"] = $_GET["acak"];
    for ($i = 0; $i < $_GET["acak"]; $i++) {
       $arr["result"][$i] = getRandomImg();
    }
    $arr["author"] = $authorName;
    /* $arr["folder"] = "img"; */
    header('Content-Type: application/json');
    echo api_json_encode($arr,JSON_UNESCAPED_SLASHES);
    die();
  }
if(isset($_GET["gambar"])){
  $param = $_GET["gambar"];
  //$imgs = array_diff(scandir("./img"), array('.', '..'));
  global $files;
  $imgs = $files;
  if($param == null || $param >= count($imgs) - 1 || $param == 0){
    header("HTTP/1.0 404 Not Found");
    readfile("404.php");
    die();
  }
  $img = $imgs[$_GET["gambar"] + 1];
  /*
  header("Location: ./admin-post/$img");
  */
  $path = "./admin-post/$img";
  $name = "Postingan_ke-".$_GET["gambar"];
  // ngasih tau ke browser klo ini file gambar
  header('Content-Type: image/png');
  // ngasih tau ke browser nama gambar nya apa
// buat suruu browser biar download file
  //header("Content-Disposition:  attachment; filename=\"" . basename($img) . "\";" );
  header("Content-Transfer-Encoding:  binary");
  header('Content-Disposition: attachment; filename="'.basename($path).'"');
  // merender gambar
  readfile("$path");
  die();
}
if(isset($_GET["alldata"])){
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json;charset=utf-8');
  if($_GET["alldata"] == "true"){
    $arr = [];
    $arr["status"] = 200;
    $arr["today_date"] = date("D, d-M-Y h:i:s A");
    $arr["visited"] = $total_visited;
    $arr["total_likes"] = $like;
    $arr["total_dislike"] = $dislike;
    $arr["total_comment"] = $total_comment;
    $a = 0;
    for($i = 2; $i < count($files); $i++){
      $arr["image-post"][$a] = $protocol.$host_url."/admin-post/".$files[$i];
      $a++;
    }
    $arr["author"] = $authorName;
    print(api_json_encode($arr,JSON_UNESCAPED_SLASHES));
    die();
  }else if($_GET["alldata"] == "false"){
    $arr = [];
    $arr["status"] = 200;
    $arr["today_date"] = date("D, d-M-Y h:i:s A");
    $arr["total_likes"] = $like;
    $arr["total_dislike"] = $dislike;
    $arr["total_comment"] = $total_comment;
    $arr["author"] = $authorName;
    print(api_json_encode($arr,JSON_UNESCAPED_SLASHES));
    die();
  }else{
    echo "<h1 style='text-align:center;'>require parameter <a href='?alldata=true'>true</a> or <a href='?alldata=false'>false</a> !</h1>";
  }
  die();
}
/* main script */
 if(isset($_GET["halaman"])){
  if($_GET["halaman"] === "tentang"){
  //header("Location:?halaman=tentang&peramban=$userBrowser&bahasa=indonesia");
  readfile("about-id.html");
  Log_Visited(".");
  die();
}
}
if(isset($_GET["url"])){
  $valueUrl = $_GET["url"];
  sleep(2);
  $page =  "<!DOCTYPE html><html><head><title>Redirecting to $valueUrl</title><link rel='shortcut icon' href='$icon'></head><body><p>Anda akan di alihkan ke url <b>$valueUrl</b><br/>Jika tidak dapat dialihkan silahkan click <a href='$valueUrl'>disini</a></p><script>let url='$valueUrl';setTimeout(()=>{window.location.href=url},2000)</script></body></html>";
  echo $page;
  die();
}
if(!isset($_GET["halaman"])){
  header("Location:?halaman=utama&peramban=$userBrowser&bahasa=indonesia");
  die();
}else if($_GET["halaman"] !== "utama"){
  header("Location:?halaman=utama&peramban=$userBrowser&bahasa=indonesia");
}
if(isset($_GET["peramban"])){
  if($_GET["peramban"] !== $userBrowser){
    header("Location:?halaman=utama&peramban=$userBrowser&bahasa=indonesia");
  }
}
if(!isset($_GET["peramban"])){
  header("Location:?halaman=utama&peramban=$userBrowser&bahasa=indonesia");
}
if(!isset($_GET["bahasa"])){
  header("Location:?halaman=utama&peramban=$userBrowser&bahasa=indonesia");
}

/* session */
//session_start();
save_path();
//echo $_SESSION["path_save"];
if(!isset($_SESSION["hasBeenLike"])){
  $_SESSION["hasBeenLike"] = false;
}
/* if site visited */
if(isset($_GET)){
  $visited = $db_rating["visited"];
  $db_rating["visited"] = $visited + 1;
  $result = my_json_encode($db_rating);
  //var_dump($result);
  file_put_contents("like-dislike.json",$result);
}
if(isset($_POST["like"])){
  $likeData = $like + 1;
  //intval($likeData);
  //$dislikeData = $_POST["dislikeData"];
  $db_rating["like"] = $likeData;
  $result = my_json_encode($db_rating);
  //var_dump($result);
  $_SESSION["hasBeenLike"] = true;
  file_put_contents("like-dislike.json",$result);
}
if(isset($_POST["dislike"])){
  //$likeData = $_POST
  $dislikeData = $dislike + 1;
  //intval($dislikeData);
  $db_rating["dislike"] = $dislikeData;
  $result = my_json_encode($db_rating);
  $_SESSION["hasBeenLike"] = true;
  file_put_contents("like-dislike.json",$result);
}
/*
$_POST["sendComment"] = "submit";
$_POST["username"] = "spam";
$_POST["comment"] = "spam";
*/
if(isset($_POST["sendComment"])){
  $commentData = htmlspecialchars($_POST["comment"]);
  $commentUsername = $_POST["username"];
  $index = $db_comment["total_comment"];
  if($commentUsername == "" || $commentUsername == null){
    $commentUsername = "Anonymous";
  }
  $db_comment["total_comment"] = $index + 1;
  $db_comment["username_comment"][$index] = $commentUsername;
  $db_comment["comment"][$index] = formating($commentData);
  $db_comment["dateComment"][$index] = date("D, d M Y h:i:s A");
  $result = my_json_encode($db_comment);
  file_put_contents("comment.json",$result);
}
$likes = $db_rating["like"];
$dislikes = $db_rating["dislike"];
$posts = count($files);
$counter_posts = 0;
if ($posts > 0) {
  foreach ($paths_upload as $path){
  if ($path == "") {
    $counter_posts++;
  }
 }
 $posts - $counter_posts;
}
$attrDataLike = $likes;
$attrDataDislike = $dislikes;
if($likes >= 1000000000){
  $likes = floor($likes/1000000000)." B";
}else if($likes >= 1000000){
  $likes = floor($likes/1000000)." M";
}else if($likes >= 1000){
  $likes = floor($likes/1000)." K";
}

if($dislikes >= 1000000000){
  $dislikes = floor($dislikes/1000000000)." B";
}else if($dislikes >= 1000000){
  $dislikes = floor($dislikes/1000000)." M";
}else if($dislikes >= 1000){
  $dislikes = floor($dislikes/1000)." K";
}
log_visited(".");
?>
<!DOCTYPE html>
<html lang="<?= $userLang; ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Profile || By : <?= $authorName; ?>">
  <title>Profil | <?= $authorName; ?></title>
  <!-- icon -->
  <link rel="shortcut icon" href="<?= "$icon"; ?>" type="image/x-icon" />
  <!-- boostrap -->
  <?php include "./framework-handle.php";?>
  
  <link rel="stylesheet" href="style.css">
</head>

<body id="body">
  <div class="container">

    <div class="row">
      <div class="col">
        <nav class="">
          <img class="rounded-circle mb-2 border bordered" src="<?= $icon; ?>" alt="" />
           <a href="/login/"><div class="mx-1 my-1 py-2 px-1 btn-list-click">login</div></a>
          <div class="mx-1 my-1 py-2 px-1 btn-list-click">Pengaturan</div>
          <div class="btn-list mx-1 mh-0 d-none">
         <a href="#">
           <li class="list-menu clearfix my-1 mx-1">tema gelap 
           <label for="theme_switcher" class="switch">
           <input type="checkbox" id="theme_switcher">
           <span class="slider round"></span>
           </label>
           </li>
           </a>
         <a href="#">
           <li class="list-menu mx-1 my-1">ketikan teks
           <label class="switch" for="typed_switcher">
           <input type="checkbox" id="typed_switcher">
           <span class="slider round"></span>
           </label>
           </li>
           </a>
         <a href="#">
           <li class="list-menu mx-1 my-1">reCaptcha
           <label class="switch" for="captcha_switcher">
           <input type="checkbox" id="captcha_switcher">
           <span class="slider round"></span>
           </label>
           </li>
           </a>
         <a href="#"><li class="list-menu mx-1 my-1">Readmore ...
         <label class="switch" for="readmore_switcher">
           <input type="checkbox" id="readmore_switcher">
           <span class="slider round"></span>
           </label>
           </li>
           </a>
         </div>
         <div class="mx-1 my-1 py-2 px-1 btn-list-click">fitur
            </div>
          <div class="btn-list mx-1 mh-0 d-none">
         <a href="/feature/upload/"><li class="list-menu mx-1"><i class="bi bi-upload"></i>Upload gambar</li></a>
         <a href="/feature/galery/"><li class="list-menu mx-1"><i class="bi bi-images"></i>galery bersama</li></a>
         <a href="#"><li class="list-menu mx-1">comming soon</li></a>
         <a href="#"><li class="list-menu mx-1">comming soon</li></a>
         </div>
        </nav>
        <div class="nav-top clearfix">
          <p class="dropdown-toggle" onclick="navShow()"><?= $authorName; ?></p>
          <form action="" method="post" accept-charset="utf-8">
          <button class="btn-kotak <?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "btn-muted";
            }
          }?>" type="
          <?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "button";
            }else{
              echo "submit";
            }
          }?>" ><span onclick=" <?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "";
            }else{
              echo "addDislike()";
            }
          }?>" id="dislikebtn"><?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "❌";
            }else{
              echo "👎";
            }
          }?></span></button>
                    <button class="btn-kotak <?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "btn-muted";
            }
          }?>" type="<?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "button";
            }else{
              echo "submit";
            }
          }?>"><span onclick="<?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "";
            }else{
              echo "addLike()";
            }
          }?>" id="likebtn"> <?php
          if(isset($_SESSION["hasBeenLike"])){
            if($_SESSION["hasBeenLike"]){
              echo "❌";
            }else{
              echo "❤️";
            }
            }?>
            </span>
            </button>
          <input class="" type="hidden" name="" id="like" value="" />
          <input class="" type="hidden" name="" id="dislike" value="" />
          </form>
        </div>
        <div class="clearfix c-info-user">
          <img class="hero border bordered rounded-circle float-start" src="<?= "$icon";?>" alt="" />
          <div class="c-information float-end">
            <div class="mx-auto">
              <p style="font-weight:bold;" id="countPosts"><?= $posts;?></p>
              <p>Postingan</p>
            </div>
            <div class="mx-auto">
              <p style="font-weight:bold;" id="countLikes" data-real="<?= $attrDataLike; ?>" data-no-real="<?= $likes; ?>"><?= $likes;?></p>
              <p>Suka</p>
            </div>
            <div class="mx-auto">
              <p style="font-weight:bold;" id="countDislikes" data-real="<?= $attrDataDislike; ?>" data-no-real="<?= $dislikes; ?>"><?= $dislikes;?></p>
              <p>Tidak suka</p>
            </div>
          </div>
        </div>
        <div class="c-info mt-3">
          <p class="nickname">Panggil Aku <?= $authorName; ?></p>
          <p class="bio">Ini adalah web galeri saya, silahkan dilihat-lihat</p>
          <p><small class="text-muted">Terakhir diperbarui pada <b id="lastupdate"><?= $lastUpdate;?></b></small></p>
          <p><small class="text-muted">versi pengembangan : <b><?= $version; ?></b></small></p>
          <p class="mt-1 text-muted"><i>~ Total Dikunjungi <b class="visit"><?= $total_visited; ?></b></i></p>
        </div>
      </div>
      <!-- Tab postingan -->
      <div class="w-100 mt-3 mb-1">
        <div id="btn1" onclick="openTab('btn1','tab1')" class="tab tab-active">postingan</div>
        <div id="btn2" onclick="openTab('btn2','tab2')" class="tab">komentar</div>
      </div>
    </div>
    <!-- content -->
    <div class="c-postingan">
    <div class="postingan w-100 main-post mb-2" id="tab1">
      <?php if($posts == 0):?>
      <style>
      .main-post {
        background-image: url('../no-post.png');
        background-position: center;
        background-size: 100px;
        background-repeat: no-repeat;
      }
      </style>
      <?php endif; ?>
     <?php foreach ($files as $i => $file):?>
      <?php if($paths_upload[$i] !== ""): ?>
       <?php if($extensions_upload[$i] != "mp4"):?>
        <a href='/p/<?= "?post=".$i + 1 ;?>' title='postingan ke <?= $i + 1;?>'>
          <div class='post-value' style='background-image:url("<?= $paths_upload[$i]; ?>");'></div>
          </a>
        <?php else: ?>
        <a href='/p/<?= "?post=".$i + 1 ;?>' title='postingan ke <?= $i + 1;?>'>
          <video src="<?= $paths_upload[$i];?>" class="post-video" preload="none" autoplay muted></video>
        </a>
       <?php endif; ?>
      <?php endif; ?>
     <?php endforeach;?>
     
     <?php if($posts != 0):?>
      <div class="spin">
        <div class="spinner"></div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  
  <div class="postingan mb-2" id="tab2">
    <h5 style="font-size:15px;font-weight:normal;" class="text-center" >komentar <b id="total-comment" total-comment="<?= $total_comment; ?>"><?=$total_comment;?></b><h5>
     <?php if ($total_comment !== 0):?>
     <div id="super-container-comment"></div>
    <?php endif; ?>
    <p style="font-size:10px;;" class="text-right mx-1 mr-1 text-muted"><b>#</b> jika komentar terbaru tidak tampil, silahkan <a href="" class="fw-bold text-info">refresh</a> halaman terlebih dahulu</p>
    <p style="font-size:10px;;" class="text-right mx-1 mr-1 text-muted"><b>#</b> jika anda mengosongkan username saat memposting komentar maka yang di tampilkan adalah alamat IP anda <a class="fw-bold text-info" href="https://google.com/search?q=alamat+ip+saya">[<?= $ip_user; ?>]</a></p>
    <p style="font-size:13px;font-weight:normal;" class="text-center mt-2" id="btnShowComment" onclick="showFormComment()">tulis komentarmu ↓</p>
    <form class="mt-1 clearfix form-control" action="" method="post" accept-charset="utf-8">
     <label class="input-group" for="username">nama kamu :</label><input class="form-control my-2" type="text" name="username" id="username" placeholder="username .." value="<?= $ip_user; ?>" ip-user="<?= $ip_user; ?>" />
     <label class="input-group" for="comment">komentarmu :</label>
     <textarea placeholder="comment .." required class="form-control my-2" name="comment" id="comment" value=""></textarea>
     <small class="aboutFormat"><i>menggunakan formating text.</i> <a id="btnAboutFormat">apa ini ?</a></small>
     <label class="input-group" for="captha"><input class="my-2 form-control float-start" type="text" id="capthaCode" style="width:80%;" readonly value="" /><input style="width:20%;" class="form-control float-end text-center my-2" type="text" name="" id="cd" value="" readonly="" /></label>
     <label for="captha" class="">captcha :</label>
     <input class="my-2 form-control" type="text" name="captha" id="captha" value="" />
     <input class="btn-comment mb-5 btn btn-outline-info" id="sendComment" name="sendComment" type="submit" value="send">
   </form>
  </div>
  <!-- footer -->
    <div class="footer mx-auto">
    <a href="../">
    <div class="footer-tab">
      <p><i class="bi bi-house"></i></p>
    </div>
    </a>
        <a href="./feature/galery/">
    <div class="footer-tab">
      <p><i class="bi bi-images"></i></p>
    </div>
    </a>
        <a href="./feature/upload/">
    <div class="footer-tab">
      <p><i class="bi bi-upload"></i></p>
    </div>
    </a>
        <a href="?halaman=tentang">
        <div class="footer-tab">
          <p><i class="bi bi-three-dots"></i></p>
        </div>
    </a>
        <a href="<?= "./".$userLang.".php";?>">
    <div class="footer-tab active">
      <p><i class="bi bi-person"></i></p>
    </div>
    </a>
  </div>
  </div>
  <!-- javascript -->
  <script type="text/javascript" charset="utf-8">
    var comments = <?= json_encode($db_comment); ?>;
    var total_komen = <?= $total_comment; ?>;
    for (let i = 0; i < <?= count($db_comment["comment"]); ?>; i++) {
    let comments_ = comments["comment"];
    let date_ = comments["dateComment"];
    let username_ = comments["username_comment"];
    let total_comment = comments["total_comment"];
    let date = date_[i];
    let username = username_[i];
    let comment = comments_[i];
    let time_comment = new Date(date).getTime();
    let time_now = new Date().getTime();
    
    let selisihWaktu = time_now - time_comment;
    var d = Math.round(selisihWaktu / (1000 * 60 * 60 * 24));
    var h = Math.floor((selisihWaktu % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var m = Math.floor((selisihWaktu % (1000 * 60 * 60)) / (1000 * 60));
    var s = Math.floor((selisihWaktu % (1000 * 60)) / 1000);
    var msg;
      /* beberapa detik yg lalu */
    if(comment != ""){
      if(s == 0 && m < 1 && d < 1){
        msg = `baru saja`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      }else if(s < 60 && m < 1 && d < 1){
        msg = `${s} detik lalu`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      } else if(m < 60 && h < 1 && d < 1) {
        msg = `${m} menit yang lalu`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      } else if(h < 60 && d < 1){
        msg = `${h} jam yang lalu`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      } else if(d >= 1 && d < 7){
        msg = `${d} hari yang lalu`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      } else if(d >= 7 && d < 30){
        d = Math.floor(d / 7);
        msg = `${d} minggu yang lalu`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      } else if(d >= 30 && d < 365){
        d = Math.floor(d / 30);
        msg = `${d} bulan yang lalu`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      } else if(d >= 365 || d >= 366){
        d = Math.round(d / 365.25);
        msg = `${d} tahun yang lalu`;
        $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} | ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
      }
    }
  }
    
  </script>
  <script src="main-no-trim.js?ver=<?= $version; ?>"></script>
  <script src="/js/typed.min.js?ver=<?= $version; ?>" type="text/javascript" charset="utf-8"></script>
  <script src="lazyload.js?ver=<?= $version; ?>" type="text/javascript" charset="utf-8"></script>
  <script src="js/jquery.lazyscrollloading-src.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
    /* typed */
(function($) {
      'use strict';
      $(document).ready(function() {
        $(".nickname").css("display","inline-block");
        $(".nickname").toggleClass("blink");
        $("#typed_switcher").attr("checked",true);
        let pathname = window.location.pathname;
        let text;
        if(pathname == "/id.php"){
          text = ['Hi saya <?= $authorName; ?>.', 'Saya Seorang Developer.','panggil aku <?= $authorName; ?>']
        }else{
          text = ["Hi I'm <?= $authorName;?>.","I'm a developer.","call me <?= $authorName; ?>."]
        }
        $(function() {
          $(".nickname").typed({
            strings: text,
            typeSpeed: 1,
            backDelay: 2000,
            loop: true
          });
        });
      })
    }(jQuery))
  </script>
  <script type="text/javascript" src="/clear-wm.js"></script>
  <!-- eruda console 
  <script src="//cdn.jsdelivr.net/npm/eruda"></script>
  <script>eruda.init();</script>
  -->
</body>
</html>