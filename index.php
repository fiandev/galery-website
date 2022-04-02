<?php
date_default_timezone_set('Asia/Jakarta');
require __DIR__."/config.php";
require __DIR__."/function.php";
log_visited();
save_path();
if (!isset($_SESSION["hasBeenVisit"])) {
  header("location: /verify/");
  die();
}
$userLangFromServer = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)  ;
$userLang = "id";
$prefix = "gambar";
$title_page = "Beranda";
$aboutPrefix = "tentang";
$getPrefix = "halaman=";
if($userLangFromServer != "id"){
  $userLang = $userLangFromServer;
  $prefix = "image";
  $title_page = "Home";
  $aboutPrefix = "about";
  $getPrefix = "";
}
$icon = "../static/icon/?newest=newest";
$db_upload = json_decode(file_get_contents("DB.json"), true);
$db_config = json_decode(file_get_contents("config.json"), true);
$author = $db_config["authorName"];
$files = array_diff(scandir("./admin-post"), array("index.php","..","."));
$files = array_reverse($files);
$posts = count($files);
if(isset($_GET["page"]) && $_GET["page"] === "login"){
  header("Location: ./login/");
    die();
}
$extensions = array_reverse($db_upload["extension"]);
$dates = array_reverse($db_upload["Date_Upload"]);
$titles = array_reverse($db_upload["title_post"]);
$descs = array_reverse($db_upload["Description_Upload"]);
$paths = array_reverse($db_upload["path"]);
$dir_names = array_reverse($db_upload["dir_name"]);
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
  $res = json_decode(file_get_contents("./".$dir."/data.json"),true);
  $i = count($res["comments"]);
  $urlApi = "https://flagcdn.com";
  $sizeFlag = "/16x12/";
  $imageFlag = $userLangFromServer.".png";
  $res["flags"][$i] = $urlApi.$sizeFlag.$imageFlag;
  $res["comments"][$i] = htmlspecialchars($_POST["comment"]);
  $res["ip"][$i] = $_SESSION["username"];
  file_put_contents("./".$dir."/data.json",my_json_encode($res));
}

?>
<!DOCTYPE html>
<?php if (isset($_GET["hastag"])): ?>
<?php die();?>
<?php endif;?>
<html lang="<?= $userLangFromServer; ?>">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="my website galery">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?=$title_page." |  ".$author;?></title>
    <link rel="shortcut icon" href="<?= "$icon"; ?>" type="image/x-icon" />
  <!-- boostrap -->
    <?php include "./framework-handle.php";?>
    <link rel="stylesheet" href="/p/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/style.css" type="text/css" media="all" />
    <style type="text/css" media="all">
      body {
        padding: 60px 0;
        
      }
      .on-top h1{
        font-size: 30px;
        text-align: center;
        margin-top: -20px;
      }
      .logo {
        transition: 1s;
      }
      .logo.fixed-top {
        text-align: center;
      }
      .fixed-top h1 {
        margin-top: 30px;
      }
      #region {
        font-size: 8px;
        text-align: left;
        position: absolute;
        margin-top: -60px;
        z-index: 99999;
        margin-left: 5px;
      }
      #region span {
        text-transform: uppercase;
      }
      .title {
        font-size: 1.8em;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col" id="content">
          <div class="logo flex-on-top on-top py-2">
            <h1 class="title"><?=$title_page;?></h1>
          </div>
              <?php if(count($dates) == 0):?>
              <img class="img-fluid" src="no-post.png" alt="no post!"/>
              <h1 class="text-center">no post</h1>
              <?php endif;?>
          <?php for($i = 0;$i < count($dates) ;$i++):?>
          <?php if($paths[$i] != ""): ?>
          <?php
          $extensions = array_reverse($db_upload["extension"]);
          $dates = array_reverse($db_upload["Date_Upload"]);
          $titles = array_reverse($db_upload["title_post"]);
          $descs = array_reverse($db_upload["Description_Upload"]);
          $paths = array_reverse($db_upload["path"]);
          $dir_names = array_reverse($db_upload["dir_name"]);
          $date = $dates[$i];
          $title = $titles[$i];
          $desc = $descs[$i];
          $dir_name = "./".$dir_names[$i];
          $db_statistic = json_decode(file_get_contents("$dir_name/data.json"),true);
          $countLike = $db_statistic["like"];
          $tags = $db_statistic["hastag"];
          $idSection = "section_".($i + 1);
          ?>
          
          <div class="container-post" id="<?= $idSection; ?>">
          <div class="head clearfix mt-2 mx-2 px-2">
            <img class="float-start rounded-circle d-inline" src="<?= $icon; ?>" alt="" />
            <p class="d-inline mx-2 fw-bold"><?= $author;?></p>
            <p class="float-end d-inline-block"><i class="bi-three-dots" style="line-height:100%;font-size:18px;"></i></p>
          </div>
          <div class="info mx-2 mt-1">
            <?php if($extensions[$i] != "mp4"):?>
            <img class="img-fluid img-center post-img" src="/admin-post/<?= $paths[$i];?>" alt="<?= $title; ?>" />
            <?php else: ?>
            <video src="<?= $paths[$i];?>" class="post-video" preload="none" autoplay muted controls></video>
            <?php endif; ?>
            <div class="clearfix" style="font-size:25px;">
              <div class="float-start py-1 px-1">
                <i onclick="likeAdminPost(this,'<?= $dir_name; ?>',<?= $i; ?>)" class="bi-heart"></i>
                <i class="bi-chat mx-2" onclick="showCommentField('<?= $dir_name;?>','<?= $idSection; ?>')"></i>
                <i class="bi-share" onclick="share_event('<?= $protocol.$domain;?>/p/?post=<?= $i + 1 ;?>')"></i>
              </div>
              <div class="float-end py-1 px-1">
                <i class="bi-bookmarks"></i>
              </div>
            </div>
            <p class="my-1 fw-bold"><span id="countLike_<?= $i; ?>"><?= $countLike; ?></span> like</p>
            <p class="desc-post my-1"><b><?= $author; ?> </b>
            <span><?= $desc; ?>
            <br/>
            <br/>
            <br/>
            <?php foreach($tags as $tag):?>
            <a class="d-block link" href="search?hastag=<?= strtolower(str_replace("#","",$tag));?>"><?= $tag; ?></a>
            <?php endforeach;?>
            </span>
            </p>
            <p class="date-post text-muted d-inline-block" style="font-size:12px;"><?= $date; ?></p>
          </div>
          </div>
          <?php endif; ?>
          <?php endfor;?>
           <div class="footer mx-auto ">
    <a href="#">
    <div class="footer-tab active">
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
    <a href="<?= "./".$userLang.".php";?>?<?=$getPrefix;?><?=$aboutPrefix;?>">
    <div class="footer-tab">
      <p><i class="bi bi-three-dots"></i></p>
    </div>
    </a>
    <a href="<?= "./".$userLang.".php";?>">
    <div class="footer-tab">
      <p><i class="bi bi-person"></i></p>
    </div>
    </a>
  </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" charset="utf-8">
      var IsDark = Cookies.get("theme");
      
      if(IsDark == "dark"){
        $("*:not(a)").toggleClass("bg-dark");
        $("*:not(a,.footer *)").toggleClass("text-light");
      }else{
        $("*:not(a)").addClass("bg-light");
      }
      
      $("img").on("error",function(){
        let urlImg_error = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRmRfyQ8dCPQBtzH2IvrbdJs3zIdRAstfvEk8aaPsI5e9wjDEc&s";
        $(this).attr("src",urlImg_error);
        let alt = $(this).attr("alt");
        $(this).attr("alt",`image for (${alt}) error!`);
      })
      
      var distance = $(".container").offset().top;

      /*$(window).scroll(function() {
          if ( $(this).scrollTop() >= distance ) {
              $(".logo").addClass("fixed-top");
              $(".logo").removeClass("on-top");
          } else {
              $(".logo").removeClass("fixed-top");
              $(".logo").addClass("on-top");
          }
      });*/
      
      $(document).ready(function(){      
          $('body').find('img[src$="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]').remove();
         });
         
       const userLang = "<?= $userLang; ?>";
       const authorName = "<?= $author; ?>";
    </script>
    <script type="text/javascript" charset="utf-8">
      let doms = document.querySelectorAll(".desc-post span");
      let dirs = <?= json_encode($dir_names);?>;
      for (var i = 0; i < doms.length; i++) {
        let dom = doms[i];
        let domText = doms[i].innerHTML;
        let dir = dirs[i];
        if (domText.length > 30) {
          dom.data=dom.innerHTML;
          dom.innerHTML=domText.slice(0,30);
          let readmore = document.createElement("b");
          readmore.innerHTML = "Readmore..";
          readmore.addEventListener("click",function(){
            showCommentField(dir,`section_${i + 1}`,true,dom);
          })
          dom.appendChild(readmore);
        }
      }
    </script>
     <script type="text/javascript" charset="utf-8">
    var datePosts = document.querySelectorAll(".date-post");
    for (let i = 0; i < datePosts.length; i++) {
    let self = datePosts[i];
    //alert(self)
    let date = datePosts[i].innerHTML;
    let Time_post = new Date(date).getTime();
    let time_now = new Date().getTime();
    let selisihWaktu = time_now - Time_post;
    var d = Math.round(selisihWaktu / (1000 * 60 * 60 * 24));
    var h = Math.floor((selisihWaktu % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var m = Math.floor((selisihWaktu % (1000 * 60 * 60)) / (1000 * 60));
    var s = Math.floor((selisihWaktu % (1000 * 60)) / 1000);
    var msg;
      /* beberapa detik yg lalu */
      if(s == 0 && m < 1 && d < 1){
        msg = `baru saja`;
        self.innerHTML=msg;
      }else if(s < 60 && m < 1 && d < 1){
        msg = `${s} Second ago`;
        self.innerHTML=msg;
      } else if(m < 60 && h < 1 && d < 1) {
        msg = `${m} Minute ago`;
        self.innerHTML=msg;
      } else if(h < 60 && d < 1){
        msg = `${h} Hour ago`;
        self.innerHTML=msg;
      } else if(d >= 1 && d < 7){
        msg = `${d} day ago`;
        self.innerHTML=msg;
      } else if(d > 7 && d < 30){
        d = Math.floor(d / 7);
        msg = `${d} Week ago`;
        self.innerHTML=msg;
      } else if(d >= 30 && d < 365){
        d = Math.floor(d / 30);
        msg = `${d} bulan yang lalu`;
        self.innerHTML=msg;
      } else if(d >= 365 || d >= 366){
        d = Math.round(d / 365.25);
        msg = `${d} Year ago`;
        self.innerHTML=msg;
      }
     // alert(`${s}/${m}/${h}/${d}`)
    }
    
  </script>
    <script src="./event-btn.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="./clear-wm.js"></script>
  </body>
</html>