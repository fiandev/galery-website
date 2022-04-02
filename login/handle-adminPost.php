<?php
session_start();
function whoAreYou(){
  readfile("./whoAreYou.php");
}
function my_rmdir($dir){
 if (is_dir($dir))
 {
  $objects = scandir($dir);

  foreach ($objects as $object)
  {
   if ($object != '.' && $object != '..')
   {
    if (filetype($dir.'/'.$object) == 'dir') {rrmdir($dir.'/'.$object);}
    else {unlink($dir.'/'.$object);}
   }
  }

  reset($objects);
  rmdir($dir);
 }
}
if (isset($_GET["feature"])) {
  if ($_GET["feature"] == "deleteAll" && isset($_SESSION["isAdmin"])) {
    $data = json_decode(file_get_contents("../DB.json"),true);
    $paths = $data["path"];
    foreach ($paths as $i => $path) {
      $filePath = str_replace("\/","/",$path);
      unlink($filePath);
      my_rmdir("../".$data["dir_name"][$i]);
    }
    foreach ($paths as $i => $path) {
      $data["Description_Upload"] = array_splice($data["Description_Upload"], 0, $i);
      $data["Date_Upload"] = array_splice($data["Date_Upload"], 0, $i);
      $data["title_post"] = array_splice($data["title_post"], 0, $i);
      $data["extension"] = array_splice($data["extension"], 0, $i);
      $data["dir_name"] = array_splice($data["dir_name"], 0, $i);
      $data["path"] = array_splice($data["path"], 0, $i);
    }
    /*
    $fileDefault = json_decode(file_get_contents("../default.json"),true);*/
    file_put_contents("../DB.json",json_encode($data,JSON_PRETTY_PRINT));
    header("Location: ../");
    die();
  }
}
if(isset($_GET["delete"]) && isset($_SESSION["isAdmin"])){
  $data = json_decode(file_get_contents("../DB.json"),true);
  /* delete image from directory */
  $pathinfo = str_replace("\/","/",$data["path"][$_GET["delete"]]);
  unlink($pathinfo);
  my_rmdir("../".$data["dir_name"][$_GET["delete"]]);
  $in = $_GET["delete"];
  $data["Description_Upload"] = array_splice($data["Description_Upload"], 0, $in);
  $data["Date_Upload"] = array_splice($data["Date_Upload"], 0, $in);
  $data["title_post"] = array_splice($data["title_post"], 0, $in);
  $data["extension"] = array_splice($data["extension"], 0, $in);
  $data["dir_name"] = array_splice($data["dir_name"], 0, $in);
  $data["path"] = array_splice($data["path"], 0, $in);
  file_put_contents("../DB.json",json_encode($data,JSON_PRETTY_PRINT));
  header("Location: ./handle-adminPost.php?feature=read");
}
?>
<?php if(isset($_SESSION["isAdmin"])): ?>
<?php
$arr = json_decode(file_get_contents("../DB.json"),true);
//var_dump($arr);
$ip = $_SERVER["REMOTE_ADDR"];
require "../config.php";
$totalActivity = count($arr["title_post"]);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>data comments</title>
     <!-- boostrap -->
    <link rel="shortcut icon" href="<?= $icon; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../framework/bootstrap.min.css?<?= filemtime("../framework/bootstrap.min.css");?>" type="text/css" media="all" />
    <script src="../framework/bootstrap.bundle.min.js?<?= filemtime("../framework/bootstrap.bundle.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <script src="../framework/jquery-3.6.0.min.js?<?= filemtime("../framework/jquery-3.6.0.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <style type="text/css" media="all">
    table {
      width: 100%;
    }
      #comment_section {
        width: 120px;
        overflow-x: scroll;
      }
    </style>
  </head>
  <body>
    <div class="container clearfix">
    <div class="row">
    <div class="col clearfix mx-0">
    <?php if(count($arr["path"]) != 0):?>
    <h1 class="text-center bg-primary">Data upload</h1>
    <h1 class="text-center bg-info">Total upload <b id="totalActivity"></n></h1>
    <table class="table table-sm text-center border bordered mx-auto">
  <thead class="bg-info">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Judul</th>
      <th scope="col">Tanggal</th>
      <th scope="col">post</th>
      <th scope="col">fungsi</th>
    </tr>
  </thead>
  <tbody>
    <?php for($i = 0; $i < count($arr["path"]); $i++):?>
    <?php if($arr["path"][$i] != ""):?>
    <tr class="">
      <th scope="row"><?= $i + 1;?></th>
      <th scope="row"><?= $arr["title_post"][$i];?></th>
      <th class="time" scope="row"><?= $arr["Date_Upload"][$i];?></th>
      <th scope="row">
        <?php if($arr["extension"][$i] == "mp4"):?>
        <video src="<?= $arr["path"][$i]; ?>"  width="100%" height="auto" muted autoplay controls>
          <source type="video/mp4"></source>
        </video>
        <?php else: ?>
        <a href="../p/?post=<?= $i + 1; ?>"><img class="img-fluid" alt="img" src="<?= $arr["path"][$i];?>"></a>
        <?php endif; ?>
        </th>
      <th scope="row"><a class="btn btn-danger" href="?delete=<?= $i; ?>">hapus</a></th>
    </tr>
    <?php else: ?>
    <?php $totalActivity--; ?>
    <?php endif; ?>
    <?php endfor;?>
  </tbody>
</table>
<a href="#top" style="bottom:0" class="btn btn-success position-fixed">to top</a>
<a href="../<?= $userLang;?>.php" style="bottom:0;left:90px;" class="btn btn-info position-fixed">to <?= $userLang; ?>.php</a>
<a href="?feature=deleteAll" style="bottom:0;right:10px;" class="btn btn-danger position-fixed">delete all</a>
<?php else: ?>
<h1 class="text-center bg-danger"> empty data </h1>
<?php endif; ?>
      </div>
     </div>
    </div>
    <script type="text/javascript" charset="utf-8">
      document.querySelector("#totalActivity").innerHTML='<?= $totalActivity; ?>';
    </script>
    <script type="text/javascript" src="../clear-wm.js"></script>
  </body>
</html>

<?php else: ?>
<?php whoAreYou(); ?>
<?php endif;?>