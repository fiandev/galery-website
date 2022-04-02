<?php
$host_url = $_SERVER["HTTP_HOST"];
function getRandomImg(){
  global $host_url;
  $imgs = array_diff(scandir("../../img"), array('.', '..'));
  $img = $imgs[rand(2,count($imgs))];
  return $host_url."/img/".$img;
}
$fjson = file_get_contents("data.json");
$arr = json_decode($fjson,true);
    $arr["status"] = 200;
    $arr["random_image"] = getRandomImg();
    $arr["author"] = "Fian";
    /* $arr["folder"] = "img"; */
    //header('Content-Type: application/json');
    $result = json_encode($arr,JSON_UNESCAPED_SLASHES);
    file_put_contents("data.json",$result);
    header("Location: $host_url/api/random/data.json");
?>