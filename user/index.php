<?php
session_start();
if (isset($_GET["id"])) {
  $id = $_SESSION["username"];
  $db_userDetail = json_decode(file_get_contents("./$id/data.json"),true);
  $name = $db_userDetail["name"];
  $age = $db_userDetail["age"];
  $ip_this_user = $db_userDetail["age"];
  $user_browser = $db_userDetail["browser"];
  $user_os = $db_userDetail["os"];
} else {
  // code...
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <?php include("../framework-handle.php");?>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <table class="table table-sm text-center border bordered mx-auto">
            <thead class="bg-info">
              <tr>
                <th scope="col">Nama</th>
                <th scope="col">umur</th>
                <th scope="col">ip</th>
                <th scope="col">browser</th>
                <th scope="col">os</th>
              </tr>
            </thead>
            <tbody>
              <tr class="">
                <th scope="row"><?= $name; ?></th>
                <th scope="row"><?= $age; ?></th>
                <th scope="row"><?= $ip_this_user; ?></th>
                <th scope="row"><?= $user_browser; ?></th>
                <th scope="row"><?= $user_os; ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>