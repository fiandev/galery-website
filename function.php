<?php
//require "./config.php";
function getRandomImg(){
  $host_url = $_SERVER["HTTP_HOST"];
  $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
  $imgs = array_diff(scandir("./admin-post/"), array('.', '..',"index.php"));
  $img = $imgs[rand(2,count($imgs))];
  if(pathinfo("./admin-post/$img", PATHINFO_EXTENSION) != "mp4" || pathinfo("./admin-post/$img", PATHINFO_EXTENSION) != "mkv" ){
  return $protocol.$host_url."/admin-post/".$img;
  }
}
function formating($text){
  $res1 = str_replace("&lt;*", "<b>", $text);
  $res2 = str_replace("*&gt;", "</b>", $res1);
  $res3 = str_replace("&lt;_", "<u>", $res2);
  $res4 = str_replace("_&gt;", "</u>", $res3);
  $res5 = str_replace("/-", "<i>", $res4);
  $res6 = str_replace("-/", "</i>", $res5);
  $res7 = str_replace("&lt;~", "<s>", $res6);
  $res8 = str_replace("~&gt;", "</s>", $res7);
  $res9 = str_replace("\n", "<br/>", $res8);
  /* clear b,i,s,u */
  /*
  $res10 = str_replace("&lt;b&gt;", "<b>", $res9);
  $res11 = str_replace("&lt;\/b&gt;", "</b>", $res10);
  $res12 = str_replace("&lt;s&gt;", "<s>", $res11);
  $res13 = str_replace("&lt;\/s&gt;", "</s>", $res12);
  $res14 = str_replace("&lt;u&gt;", "<u>", $res13);
  $res15 = str_replace("&lt;\/u&gt;", "</u>", $res14);
  $res16 = str_replace("&lt;i&gt;", "<i>", $res15);
  $res17 = str_replace("&lt;\/i&gt;", "</i>", $res16);
  */
  return $res9;
  }
function get_browser_name($user_agent){
    $t = strtolower($user_agent);
    $t = " " . $t;
    if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;   
    elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;   
    elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;   
    elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;   
    elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;   
    elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';
    return 'Unkown';
}

function my_json_encode($data){
  return json_encode($data,JSON_PRETTY_PRINT);
}
function api_json_encode($data){
  $res = json_encode($data,JSON_PRETTY_PRINT);
  return str_replace("\/","/",$res);
}
function Log_Visited($path = "."){
  date_default_timezone_set('Asia/Jakarta');
  $ip = $_SERVER["REMOTE_ADDR"];
  $domain = $_SERVER["HTTP_HOST"];
  $protocol = strtolower(str_replace("/1.1","",$_SERVER["SERVER_PROTOCOL"]));
  $path_request = $_SERVER["REQUEST_URI"];
  $url = $protocol."://".$domain.$path_request;
  $request_method = $_SERVER["REQUEST_METHOD"];
  if(isset($_GET)){
  $logJson = file_get_contents(__DIR__."/log.json");
  $logData = json_decode($logJson,true);
  $logData["user_ip"][count($logData["user_ip"])] = $ip;
  $logData["time_visited"][count($logData["time_visited"])] = date("M d, Y h:i:s A");
  $logData["path_visited"][count($logData["path_visited"])] = $url;
  $logData["method"][count($logData["method"])] = $request_method;
  $logDataEncode = json_encode($logData,JSON_PRETTY_PRINT);
  file_put_contents("$path/log.json",$logDataEncode);
 }
 /* end if */
}
function save_path(){
  $domain = $_SERVER["HTTP_HOST"];
  $protocol = strtolower(str_replace("/1.1","",$_SERVER["SERVER_PROTOCOL"]));
  $path_request = $_SERVER["REQUEST_URI"];
  $url = $protocol."://".$domain.$path_request;
  session_start();
  $_SESSION["path_save"] = $url;
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

function getOS($user_agent) { 
    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {
    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}

function getRandom_Number($each){
  $res = "";
  for ($i = 0; $i < $each; $i++) {
     $res = $res.rand(0,9);
  }
  return $res;
}
?>