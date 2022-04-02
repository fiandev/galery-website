<?php
if (isset($_POST["submit"])) {
  // code...
  $file = json_decode(file_get_contents("db-tes.json"),true);
  $fromUrl = $_POST["urlSender"];
  $total = $file["total"];
  $file["total"] = $total + 1;
  $file["username"][$total] = $_POST["name"];
  $file["email"][$total] = $_POST["email"];
  $file["message"][$total] = $_POST["message"];
  file_put_contents("db-tes.json",json_encode($file));
  header("Location: $fromUrl");
}
?>