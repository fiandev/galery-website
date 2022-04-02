<?php
require "../../config.php";
require "../../function.php";
log_visited("../..");
//$images = array_diff(scandir("../upload/user-images/"), array("")); // ini array
$arr = json_decode(file_get_contents("../upload/DB-user.json"),true);
$images = $arr["url"];
$jumlah = count($images);
foreach ($images as $image){
  if ($image == "") {
    $jumlah--;
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="" content="">
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel="shortcut icon" href="<?= $icon; ?>" type="image/x-icon" />
    <title>galery users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" type="text/css" media="all" />
    <link href='../../framework/bootstrap.min.css' rel='stylesheet' integrity='sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We' crossorigin='anonymous'>
    <script src='../../framework/bootstrap.bundle.min.js' integrity='sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
  </head>
  <body>
    <div class="container mx-0">
      <div class="row">
        <div class="col">
          <h3 class="text-center py-2 ">All Users Photo</h3>
         <section class="gallery-container">
           <?php
            $index = 0;
           ?>
           <?php for($i = 0; $i < count($images); $i++):?>
           <?php $index++;?>
           <?php $bigger =  $i % 11 ;?>
           <?php if($images[$i] != ""):?>
            <div onclick="viewPost(<?= $index;?>)" class="box 
            <?php if($bigger == 0):?>
            <?= 'bigger'; ?>
            <?php endif; ?>">
              <img src="<?= $images[$i]; ?>">
            </div>
            <?php endif; ?>
          <?php endfor; ?>
          </section>
          <?php if($jumlah == 0):?>
          
          <style type="text/css" media="all">
            .gallery-container {
              width: 100%;
              height: 100px;
              background-image: url("../../no-post.png");
              background-position: center;
              background-size: 100px;
              background-repeat: no-repeat;
            }
            section {
              min-height: 50vh;
            }
          </style>
          <h1 class="text-center py-2">no post exist :(</h1>
          <?php endif; ?>
        </div>
      </div>
    </div>
     <div class="footer fixed-bottom mx-auto">
        <a href="../../">
        <div class="footer-tab">
          <p><i class="bi bi-house"></i></p>
        </div>
        </a>
        <a href="./">
    <div class="footer-tab active">
      <p><i class="bi bi-images"></i></p>
    </div>
    </a>
        <a href="../upload/">
    <div class="footer-tab">
      <p><i class="bi bi-upload"></i></p>
    </div>
    </a>
        <a href="../../en.php?page=about">
        <div class="footer-tab">
          <p><i class="bi bi-three-dots"></i></p>
        </div>
        </a>
        <a href="<?= "../../".$userLang.".php";?>">
    <div class="footer-tab">
      <p><i class="bi bi-person"></i></p>
    </div>
    </a>
    
  </div>
    
    <script src='../../framework/jquery-3.6.0.min.js' integrity='sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=' crossorigin='anonymous'></script>
    <script src='../../framework/js.cookie.min.js' crossorigin='anonymous'></script>
    <script type="text/javascript" charset="utf-8">
      function viewPost(index){
        window.location.href=`../post-users/?post=${index}`;
      }
    </script>
    <script type='text/javascript'>
    changeTheme(Cookies.get('theme'))
    function changeTheme(IsDark){
if(IsDark == 'dark'){
  $('body,svg').addClass('bg-dark');
  $('*:not(body,.btn-list-click,.btn-list,.list-menu,nav,.komentar-admin,.switch *,.switch)').addClass('bg-dark');
  $('*:not(body.btn-list-click,.btn-list,.list-menu,nav,.active,a,.c-komentar *)').addClass('text-light');
}else{
  $('body,svg').removeClass('bg-dark');
  $('*:not(body,.btn-list-click,.btn-list,.list-menu,nav,.komentar-admin,.switch *,.switch)').removeClass('bg-dark');
  $('*:not(body.btn-list-click,.btn-list,.list-menu,nav,.active,a,.komentar-admin,.c-komentar *)').removeClass('text-light');
}
}
    </script>
    <script type="text/javascript" src="../../clear-wm.js"></script>
  </body>
</html>