<?php
if(isset($_GET)){
  header("Location: ./icon/?newest=active");
  die();
}else{
  readfile("../404.php");
  die();
}
?>