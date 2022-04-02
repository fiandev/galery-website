  <?php
function whoAreYou(){
  // "Who are You?";
  readfile("./whoAreYou.php");
}
function dashboard($path,$authorName,$icon){
return "
    <!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <title>Welcome admin</title>
    <link href='../static/icon/?newest=active' rel='shortcut icon'>
    <link href='".$path."/framework/bootstrap.min.css' rel='stylesheet' integrity='sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We' crossorigin='anonymous'>
    <script src='".$path."/framework/bootstrap.bundle.min.js' integrity='sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj' crossorigin='anonymous'></script>
    <link href='../style.css' rel='stylesheet'>
    <style type='text/css' media='all'>
            .alert {
                transition: 1s;
                transform: translateY(-200%);
            }
         body {
            background-image: url(../bg.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
        }
        .title {
            text-shadow: 3px 3px 0px #000;
        }
        #container_rename_author {
          display: none;
        }
        nav a {
          display: block;
        }
        </style>
    </head>
    <body>
    <div class='container'>
     <div class='row'>
      <div class='col'>
        <nav class=''>
          <img class='rounded-circle mb-2 border bordered' src='".$icon."' alt='' />
           <a onclick='show(".'container_rename_author'.")' href='#rename_author'><div class='mx-1 my-1 py-2 px-1 btn-list-click'>Rename Author</div></a>
          <a onclick='show(".'form_upload'.")' href='#form_upload' class='btn-nav_active'><div  class='mx-1 my-1 py-2 px-1 btn-list-click'>upload</div></a>
        </nav>
        <div class='nav-top clearfix'>
          <p class='dropdown-toggle' onclick='navShow()'>". $authorName."</p>
         </div>
      </div>
      <div>
      <form class='form-control' id='form_upload' action='' method='post' accept-charset='utf-8' enctype='multipart/form-data'>
      <input class='form-control mb-1' type='file' name='file0' id='take-picture' value='' required/>
      <p class='text-muted' style='display:none' id='preview-text'>preview :</p>
      <img id='show-picture' width='100px' height='100px' style='display:none' />
      <label for='title' class='my-1'>Judul Postingan:</label>
      <input class='form-control' required name='title' id='title' value=''/>
      <label for='description' class='my-1'>Deskripsi Postingan :</label>
      <textarea class='form-control mb-1' type='text' id='description' name='description' value='' required> </textarea>
      <label id='hastag-label' for='hastag_0' class='my-1 d-block'>Hastag :</label>
      <div class='clearfix'>
      <div id='container-hastag' class='float-start' style='width:70%;'>
      <input onchange='apakah_null(this)' class='form-control form-hastag' required name='hastag_0' id='hastag_0' value='#'/>
      </div>
      <script>
      var cc = 0;
      </script>
      <button type='button' onclick='more_hastag()' style='width:5em;' class='float-end btn btn-outline-primary justify-center'>more..</button>
      </div>
      <input type='hidden' name='count_hastag' id='count-hastag' value='1' />
      <input class='btn btn-outline-primary my-2' type='submit' name='send' id='submit' value='submit' />
    </form>
      </div>
     </div>
     <div class='row'>
      <div class='col'>
      <form class='form-control' action='' method='post' accept-charset='utf-8' id='container_rename_author'>
      <label for='newName' class='my-1'>Masukan Nama baru :</label>
      <input class='form-control' required name='newNameAuthor' id='newName' value='".$authorName."'/>
      <label for='description' class='my-1'>Masukan kata sandi :</label>
      <input class='form-control mb-1' type='text' id='description' name='verify_password' value='' required />
      <input class='btn btn-outline-primary my-2' type='submit' name='sendNewNameAuthor' value='submit' />
    </form>
      </div>
     </div>
     <div class='row'>
       <a href='./handle-comment.php?commit=read'><p>You have : <b id='notif'></b> new comment !</p></a>
      <div class='col clearfix'>
       <a class='btn btn-success my-1' href='./handle-comment.php?commit=read'>cek komentar</a>
      <a class='btn btn-primary my-1' href='./statistic/'>statistic</a>
      <a class='btn btn-danger my-1' href='./handle-adminPost.php'>Admin Post</a>
      <a class='btn btn-danger my-1' href='./handle-userPost.php'>User Post</a>
       </div>
     </div>
    </div>
    <script src='".$path."framework/jquery-3.6.0.min.js' integrity='sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=' crossorigin='anonymous'></script>
    <script src='".$path."framework/js.cookie.min.js' crossorigin='anonymous'></script>
    <script src='img-preview.js'></script>
    <script src='".$path."main-no-trim.js' crossorigin='anonymous'></script>
    <script src='".$path."login/event_handler.js' crossorigin='anonymous'></script>
    <script type='text/javascript'>
    changeTheme(Cookies.get('theme'))
    function changeTheme(IsDark){
if(IsDark == 'dark'){
  $('body,svg').addClass('bg-dark');
  $('*:not(body,.btn-list-click,.btn-list,.list-menu,nav,.komentar-admin,.switch *,.switch)').addClass('bg-dark');
  $('*:not(body.btn-list-click,.btn-list,.list-menu,nav,.active,a,.c-komentar *)').addClass('text-light');
}else{
  $('body,svg').removeClass('bg-dark');
  $('*:not(body,.btn-list-click,.btn-list,.list-menu,nav,.komentar-admin,.switch *,.switch)').removeClass('bg-dark');
  $('*:not(body.btn-list-click,.btn-list,.list-menu,nav,.active,a,.komentar-admin,.c-komentar *)').removeClass('text-light');
}
}
    </script>
    <script type='text/javascript' src='../clear-wm.js'></script>
    <!--
      <script src='//cdn.jsdelivr.net/npm/eruda'></script>
  <script>eruda.init();</script>
  -->
    </body>
    </html>";
}
  ?>