<?php
require "../../config.php";
require "../../function.php";
Log_Visited("../..");
session_start();
if (isset($_SESSION["username"])) {
  $username = str_replace("\r\n","",$_SESSION["username"]);
}
if(isset($_POST["send"])){
  $howmany = count($_FILES);
    $key = "file";
    //echo $_POST[$key];
    $title = htmlspecialchars($_POST["title"]);
    $name = "[".$title."]_-_".date("Y-m-d_H:i:s");
    $FileToUpload = $_FILES[$key]["tmp_name"];
    $sizeFileUpload = $_FILES[$key]["size"];
    if ($sizeFileUpload >= 1000000) {
      echo "files cannot be larger than 1mb / 1000kb";
      die();
    }
    if($FileToUpload == ""){
      $FileToUpload = $_FILES[$key]["full_path"];
    }
    $pathFile = $_FILES[$key]["name"];
    //var_dump($FileToUpload);
    //echo $_POST[$key];
    $eks = pathinfo($pathFile,PATHINFO_EXTENSION);
    /* ekstensi yang di perbolehkan */
    $acceptExtensions = ["png","jpg","jpeg","gif","mp4","mkv"];
    foreach ($acceptExtensions as $extension) {
      if($eks == $extension){
    $TargetDirectory = __DIR__."/user-images/".$name.".".$eks;
    $PathUrl = $_SERVER["REQUEST_URI"];
    //echo $TargetDirectory;
    //var_dump($_FILES);die();
    $description = htmlspecialchars($_POST["description"]);
    $username = htmlspecialchars($_POST["username"]);
    if($username == null || $username == ""){
      $username = $_SERVER["REMOTE_ADDR"];
    }
    move_uploaded_file($FileToUpload,$TargetDirectory);
    $resultUrl = $protocol.$domain."/feature/upload/user-images/".$name.".".$eks;
    $json = file_get_contents("./DB-user.json");
    $data = json_decode($json,true);
    $Total_posts = count($data["url"]);
    $data["Description_Upload"][$Total_posts] = $description;
    $data["username"][$Total_posts] = htmlspecialchars($username);
    $data["title_post"][$Total_posts] = htmlspecialchars($_POST["title"]);
    $data["Date_Upload"][$Total_posts] = date("D, d-M-Y H:i:s");
    $data["lastupdate"][$Total_posts] = date("D, d-m-Y H:i");
    $data["image_filename"][$Total_posts] = $name.".".$eks;
    $data["url"][$Total_posts] = $resultUrl;
    $data["extension"][$Total_posts] = $eks;
    $res = json_encode($data,JSON_PRETTY_PRINT);
    file_put_contents("./DB-user.json",$res);
    log_visited("../..");
    header("Location: ../galery/");
    }
   }
    echo "
       <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv='content-type' content='text/html; charset=utf-8' />
            <meta name='viewport' content='width=device-width,initial-scale=1'>
            <link rel='icon shortcut' href='$icon'>
            <title>file not allowed !</title>
            <link href='../../framework/bootstrap.min.css' rel='stylesheet' integrity='sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We' crossorigin='anonymous'>
            <script src='../../framework/bootstrap.bundle.min.js' integrity='sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj' crossorigin='anonymous'></script>
        </head>
        <body>
        <style>
        *:not(b) {
           text-transform: capitalize;
        }
        </style>
        <div class='container mx-auto'>
          <p class='bg-warning text-center'>failed to upload <b>$pathFile !</b></p>
          <p class='text-danger'>extension <b class='text-dark'>.$eks</b> is not allowed!</p>
         </div>
        </body>
    </html>
   ";
   die();
}
?>
<!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Silahkan Unggah Foto Anda !</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" type="text/css" media="all" />
    <link href='<?= $icon; ?>' rel='shortcut icon' type='image/x-icon' >
    <link href='../../framework/bootstrap.min.css' rel='stylesheet' integrity='sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We' crossorigin='anonymous'>
    <script src='../../framework/bootstrap.bundle.min.js' integrity='sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj' crossorigin='anonymous'></script>
    <link href='../../style.css' rel='stylesheet'>
    <style type='text/css' media='all'>
            .alert {
                transition: 1s;
                transform: translateY(-200%);
            }
         body {
            background-image: url(.bg.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
        }
        .title {
            text-shadow: 3px 3px 0px #000;
        }
        </style>
        <script src='../../framework/jquery-3.6.0.min.js' integrity='sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=' crossorigin='anonymous'></script>
    </head>
    <body>
    <div class='container'>
     <div class='row'>
      <div>
      <form class='form-control' id='form_upload' action='' method='post' accept-charset='utf-8' enctype='multipart/form-data'>
      <label for="username" class="my-1">Username</label>
      <input class="form-control mb-1" type="text" name="username" id="username_field" value="" />
      <?php if(isset($username)):?>
      <script type="text/javascript">
        $("#username_field").attr("value","<?= $username; ?>");
      </script>
      <?php endif; ?>
      <label for="take-picture">Insert file to post</label>
      <input class='form-control mb-1' type='file' name='file' id='take-picture' value='' required/>
      <p class='text-muted'>Preview :</p>
      <img id='show-picture' width='100px' height='100px' style='display:none' />
      <label for='title' class='my-1'>Post Title :</label>
      <input class='form-control' required name='title' id='title' value=''/>
      <label for='description' class='my-1'>Post Description :</label>
      <textarea class='form-control mb-1' type='text' id='description' name='description' value='' required> </textarea>
      <input class='btn btn-outline-primary my-2' type='submit' name='send' id='submit' value='submit' />
    </form>
      </div>
     </div>
    </div>
         <div class="footer fixed-bottom mx-auto">
        <a href="../../">
        <div class="footer-tab">
          <p><i class="bi bi-house"></i></p>
        </div>
        </a>
            <a href="../galery/">
        <div class="footer-tab">
          <p><i class="bi bi-images"></i></p>
        </div>
        </a>
            <a href="./">
        <div class="footer-tab active">
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

    <script src='../../framework/js.cookie.min.js' crossorigin='anonymous'></script>
    <script src='../../login/img-preview.js'></script>
    <script src='../../main-no-trim.js' crossorigin='anonymous'></script>
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