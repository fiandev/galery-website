<?php
$ip = $_SERVER["REMOTE_ADDR"];
$userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)  ;

if($userLang === "id"){
  header("Location: ./id.php");
}else{
  header("Location: ./en.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="my website galery">
    <title>My website galery - ryuu13</title>
  </head>
  <body>
    
  </body>
</html>