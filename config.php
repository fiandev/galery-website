<?php
date_default_timezone_set('Asia/Jakarta');
$host_url = $_SERVER["HTTP_HOST"];
$db_upload = json_decode(file_get_contents(__DIR__."/DB.json"),true);
$db_config = json_decode(file_get_contents(__DIR__."/config.json"),true);
$db_rating = json_decode(file_get_contents(__DIR__."/like-dislike.json"),true);
$db_comment = json_decode(file_get_contents(__DIR__."/comment.json"),true);
$extensions_upload = $db_upload["extension"];
$paths_upload = $db_upload["path"];
$like = $db_rating["like"];
$dislike = $db_rating["dislike"];
$total_visited = $db_rating["visited"];
$comment = $db_comment["comment"];
$total_comment = $db_comment["total_comment"];
foreach ($comment as $komentar){
  if ($komentar == "") {
    $total_comment--;
  }
}
$lastUpdate = $db_upload["lastupdate"];
$authorName = $db_config["authorName"];
$isi_dir = scandir(__DIR__."/admin-post");
$files = array_values(array_diff(scandir(__DIR__."/admin-post/"), array('..', '.')));// ini array
$userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$userLangFromServer = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
$domain = $_SERVER["HTTP_HOST"];
$path_request = $_SERVER["REQUEST_URI"];
$icon = $protocol.$domain."/static/icon/?newest=active";
$ip_user = $_SERVER["REMOTE_ADDR"];
if($userLangFromServer != "id"){
  $userLang = "en";
  $prefix = "image";
  $title = "My Galery";
  $aboutPrefix = "about";
  $getPrefix = "";
}
$version = "4.1.0";

?>