<?php
session_start();
function whoAreYou(){
  readfile("./whoAreYou.php");
}
if (isset($_GET["feature"])) {
  if ($_GET["feature"] == "deleteAll" && isset($_SESSION["isAdmin"])) {
    $fileDefault = json_decode(file_get_contents("../feature/upload/default-user.json"),true);
    file_put_contents("../feature/upload/DB-user.json",json_encode($fileDefault,JSON_PRETTY_PRINT));
    header("Location: ../feature/galery/");
    die();
  }
}
if(isset($_GET["delete"]) && isset($_SESSION["isAdmin"])){
  $data = json_decode(file_get_contents("../feature/upload/DB-user.json"),true);
  /* delete image from directory */
  $filename = $data["image_filename"][$_GET["delete"]];
  unlink("../feature/upload/user-images/$filename");
  $data["url"][$_GET["delete"]] = "";
  file_put_contents("../feature/upload/DB-user.json",json_encode($data,JSON_PRETTY_PRINT));
  header("Location: handle-userPost.php?feature=read");
}
?>
<?php if(isset($_SESSION["isAdmin"])): ?>
<?php
$arr = json_decode(file_get_contents("../feature/upload/DB-user.json"),true);
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
    <?php if(count($arr["url"]) != 0):?>
    <h1 class="text-center bg-primary">Data user posts</h1>
    <h1 class="text-center bg-info">Total Activity <b id="totalActivity"></n></h1>
    <table class="table table-sm text-center border bordered mx-auto">
  <thead class="bg-info">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">Judul</th>
      <th scope="col">Tanggal</th>
      <th scope="col">post</th>
      <th scope="col">fungsi</th>
    </tr>
  </thead>
  <tbody>
    <?php
     $index = 0;
    ?>
    <?php for($i = 0; $i < count($arr["url"]); $i++):?>
    <?php if($arr["url"][$i] != ""):?>
    <?php $index++; ?>
    <tr class="">
      <th scope="row"><?= $index; ?></th>
      <th scope="row"><?= $arr["username"][$i];?></th>
      <th scope="row"><?= $arr["title_post"][$i];?></th>
      <th class="time" scope="row"><?= $arr["Date_Upload"][$i];?></th>
      <th scope="row"><img width="100px" height="100px" class="img-fluid" alt="img" src="<?= $arr["url"][$i];?>"></th>
      <th scope="row"><a class="btn btn-danger" href="?delete=<?= $i; ?>">hapus</a></th>
    </tr>
    <?php else: ?>
    <?php 
    $totalActivity--;
    ?>
    <?php endif; ?>
    <?php endfor;?>
  </tbody>
</table>
<a href="#top" style="bottom:0" class="btn btn-success position-fixed">to top</a>
<a href="../feature/galery/" style="bottom:0;left:90px;" class="btn btn-info position-fixed">to galery</a>
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