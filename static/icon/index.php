<?php
$rootPath = $_SERVER["HTTP_HOST"];
if(isset($_GET["newest"])) {
  header('Content-Type: image/png');
  header("Content-Transfer-Encoding:  binary");
  $icon = "icon.png";
  readfile("$icon");
} else {
  header("Location: $rootPath");
}

if(!isset($_GET["newest"])){
  header("Location: $rootPath");
  die();
}
?>