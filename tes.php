<?
if (isset($_GET["key"])) {
  if($_GET["key"] === "tes"){
    echo "succes";
  }
} else {
  header("Location: /");
}

?>