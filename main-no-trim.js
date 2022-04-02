function openTab(thisbtn, TabIndex) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("postingan");
  for (i = 0; i < tabcontent.length; i++) {
   tabcontent[i].style.display = "none";
    tabcontent[i].style.height = "0";
    tabcontent[i].style.opacity = "0";
    //$(".postingan *").css("display","none");
  }
  tablinks = document.getElementsByClassName("tab");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace("tab-active", "");
  }
  document.getElementById(TabIndex).style.display = "block";
  document.getElementById(TabIndex).style.height = "auto";
  if(TabIndex == "tab1"){
    render_loader(".main-post");
      document.getElementById(TabIndex).style.opacity = "1";
      $(".main-post a").css("opacity","0");
    setTimeout(() => {
      $(".main-post a").css("opacity","1");
    },800)
  } else {
    setTimeout(() => {
        document.getElementById(TabIndex).style.opacity = "1";
    },100)
  }
  document.getElementById(`${thisbtn}`).classList.add("tab-active")
 // evt.currentTarget.className += " active";
  //this.className += " active"
}

function addPost(){
  var items = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40];
  var i = 1;
  $("#countPosts").html(items.length);
  var x = setInterval(() => {
  if(i < items.length){
  $(".main-post").append(`<img src="./img/nime${items[i]}.jpg"/>`)
  i++;
  
  items[i];
  }else{
    clearInterval(x);
    $(".spin").remove();
    $(".main-post img").css("transform","translateY(0)");
    $(".main-post img").css("opacity","1")
    
  }
  },100)
}
function navShow(){
  //$("nav").css("transform","translateY(0)");
  $("nav").css("max-height","100%");
  $("body").append(`<div style="height:100vh;" onclick="navHide()" class="anu"></div>`);
  $(document).on("scroll",function(){
    navHide();
  })
}
function navHide(){
  //$("nav").css("transform","translateY(-200%)");
  $("nav").css("max-height","0");
  $(".anu").remove();
}
function addLike(){
  let newLike = parseInt($("#countLikes").attr("data-real"));
  let result = newLike+1;
  $("#countLikes").html(result);
 // $("#dislike").attr("value",`${dislike}`);
  $("#like").attr("name",`like`);
  //$("#countLikes").html(`${result}`);
}
function addDislike(){
  let newDislike = parseInt($("#countDislikes").attr("data-real"));
  let result = newDislike+1;
  $("#countDislikes").html(result);
  //addPoste").attr("value",`${like}`);
  $("#dislike").attr("name",`dislike`);
  //$("#countLikes").html(`${result}`);
}
//addPost()
$(".main-post").css("display","block");
  $
$(".main-post img").ready(function(){
  
  $(".main-post img").css("transform","translateY(0)");
  setTimeout(() => {
  $(".spin").remove();
  $(".main-post img,.post-value,.post-video").css("opacity","1");
  },1000)
})
/*
$("img").on("click",function(){
 window.location.href=this.src;
})
*/
function getCaptha(how){
  let str = "";
  let items = [0,1,2,3,4,5,6,7,8,9,"a","b","z","c","x","y","d","e","f","g","h","i","j","k","l","m","n","o","q","r","s","t","u","v","w"];
  for (var i = 0; i < how; i++) {
    let capthaCode = items[Math.floor(Math.random() * items.length)];
    str += ""+capthaCode;
  }
  return str
}

var cd = 30;
var capthaCode = getCaptha(4);
$("#capthaCode").attr("value",`captcha : ${capthaCode}`);
$("#captha").attr("placeholder",`${capthaCode}`);
$("#cd").attr("value",`${cd}s`);
$("#cd").addClass("blink");
function delete_captcha(){
$("#capthaCode").attr("value","-");
$("#captha").attr("placeholder","captcha disabled");
$("#cd").attr("value","off");
}
var startCaptcha = setInterval(() => {
  if(cd==0){
  cd = 30;
  updateCaptha();
   }else{
     $("#capthaCode").attr("value",`captcha : ${capthaCode}`);
     $("#captha").attr("placeholder",`${capthaCode}`);
     $("#cd").attr("value",`${cd}s`);
    cd--;
  }
},1000)
function updateCaptha(){
  capthaCode = getCaptha(4);
  $("#capthaCode").attr("value",`captcha : ${capthaCode}`);
  $("#captha").attr("placeholder",`${capthaCode}`);
  $("#cd").attr("value",`${cd}s`);
}
$("#username").on("click",function(){
  this.value="";
  this.required=true;
})
function startDisable_button(){
var x = setInterval(() => {
  let capthaValue = document.getElementById("captha").value.toLowerCase();
  if(capthaValue!=capthaCode){
    $(".btn-comment").addClass("disabled");
  }else{
    $(".btn-comment").removeClass("disabled");
    //clearInterval(x);
  }
  },100)
}
  /* no resubmitwn form */
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
let username = document.getElementById("username");
  $(".btn-comment").on("click",function(){
    if(username.value=="Ryuu13"){
        username.value="Admin";
      }
  })
var autoRefreshComment = setInterval(() => {
  let default_total_komentar = $("#total-comment").attr("total-comment");
  $.getJSON("./comment.json",function(data){
  let comments = data.comment.reverse();
  let total_komentar = data.total_comment;
 // alert(total_komentar)
  let tgl = data.dateComment[total_komentar];
  let username = data.username_comment[total_komentar];
  let comment = data.comment[total_komentar];
  //$("#total-comment").attr("total-comment",total_komentar);
  //$("#total-comment").html(total_komentar);
   console.log(username+"\n"+ data.username_comment[total_komentar])
   //$("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${tgl} New</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
  })
},1500)
/*
  var counter = 0;
 $(".btn-list").on("click",function(){
  if(counter < 1){
     $(".list-menu").css("max-height","100%");
     counter++;
  }else{
    $(".list-menu").css("max-height","0");
    counter--;
  }
 })
 */
 //console.log(comments)
 
  
 $(".btn-list").addClass("maxHeight");
 $(".btn-list").addClass("opacity-0");
 $(".btn-list").addClass("d-none");
 let innernya = document.querySelector(".btn-list-click").innerHTML;
 if (innernya == "login") {
   document.querySelector(".btn-list-click").style.backgroundColor="orange";
 }
 $(".btn-list-click").on("click",function(){
  //$(this).find(".list-menu").toggleClass("maxHeight");

  let this_dom = $(this);
  //$(".list-menu").addClass("maxHeight");
  //$(".btn-list-click").addClass("d-none");
  //$(".btn-list-click").addClass("opacity-0");
  

 //$(this).css("transition","1s");
  //$(".btn-list-click").addClass("opacity-0");
  //$(this).toggleClass("d-none");
  //$(this).toggleClass("opacity-0");
  //$(this).find(".list-menu").toggleClass("maxHeight");

  $(this).next().css("transition","1s");
  //$(".btn-list-click").addClass("opacity-0");
  $(this).next().toggleClass("d-none");
  $(this).next().toggleClass("opacity-0");
  $(this).next().toggleClass("maxHeight");
  $(this).next().toggleClass("mh-0");
  $(this).next().css("background-color","");
  //$(this).next().find(".list-menu").toggleClass("maxHeight");
  setTimeout(() => {
    /*
    $(`${this_dom}`).on("click",function () {
      this.next().find(".list-menu").addClasss("maxHeight");
      this.next().addClass("d-none");
      this.next().addClass("opacity-0");
    */
    },100)
    /*
    this_dom.next().toggleClass("mh-0");
    this_dom.next().toggleClass("opacity-0");
    */
  })
 /*
  //coba load menggunakan PHP request get
  $(".container").load("tes.php?key=tes")
  */
 $(document).ready(function(){
   //$("nav").append(`<img src="/res/logo-language.png" class="img-fluid"/>`);
  $("#likebtn").on("click",function(){
    $(this).css("font-size","20px");
    let this_dom = $(this);
    setTimeout(() => {
      this_dom.css("font-size","16px");
    },1000)
  });
  $("#dislikebtn").on("click",function(){
    $(this).css("font-size","20px");
    let this_dom = $(this);
    setTimeout(() => {
      this_dom.css("font-size","16px");
    },1000)
  });
  $(".rounded-circle").on("click",function(){
    window.location.href=this.src;
  })
  /*
  $(".bi-house").append(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg>`);
  $(".bi-three-dots").append(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16"><path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>`);
  */
 document.getElementById("sendComment").onclick = function(){
   clearInterval(autoRefreshComment);
    window.location.reload();
  }
  $("body").toggleClass("bg-secondary");
  $("*:not(body,.btn-list-click,.btn-list,.list-menu,nav,nav *)").toggleClass("bg-light");
  document.getElementsByClassName("btn-list")[0].style.backgroundColor="#9f5300";
 })
  $("#countLikes").on("click",function(){
    //$(this).css("position","relative");
    $(this).css("border","solid 1px");
    //let a = $(this);
    let a = $(this).attr("data-real");
    let b = $(this).attr("data-no-real");
    $(this).html(a);
    
    //$(this).html(`${c}`);
    //alert(this.real);
    setTimeout(() => {
      $(this).css("border","solid 0px");
      $("#countLikes").html(b);
    },1000)
  })
  
  $("#countDislikes").on("click",function(){
    //$(this).css("position","relative");
    $(this).css("border","solid 1px");
    //let a = $(this);
    let a = $(this).attr("data-real");
    let b = $(this).attr("data-no-real");
    $(this).html(a);
    
    //$(this).html(`${c}`);
    //alert(this.real);
    setTimeout(() => {
      $(this).css("border","solid 0px");
      $("#countDislikes").html(b);
    },1000)
  })
  
  /* dark theme */
  
  switchLink();
  
 /// changeTheme(false);
function changeTheme(IsDark){
if(IsDark){
  $("body,svg").addClass("bg-dark");
  $("*:not(body,.btn-list-click,.btn-list,.list-menu,nav,.komentar-admin,.switch *,.switch,.list-menu i,.hasbeen-like *)").addClass("bg-dark");
  $("*:not(body.btn-list-click,.btn-list,.list-menu,nav,.active,a,.c-komentar *,.list-menu i,.hasbeen-like *)").addClass("text-light");
  document.getElementById("theme_switcher").checked = true;
  Cookies.set("theme","dark");
}else{
  $("body,svg").removeClass("bg-dark");
  $("*:not(body,.btn-list-click,.btn-list,.list-menu,nav,.komentar-admin,.switch *,.switch)").removeClass("bg-dark");
  $("*:not(body.btn-list-click,.btn-list,.list-menu,nav,.active,a,.komentar-admin,.c-komentar *)").removeClass("text-light");
  document.getElementById("theme_switcher").checked = false;
  Cookies.set("theme","light");
}
}

    
    
    /* btnAboutFormat */
    let cntr = 0;
  $("#btnAboutFormat").on("click",function() {
    if(cntr === 1){
      $(".list-aboutFormat").remove();
      cntr = 0;
    }else{
      render_loader(".aboutFormat");
      setTimeout(() => {
        $(".aboutFormat").append(`<ul class="list-aboutFormat mx-0 my-0 py-0"><li><*...*> : <b class="btn my-2 btn-success" onclick="formatShow(this)">bold</b></li><li><~...~> : <s class="btn my-2 btn-warning" onclick="formatShow(this)">srink</s></li><li><_..._> : <u class="btn my-2 btn-info" onclick="formatShow(this)">underline</u></li><li>/-...-/ : <i class="btn my-2 btn-primary" onclick="formatShow(this)">italic</i></li></ul>`);
          $(".list-aboutFormat").css("opacity",0);
          setTimeout(() => {
        $(".list-aboutFormat").css("opacity",1);
      },500)
      },800)
      cntr++;
    }
    //this.next().css("opacity","0");
 })
 
 function render_loader(dom){
  let  IsDark = Cookies.get("theme");
    //alert(IsDark);
  if (IsDark === "dark") {
    $(dom).append(`<div id="preload_element" class="spin bg-dark"><div class="spinner"></div></div>`);
  } else if(IsDark === "light") {
    $(dom).append(`<div id="preload_element" class="spin bg-light"><div class="spinner"></div></div>`);
  } else {
    $(dom).append(`<div id="preload_element" class="spin bg-light"><div class="spinner"></div></div>`);
  }
   setTimeout(() => {
     $("#preload_element").remove();
   },800)
 }
 
 $("#username").on("input",function(){
  if(this.value===""){
    //this.value="Anonymous";
    this.value=$(this).attr("ip-user");
  }
 })
 
 /* auto refresh visit */
 setInterval(() => {
   $.getJSON("like-dislike.json",function(data){
     $(".visit").html(data.visited);
   })
 },100)
 
 
 /* 
 // auto visitd :v
setInterval(() => {
  $.ajax({
  url: "http://localhost:8080/id.php/",
  context: document.body
}).done(function() {
  $( this ).addClass( "done" );
});
},1000)
*/
/* switch link */
function switchLink(){
let _a = document.querySelectorAll(".c-komentar a");
for (var i = 0; i < _a.length; i++) {
  let elem = _a[i];
  let el_href = elem.href;
  elem.href=`?url=${el_href}`;
}
}
function limit_comment(special){
let _komen = document.querySelectorAll(".c-komentar .komentar");
for (var i = 0; i < _komen.length; i++) {
  let this_komen = _komen[i];
  let komen = this_komen.innerHTML;
  if (komen.length > 30) {
    this_komen.innerHTML = komen.slice(0,30);
    let readmore = document.createElement("span");
    readmore.style.fontWeight="bold";
    readmore.innerHTML="..readmore";
    this_komen.appendChild(readmore);
    this_komen.addEventListener("click",function(){
      this_komen.innerHTML=komen;
      /*setTimeout(()=>{
        limit_comment(i);
      },5000)*/
    })
  }
}
}
//$(".c_comment").css("display","none");
/* if kebanyakan comment */
/*
let c_comment = document.querySelectorAll(".c-komentar");
let maxComment = 3;
if(c_comment.length >= maxComment){
  for (var i = 0; i >= maxComment; i++) {
  let this_c = c_comment[i];
  this_c.style.display="block";
}
}
*/
//$(".komentar-admin").removeClass("bg-dark");
// remove watermark
/*
  $(document).ready(function(){      
    $('body').find('img[src$="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]').remove();
   });
   */
    document.addEventListener("load",function(){
      document.querySelector("body").find('img[src$="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]').remove();
    })
   
   /* fitur - fitur */
   $("#theme_switcher").on("click",function(){
    let isChecked = document.getElementById("theme_switcher").checked;
   // alert (isChecked)
     //jika sudah terceklis
//alert($(this).find("input").attr("id"))
     if(!isChecked) {
      // $("#theme_switcher").attr("checked",false);
      // alert(this_id)
       changeTheme(false);
       //changeTheme(true);
     }else{
       changeTheme(true);
     }
   })
   //Cookies.set("typed","on"
   //alert(Cookies.get("typed"))
   if(Cookies.get("typed") == "off"){
     document.getElementById("typed_switcher").checked = false;
     //$("#typed_switcher").attr("checked",false);
     setTimeout(() => {
       $(".nickname").css("display","none");
     },2000)
   }else{
     //$("#typed_switcher").attr("checked",true);
     document.getElementById("typed_switcher").checked = true;
     setTimeout(() => {
       $(".nickname").css("display","inline-block");
     },2000)
   }
    $("#typed_switcher").on("click",function(){
    let isChecked = document.getElementById("typed_switcher").checked;
    //alert (isChecked)
     //jika sudah terceklis
//alert($(this).find("input").attr("id"))
     if(!isChecked) {
      // $("#theme_switcher").attr("checked",false);
      // alert(this_id)
       $(".nickname").css("display","none");
       Cookies.set("typed","off")
      // $(".nickname2").removeClass("nickname");
       //$(".nickname").remove();
       //changeTheme(true);
     }else{
       $(".nickname").css("display","inline-block");
       Cookies.set("typed","on")
     }
   })
   
   if (Cookies.get("verify") == "off") {
     document.getElementById("captcha_switcher").checked = false;
     clearInterval(startCaptcha);
     delete_captcha();
   }else{
     document.getElementById("captcha_switcher").checked = true;
     startDisable_button();
   }
    $("#captcha_switcher").on("click",function(){
    let isChecked = document.getElementById("captcha_switcher").checked;
    
     //jika sudah terceklis
//alert($(this).find("input").attr("id"))
     if(!isChecked) {
      // $("#theme_switcher").attr("checked",false);
      // alert(this_id)
       Cookies.set("verify","off");
       document.location.reload();
       //changeTheme(true);
     }else{
       Cookies.set("verify","on");
       document.location.reload();
       //startDisable_button();
     }
   })
   
 function restore_comment(){
   let _komen = document.querySelectorAll(".c-komentar .komentar");
       for (var i = 0; i < _komen.length; i++) {
         let this_komen = _komen[i];
         $(this_komen).html($(this_komen).attr("full-data"));
       }
 }
 if(Cookies.get("limit_comment") == "no"){
   restore_comment();
   document.getElementById("readmore_switcher").checked = false;
 }else{
   limit_comment();
   document.getElementById("readmore_switcher").checked = true;
 }
  $("#readmore_switcher").on("click",function(){
    let isChecked = document.getElementById("readmore_switcher").checked;
     //jika sudah terceklis
//alert($(this).find("input").attr("id"))
     if(!isChecked) {
      // $("#theme_switcher").attr("checked",false);
      // alert(this_id
      
       //changeTheme(true);
       restore_comment();
       Cookies.set("limit_comment","no");
       document.location.reload();
       
     }else{
       limit_comment();
       Cookies.set("limit_comment","yes");
       document.location.reload();
     }
   })
 /* dark theme controller */
  if(Cookies.get("theme") === "dark"){
    changeTheme(true)
  }else{
    changeTheme(false)
  }
  $(document).ready(function(){      
   $('body').find('img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]').remove();
   });
   
   function formatShow(element){
     let commentField = document.querySelector("#comment");
     let inner = element.innerHTML;
     switch (inner) {
       case 'bold':
         commentField.value+="<*...*>";
         break;
       case 'italic':
         commentField.value+="/-...-/";
         break;
       case 'underline':
         commentField.value+="<_..._>";
         break;
       case 'srink':
         commentField.value+="<~...~>";
         break;
       
       
       default:
         // code
     }
   }
   
   
   let iconsFitur = document.querySelectorAll(".list-menu i");
   for (var i = 0; i < iconsFitur.length; i++) {
     iconsFitur[i].style.color=warnai();
   }
   
   function warnai(){
    var randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
    return randomColor
}

/*
function showFormComment(){
  $("#tab2 form").toggleClass("hide");
  //$("#tab2 form").css("height","auto");
}
*/
