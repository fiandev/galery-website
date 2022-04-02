<?php
require "../config.php";
require "../function.php";
session_start();

$user_agent = $_SERVER["HTTP_USER_AGENT"];
if (isset($_POST["submit"])) {
  $username = htmlspecialchars($_POST["username"]);
  $age = htmlentities($_POST["age"]);
  $path = "user";
  $dir = $username."#".getRandom_Number(4);
  /*
  if (isset($_POST["remember"])) {
    $_SESSION["hasBeenVisit"] = true;
    $_SESSION["username"] = $username;
    $_SESSION["age_user"] = $age;
  } else {
      // check if dir is not exist 
  }
  */
 if (!is_dir("../$path/$dir/")) {
   /*
     mkdir("../$path/$dir/");
     $dataCreate = fopen("../$path/$dir/data.json","w");
     fwrite($dataCreate,'{
    "name":"'.$dir.'",
    "age":'.$age.',
    "ip":"'.$ip_user.'",
    "browser":"'.get_browser_name($user_agent).'",
    "os":"'.getOS($user_agent).'"
}
      ');
     fclose($dataCreate);
     */
    } else {
      $dir = $username."#".getRandom_Number(5);
    }
    $_SESSION["hasBeenVisit"] = true;
    $_SESSION["username"] = $dir;
    $_SESSION["age_user"] = $age;
  header("Location: ../");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $db_config["authorName"]; ?> | verification</title>
    <link rel="shortcut icon" href="<?= $icon; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>
<body>
    <form class="container" id="form" target="" method="POST">
        <div class="right-side">
          <div class="containte">
          <div class="login-card">
            <label for="username">username :</label>
              <input class="form-input" required id="username" name="username" type="text" placeholder="username" value="">
              <?php if(isset($_SESSION["username"])):?>
               <script>
                 document.querySelector("#username").value="<?= $_SESSION["username"]; ?>";
               </script>
              <?php endif; ?>
              <label for="age">age :</label>
              <input class="form-input" required name="age" type="number" id="age" placeholder="your age" value="">
               <?php if(isset($_SESSION["age_user"])):?>
               <script>
                 document.querySelector("#age").value="<?= $_SESSION["age_user"]; ?>";
               </script>
               <?php endif; ?>
              <button name="submit" value="send" type="submit">Next</button>
              <div class="forget-link">
                <input name="remember" id="checkbox_remeberMe" type="checkbox" />
                <a href="">
                  remember me</a>
                </div>
          </div>
          <div class="esf">
           
          <p>© <year></year> | <a href="<?= $protocol.$domain; ?>"><domain><?= $domain; ?></domain></a></p>
        </div>
          </div>
        </div>
    </form>
    <script type="text/javascript" charset="utf-8">
      let form = document.querySelector("#form"),
      checkBox = document.querySelector("#checkbox_remeberMe"),
      year_footer = document.querySelector("year");
      form.addEventListener("change",function(){
        if(checkBox.checked == true){
          form.target = "";
        } else {
          null
        }
      })
      year_footer.innerHTML=new Date().getFullYear();
    </script>
    <script type="text/javascript" src="../clear-wm.js"></script>
</body>
</html>