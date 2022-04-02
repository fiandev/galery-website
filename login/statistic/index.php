<?php
session_start();
function whoAreYou(){
  readfile("../whoAreYou.php");
  //readfile("../../404.php");
}
if (isset($_GET["feature"])) {
  if ($_GET["feature"] == "deleteAll" && isset($_SESSION["isAdmin"])) {
    $fileDefault = json_decode(file_get_contents("../../default-log.json"),true);
    file_put_contents("../../log.json",json_encode($fileDefault,JSON_PRETTY_PRINT));
    header("Location: ../");
    die();
  }
}
?>
<?php if(isset($_SESSION["isAdmin"])): ?>
<?php
$arr = json_decode(file_get_contents("../../log.json"),true);
//var_dump($arr);
$ip = $_SERVER["REMOTE_ADDR"];
require "../../config.php";
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
    <link rel="stylesheet" href="../../framework/bootstrap.min.css?<?= filemtime("../../framework/bootstrap.min.css");?>" type="text/css" media="all" />
    <script src="../../framework/bootstrap.bundle.min.js?<?= filemtime("../../framework/bootstrap.bundle.min.js");?>" type="text/javascript" charset="utf-8"></script>
    <script src="../../framework/jquery-3.6.0.min.js?<?= filemtime("../../framework/jquery-3.6.0.min.js");?>" type="text/javascript" charset="utf-8"></script>
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
    <?php if(count($arr["user_ip"]) != 0):?>
    <h1 class="text-center bg-primary">Data Visitor</h1>
    <h1 class="text-center bg-info">Total Aktivitas <?=  count($arr["method"]);?></h1>
    <table class="table table-sm text-center border bordered mx-auto">
  <thead class="bg-info">
    <tr>
      <th scope="col">ip address</th>
      <th scope="col">date</th>
      <th scope="col">path</th>
      <th scope="col">Method</th>
    </tr>
  </thead>
  <tbody>
    <?php for($i = 0; $i < count($arr["user_ip"]); $i++):?>
    <tr class="
    <?php if($arr["method"][$i] == "POST"):?>
    <?= "bg-warning";?>
    <?php endif;?>
    ">
      <th scope="row"><?= $arr["user_ip"][$i];?></th>
      <th class="time" scope="row"><?= $arr["time_visited"][$i];?></th>
      <th scope="row"><a class="path" style="font-size:10px;" class="text-decoration-none" href="<?= $arr["path_visited"][$i];?>"><?= str_replace($domain,"",$arr["path_visited"][$i]);?></a></th>
      <th scope="row"><?= $arr["method"][$i];?></th>
    </tr>
    <?php endfor;?>
  </tbody>
</table>
<a href="#top" style="bottom:0" class="btn btn-success position-fixed">to top</a>
<a href="../" style="bottom:0;left:90px;" class="btn btn-info position-fixed">back</a>
<a href="?feature=deleteAll" style="bottom:0;right:10px;" class="btn btn-danger position-fixed">delete all</a>
<?php else: ?>
<h1 class="text-center bg-danger"> empty data </h1>
<?php endif; ?>
      </div>
     </div>
    </div>
    <script type="text/javascript" charset="utf-8">
      var elems = document.querySelectorAll(".time");
      var paths = document.querySelectorAll(".path");
      for(let i = 0; i < paths.length; i++){
        let path = paths[i];
        let html = path.innerHTML
        let sorted = html.slice(7,28);
        path.innerHTML=sorted;
      }
      
      for(let i = 0; i <= elems.length; i++){
        var elem = elems[i];
        let html = elem.innerHTML;
        let time = new Date(html);
        let date = time.getDate().toString();
        let month = (time.getMonth() + 1).toString();
        let year = time.getFullYear().toString().slice(2,4);
        let hour = time.getHours().toString();
        let minute = time.getMinutes().toString();
        let second = time.getSeconds().toString();
        if(date.length < 2){
          date = "0"+date;
        }
        if(month.length < 2){
          month = "0"+month;
        }
        if(year.length < 2){
          year = "0"+year;
        }
        if(hour.length < 2){
          hour = "0"+hour;
        }
        if(minute.length < 2){
          minute = "0"+minute;
        }
        if(second.length < 2){
          second = "0"+second;
        }
        elem.innerHTML=`${date}.${month}.${year}`;
        $(elem).attr("data",`${hour}:${minute}:${second}`);
        elem.addEventListener("click",function(elem){
          //alert ("!")
          let html = $(this).html();
          $(this).html($(this).attr("data"));
          let this_el = $(this);
          setTimeout(() => {
            $(this_el).html(html);
          },800)
        })
      }
      
      // 22-12-2021 00:00:00
    </script>
    <script type="text/javascript" src="../clear-wm.js"></script>
  </body>
</html>

<?php else: ?>
<?php whoAreYou(); ?>
<?php endif;?>