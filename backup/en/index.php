<?php
//print_r($_SERVER);
date_default_timezone_set('Asia/Jakarta');
$host_url = $_SERVER["HTTP_HOST"];
$fjson = file_get_contents("DB.json");
$data = json_decode($fjson,true);
$like = $data["like"];
$dislike = $data["dislike"];
$comment = $data["comment"];
$total_visited = $data["visited"];
$total_comment = $data["total_comment"];
$isi_dir = scandir("./img");
$files = array_diff(scandir("./img"), array()); // ini array
// sort($files);
//var_dump($data);
$icon = "/static/icon/?newest=active";
function getRandomImg(){
  global $host_url;
  $imgs = array_diff(scandir("./img"), array('.', '..'));
  $img = $imgs[rand(2,count($imgs))];
  return $host_url."/img/".$img;
}
/* script api */

if(isset($_GET["api"])){
  $q = $_GET["api"];
  if($q == "random"){
    $arr = [];
    $arr["status"] = 200;
    $arr["random_image"] = getRandomImg();
    $arr["author"] = "Fian";
    /* $arr["folder"] = "img"; */
    header('Content-Type: application/json');
    echo json_encode($arr,JSON_UNESCAPED_SLASHES);
    die();
  }
}

if(isset($_GET["random"])){
    $arr = [];
    $arr["status"] = 200;
    $arr ["parameter"] = $_GET["random"];
    for ($i = 0; $i < $_GET["random"]; $i++) {
       $arr["result"][$i] = getRandomImg();
    }
    $arr["author"] = "Fian";
    /* $arr["folder"] = "img"; */
    header('Content-Type: application/json');
    echo json_encode($arr,JSON_UNESCAPED_SLASHES);
    die();
  }
  
if(isset($_GET["image"])){
  $param = $_GET["image"];
  //$imgs = array_diff(scandir("./img"), array('.', '..'));
  global $files;
  $imgs = $files;
  if($param == null || $param > count($imgs) - 1 || $param == 0){
    header("HTTP/1.0 404 Not Found");
    readfile("404.php");
    die();
  }
  $img = $imgs[$_GET["image"] + 1];
  /*
  header("Location: ./img/$img");
  */
  $path = "./img/$img";
  $name = "Postingan_ke-".$_GET["image"];
  // ngasih tau ke browser klo ini file gambar
  header('Content-Type: image/png');
  // ngasih tau ke browser nama gambar nya apa
// buat suruu browser biar download file
  //header("Content-Disposition:  attachment; filename=\"" . basename($img) . "\";" );
  header("Content-Transfer-Encoding:  binary");
  // merender gambar
  readfile("$path");
  die();
}
if(isset($_GET["alldata"])){
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
      $arr["image-post"][$a] = $host_url."/img/".$files[$i];
      $a++;
    }
    $arr["author"] = "Fian";
    header('Content-Type: application/json');
    echo json_encode($arr,JSON_UNESCAPED_SLASHES);
  }else if($_GET["alldata"] == "false"){
    $arr = [];
    $arr["status"] = 200;
    $arr["today_date"] = date("D, d-M-Y h:i:s A");
    $arr["total_likes"] = $like;
    $arr["total_dislike"] = $dislike;
    $arr["total_comment"] = $total_comment;
    $arr["author"] = "Fian";
    header('Content-Type: application/json');
    echo json_encode($arr,true);
    die();
  }else{
    echo "<h1 style='text-align:center;'>require parameter <a href='?alldata=true'>true</a> or <a href='?alldata=false'>false</a> !</h1>";
  }
  die();
}
if(isset($_GET["about"])){
  readfile("about.html");
  die();
}
/* main script */
function get_browser_name($user_agent){
    $t = strtolower($user_agent);
    $t = " " . $t;
    if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;   
    elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;   
    elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;   
    elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;   
    elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;   
    elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';
    return 'Unkown';
}
$userBrowser = get_browser_name($_SERVER["HTTP_USER_AGENT"]);
 $userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
 $id = bin2hex(random_bytes(20));
if(!isset($_GET["page"])){
  header("Location:?page=index&client=$userBrowser&lang=$userLang");
}else if($_GET["page"] !== "index"){
  header("Location:?page=index&client=$userBrowser&lang=$userLang");
}
if(isset($_GET["client"])){
  if($_GET["client"] !== $userBrowser){
    header("Location:?page=index&client=$userBrowser&lang=$userLang");
  }
}
if(!isset($_GET["client"])){
  header("Location:?page=index&client=$userBrowser&lang=$userLang");
}
if(!isset($_GET["lang"])){
  header("Location:?page=index&client=$userBrowser&lang=$userLang");
}
if($_GET["lang"] === "id"){
  header("Location:id.php");
}
/* if site visited */
if(isset($_GET)){
  $visited = $data["visited"];
  $data["visited"] = $visited + 1;
  $result = json_encode($data);
  //var_dump($result);
  file_put_contents("DB.json",$result);
}
if(isset($_POST["like"])){
  $likeData = $like + 1;
  //intval($likeData);
  //$dislikeData = $_POST["dislikeData"];
  $data["like"] = $likeData;
  $result = json_encode($data);
  //var_dump($result);
  file_put_contents("DB.json",$result);
}
if(isset($_POST["dislike"])){
  //$likeData = $_POST
  $dislikeData = $dislike + 1;
  //intval($dislikeData);
  $data["dislike"] = $dislikeData;
  $result = json_encode($data);
  file_put_contents("DB.json",$result);
}
if(isset($_POST["sendComment"])){
  $commentData = $_POST["comment"];
  $commentUsername = $_POST["username"];
  $index = $data["total_comment"];
  if($commentUsername == "" || $commentUsername == null){
    $commentUsername = "Anonymous";
  }
  $data["total_comment"] = $index + 1;
  $data["username_comment"][$index] = $commentUsername;
  $data["comment"][$index] = $commentData;
  $data["dateComment"][$index] = date("D, d M Y h:i:s A");
  $result = json_encode($data);
  file_put_contents("DB.json",$result);
}
$likes = $data["like"];
$dislikes = $data["dislike"];
$posts = count($files) - 2;
/*
if($likes >= 1000000000000000000000){
  $likes = floor($likes/1000000000000000000000)."Sx";
}else if($likes >= 1000000000000000000){
  $likes = floor($likes/1000000000000000000)."Q²";
}else if($likes >= 1000000000000000){
  $likes = floor($likes/1000000000000000)."Q¹";
}else if($likes >= 1000000000000){
  $likes = floor($likes/1000000000000)." T";
  */
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
?>
<!DOCTYPE html>
<html lang="<?= $userLang; ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>My Galery - with style similar Instagram</title>
  <!-- icon -->
  <link rel="shortcut icon" href="<?= "$icon"; ?>" type="image/x-icon" />
  <!-- boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/framework/bootstrap.min.css?<?= filemtime("./framework/bootstrap.min.css");?>" type="text/css" media="all" />
    <script src="./framework/bootstrap.bundle.min.js?<?= filemtime("./framework/bootstrap.bundle.min.js");?>" type="text/javascript" charset="utf-8"></script>

  <!-- Custom Styles -->
  <link rel="stylesheet" href="style.css">
  <script src="/framework/jquery-3.6.0.min.js?<?= filemtime("./framework/jquery-3.6.0.min.js");?>" type="text/javascript" charset="utf-8"></script>
</head>

<body id="body">
  <div class="container">
   
    <div class="row" id="react-header">
            <div class="col">
        <nav class="">
          <img class="rounded-circle mb-2 border bordered" src="<?= $icon; ?>" alt="" />
          <div class="btn-list-click">
          <ul class="mx-1 py-2 px-1 btn-list">Pengaturan
            </ul>
         <a href="#"><li class="list-menu mx-1">List1</li></a>
         <a href="#"><li class="list-menu mx-1">List2</li></a>
         <a href="#"><li class="list-menu mx-1">List3</li></a>
         <a href="#"><li class="list-menu mx-1">List4</li></a>
         </div>
          <div class="btn-list-click">
          <ul class="mx-1 py-2 px-1 btn-list">Menu
            </ul>
         <a href="#"><li class="list-menu mx-1">List1</li></a>
         <a href="#"><li class="list-menu mx-1">List2</li></a>
         <a href="#"><li class="list-menu mx-1">List3</li></a>
         <a href="#"><li class="list-menu mx-1">List4</li></a>
         </div>
        </nav>
        <div class="nav-top clearfix">
          <p class="dropdown-toggle" onclick="navShow()">Fian</p>
          <form action="" method="post" accept-charset="utf-8">
          <button class="btn-kotak" type="submit" ><span onclick="addDislike()">👎</span></button>
          <button class="btn-kotak" type="submit"><span onclick="addLike()">❤️</span></button>
          <input class="" type="hidden" name="" id="like" value="" />
          <input class="" type="hidden" name="" id="dislike" value="" />
          </form>
        </div>
        <div class="clearfix c-info-user">
          <img class="hero border bordered rounded-circle float-start" src="<?= "$icon";?>" alt="" />
          <div class="c-information float-end">
            <div class="mx-auto">
              <p style="font-weight:bold;" id="countPosts"><?= $posts;?></p>
              <p>post</p>
            </div>
            <div class="mx-auto">
              <p style="font-weight:bold;" id="countLikes"><?= $likes;?></p>
              <p>Like</p>
            </div>
            <div class="mx-auto">
              <p style="font-weight:bold;" id="countDislikes"><?= $dislikes;?></p>
              <p>Dislike</p>
            </div>
          </div>
        </div>
        <div class="c-info mt-3">
          <p class="nickname">Call Me Fian</p>
          <p class="bio">This is my web gallery, please have a look</p>
          <p><small class="text-muted">last update on <b>Sunday, 31-10-2021 2:21 AM</b></small></p>
          <p class="mt-1 text-muted"><i>~ Total Visitor <b><?= $total_visited; ?></b></i></p>
        </div>
        
      </div>
      <!-- Tab postingan -->
      <div class="w-100 mt-3 mb-1">
        <div id="btn1" onclick="openTab('btn1','tab1')" class="tab tab-active">post</div>
        <div id="btn2" onclick="openTab('btn2','tab2')" class="tab">comment</div>
      </div>
    </div>
    <!-- content -->
    <div class="c-postingan">
    <div class="postingan w-100 main-post mb-2" id="tab1">
      <?php $a = 0; ?>
      <?php for($i = 2; $i <= count($files) - 1; $i++):?>
      <?php $a++; ?>
      <a href='<?= "?image=$a";?>' id='_<?= $a;?>'><div class='post-value' style='background-image:url("<?= "img/".$files[$i]; ?>");'></div></a>
      <?php endfor;?>
            <!-- metode image -->
            <!--
      <div class="post-value">
      <a href="<?= "?image=$a"; ?>">
        <img class="" src="img/<?=$files[$i];?>" alt="<?= "postingan";?>"/>
        </a>
      </div>
      -->
      
      <div class="spin">
        <div class="spinner">
          
        </div>
      </div>
    </div>
  </div>
  
  <div class="postingan mb-2" id="tab2">
    
    <h5 style="font-size:15px;font-weight:normal;" class="text-center">comment <b><?=$total_comment;?></b><h5>
    <?php for($a = 0; $a <= $total_comment- 1; $a++): ?>
    <div class="mx-1 mb-1 c-komentar border bordered py-1 px-2">
      <p class="tgl"><?= $data["dateComment"][$a];?></p>
      <h6 class="d-inline-block"><?= $data["username_comment"][$a];?>
      : </h6>
      <p class="d-inline komentar"><?= $data["comment"][$a]; ?></p>
    </div>
    <?php endfor; ?>
    <p style="font-size:13px;font-weight:normal;" class="text-center mt-2">write your comment :</p>
    <form class="mt-1 clearfix form-control " action="" method="post" accept-charset="utf-8">
     <label class="input-group" for="username">username :</label><input class="form-control my-2" type="text" name="username" id="username" placeholder="username .." value="Anonymous" />
     <label class="input-group" for="comment">Comment :</label><textarea placeholder="comment .." required class="form-control my-2" name="comment" id="comment" value=""></textarea>
     <label class="input-group" for="captha"><input class="my-2 form-control float-start" type="text" id="capthaCode" style="width:80%;" readonly value="" /><input style="width:20%;" class="form-control float-end text-center my-2" type="text" name="" id="cd" value="" readonly="" /></label>
     <label for="captha" class="">captcha :</label>
     <input class="my-2 form-control" type="text" name="captha" id="captha" value="" />
     <input class="btn-comment btn btn-outline-info" name="sendComment" type="submit" value="send">
   </form>
  </div>
  
  <!-- belajar install Disqus
  <div id="disqus_thread"></div>
<script>
    /**
    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://localhost-8080-0fqebrzgdq.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
  </div>
script id="dsq-count-scr" src="//localhost-8080-0fqebrzgdq.disqus.com/count.js" async></script>
  -->
  <!-- footer -->
    <div class="footer mx-auto ">
    <a href="#">
    <div class="footer-tab active">
      <p><i class="bi bi-house"></i></p>
    </div>
    </a>
    <a href="?about">
    <div class="footer-tab">
      <p><i class="bi bi-three-dots"></i></p>
    </div>
    </a>
  </div>
  <!-- javascript -->
  <script src="main-no-trim.js?<?= filemtime("main-no-trim.js");?>"></script>
  <script src="lazyload.js?<?= filemtime("lazyload.js");?>" type="text/javascript" charset="utf-8"></script>
</body>
</html>