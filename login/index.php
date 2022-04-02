<?php
date_default_timezone_set('Asia/Jakarta');
require "../function.php";
$files = array_diff(scandir("../admin-post"), array("index.php"));
$icon = "/static/icon/?newest=active";
$Total_posts = count($files) - 2;
$userLogin = "ryuu13";
$passLogin = "pw1234";
if(isset($_POST["submit"])){
    cek();
}
$path = $_SERVER["HTTP_HOST"];
if(isset($_POST["send"])){
  $howmany = count($_FILES);
    $key = "file0";
    $FileToUpload = $_FILES[$key]["tmp_name"];
    
    if($FileToUpload == ""){
      $FileToUpload = $_FILES[$key]["full_path"];
    }
    $pathFile = $_FILES[$key]["name"];
    $name = date("Y-m-d_H:i:s");
    $eks = pathinfo($pathFile,PATHINFO_EXTENSION);
    $acceptExtensions = ["png","jpg","jpeg","gif","mp4","mkv"];
    foreach ($acceptExtensions as $extension) {
      if($eks == $extension){
    $timeNow = date("D, d M Y h:i:s A");
    $TargetDirectory = "../admin-post/".$name.".".$eks;
    /* cek apa file json untuk database like dg
       nama yang sama sudah ada / belum
       1 = true
    */
    $nameDir = uniqid();
    if(is_dir("".$nameDir) == 1){
      mkdir("../$nameDir [duplicate]");
      $nameDir = $nameDir." [duplicate]";
    } else {
      mkdir("../$nameDir");
    }
    /* buat file json nya */
    $fileJson_create = fopen("../$nameDir/data.json", "w") or die("Unable to open file!");
    $value = '{
      "like":0,
      "dislike":0,
      "comments":[],
      "hastag":[]
    }';
    fwrite($fileJson_create, $value);
    fclose($fileJson_create);
    $PathUrl = $_SERVER["REQUEST_URI"];
    $description = str_replace("\n","<br/>",$_POST["description"]);
    move_uploaded_file($FileToUpload,$TargetDirectory);
    $resultUrl = "http://".$path."/admin-post/".$name.".".$eks;
    $json = file_get_contents("../DB.json");
    $data = json_decode($json,true);
    $Total_posts = count($data["path"]);
    $data["Description_Upload"][$Total_posts] = $description;
    $data["title_post"][$Total_posts] = $_POST["title"];
    $data["Date_Upload"][$Total_posts] = $timeNow;
    $data["lastupdate"] = $timeNow;
    $data["extension"][$Total_posts] = $eks;
    $data["path"][$Total_posts] = $TargetDirectory;
    $data["dir_name"][$Total_posts] = $nameDir;
    $eachHastag = $_POST["count_hastag"];
    $json_onDir_post = json_decode(file_get_contents("../$nameDir/data.json"),true);
    for ($i = 0; $i <= $eachHastag; $i++) {
      if ($_POST["hastag_$i"] !== null) {
        // code...
        $json_onDir_post["hastag"][$i] = $_POST["hastag_$i"];
      }
    }
    file_put_contents("../$nameDir/data.json",json_encode($json_onDir_post,JSON_PRETTY_PRINT));
    $res = json_encode($data,JSON_PRETTY_PRINT);
    file_put_contents("../DB.json",$res);
     echo "<script>
        setTimeout(function(){
              window.location.href='../'
            },1000)</script>";
      die();
      }
    }
    echo "extension <b>.$eks</b> is not allowed to upload!";
    die();
}
if(isset($_POST["sendNewNameAuthor"])){
  if ($_POST["verify_password"] === $passLogin) {
    $newNameAuthor = $_POST["newNameAuthor"];
    $data = json_decode(file_get_contents("../config.json"),true);
    $data["authorName"] = $newNameAuthor;
    $res = json_encode($data,JSON_PRETTY_PRINT);
    /* JSON_UNESCAPED_SLASHES */
    file_put_contents("../config.json",$res);
    echo "<script>
    setTimeout(function(){
          window.location.href='../'
        },1000)</script>";
        die();
    
  }
}
function giftAlert($pesan){
    echo "<div style='transform:translateY(-200%);' class='alert text-center fixed-top bg-success text-light'>$pesan</div>";
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(0%)");clear()},1000)</script>';
}
session_start();
if(isset($_SESSION["isAdmin"])){
    to_admin_dashboard_sesi();
    die();
}
function to_admin_dashboard_sesi(){
Log_Visited("..");
require "./admin_dashboard.php";
/*
$_SESSION["expired"] = time();
$_SESSION["isAdmin"] = true;
*/
//var_dump($_SESSION);
$db_comment = json_decode(file_get_contents("../comment.json"),true);
$adminDb = json_decode(file_get_contents("./db_admin.json"),true);
$muchData = count($db_comment["comment"]);
$muchData_old = $adminDb["data_comment"];
$newComment = 0;
if($muchData_old < $muchData){
  $newComment = $muchData - $muchData_old;
}
$json = file_get_contents("../config.json");
$data = json_decode($json,true);
$authorName = $data["authorName"];
$icon = "/static/icon/?newest=active";

  echo '<div style="transform:translateY(-200%);" class="alert text-center fixed-top bg-success text-light">Succes Login !</div>';
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(0%)");clear()},1000)</script>';
   echo dashboard("../",$authorName,$icon,$authorName);
    echo "<script>let a = $newComment;document.getElementById('notif').innerHTML=a</script>";
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(-200%)");},2000)</script>';
}
function to_admin_dashboard_noSesi(){
session_start();
Log_Visited("..");
require "./admin_dashboard.php";
$_SESSION["expired"] = time();
$_SESSION["isAdmin"] = true;
//var_dump($_SESSION);
$db_comment = json_decode(file_get_contents("../comment.json"),true);
$json_adminDb = file_get_contents("./db_admin.json");
$adminDb = json_decode($json_adminDb,true);
$muchData = count($db_comment["comment"]);
$muchData_old = $adminDb["data_comment"];
$newComment = 0;
if($muchData_old < $muchData){
  $newComment = $muchData - $muchData_old;
}
$db_config = json_decode(file_get_contents("../config.json"),true);
$authorName = $db_config["authorName"];
$icon = "/static/icon/?newest=active";

  echo '<div style="transform:translateY(-200%);" class="alert text-center fixed-top bg-success text-light">Succes Login !</div>';
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(0%)");clear()},1000)</script>';
   echo dashboard("../",$authorName,$icon,$authorName);
    echo "<script>let a = $newComment;document.getElementById('notif').innerHTML=a</script>";
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(-200%)");},2000)</script>';
}
function cek(){
  global $path;
  global $userLogin;
  global $passLogin;
if($_POST["username"] != $userLogin || $_POST["pass"] != $passLogin){
    echo '<div style="transform:translateY(-200%);" class="alert text-center fixed-top bg-danger text-light">Incorrect username or password</div>';
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(0%)");clear()},1000)</script>';
}else if($_POST["pass"] == "" || $_POST["username"] == ""){
    echo '<div style="transform:translateY(-200%);" class="alert text-center fixed-top bg-dark text-light">unkown username or password</div>';
    echo '<script>setTimeout(() => {$(".alert").css("transform","translateY(0%)");clear()},1000)</script>';
}else{
to_admin_dashboard_noSesi();
die();
  /*  echo "<!DOCTYPE HTML>
<html lang='en-US'>
<head>
        <meta charset='UTF-8'>
        <script type='text/javascript'>
        </script>
        <meta http-equiv='refresh' content='0; url=../'>
        <link rel='shortcut icon' href='../icon.jpg' type='image/x-icon' />
        <title>Page Redirection</title>
        <link rel='stylesheet' href='./framework/bootstrap.min.css'>
    </head>
    <body>
    <?php giftAlert('Succes Login !');?>
    </body>
</html>";
echo "<script>setTimeout(function(){
          window.location.href='../'
        },1000)
        </script>";
        */
  }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login</title>
                <!-- bootstrap -->
        <link href="../framework/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="shortcut icon" href="<?= $icon; ?>" type="image/x-icon" />
        <script src="../framework/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <style type="text/css" media="all">
            .alert {
                transition: 1s;
                transform: translateY(-200%);
            }
         body {
            background-image: url('../bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
        }
        .title {
            text-shadow: 3px 3px 0px #000;
        }
        </style>
    </head>
    <body class="bg-secondary">
        <div class="container">
            <div class="row">
                <div class="col text-center mx-auto">
                    <h1 class="title text-info mt-2">Login</h1>
                    <form class="clearfix form-control" action="" method="post" accept-charset="utf-8">
                        <label class="input-group" for="username">username :</label><input required class="form-control my-2" type="text" name="username" id="username" value="" />
                        <label class="input-group" for="pass">password :</label><input required class="form-control my-2" type="password" name="pass" id="pass" value="" />
                        <button class="btn btn-outline-info float-start" name="submit" type="submit">send</button>
                        <label for="pass" id="btn-see" class="text-primary float-end">view password</label>
                    </form>
                </div>
            </div>
        </div>
         <script src="../framework/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
         <script src="../framework/js.cookie.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
         <script type="text/javascript" charset="utf-8">
         function clear(args){
             setTimeout(() => {
                 $(".alert").css("transform","translateY(-200%)");
             },3000)
         }
             $("#btn-see").on("click",function(){
                 $("#pass").attr("type","text");
                 $("#btn-see").html("hide password");
                 $(".text").attr("type","password");
                 $("#pass").toggleClass("text");
                 
                 $(".text-btn").html("view password");
                 
                 $("#btn-see").toggleClass("text-btn");
             })
         </script>
         <script type="text/javascript" charset="utf-8">
           var IsDark = true;
            function changeTheme() {
              $("body").css("background-image","url()");
             $("form *:not(#btn-see),form").addClass("text-light");
             $("form *,form,body").addClass("bg-dark");
            }
            if(IsDark){
              changeTheme();
            }
            $(document).ready(function(){      
                $('body').find('img[src$="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]').remove();
               });
         </script>
         <script type="text/javascript" src="../clear-wm.js"></script>
    </body>
</html>