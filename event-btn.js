function likeAdminPost(self,name,i){
  $(self).toggleClass("bi-heart");
  $(self).toggleClass("bi-heart-fill");
  $(self).css("display","inline-block");
  $(self).css("position","relative");
  $(self).css("z-index","-1");
  $(self).css("transition",".2s");
  $(self).css("transform","translateX(-150%)");
  let self_ = $(self);
  setTimeout(() => {
  self_.css("display","inline");
  self_.css("position","static");
  self_.css("transform","scale(1,0)");
  self_.css("transform","translateX(0)");
    
  }, 500);
  let value;
  let pathfile = window.location.pathname;
  if (pathfile == "/") {
    pathfile = "/index.php";
  } else if(pathfile == "/search"){
    pathfile = "/search/index.php";
  }
  //alert(pathfile)
  if(!$(self).hasClass("hasbeen-like")){
    value = true;
  } else {
    value = false;
  }
    $(self).toggleClass("hasbeen-like");
    $.post(`${pathfile}`,
    {
      addLikePostAdmin: value,
      dir_name: name
    },
    function(data, status){
    //alert("Status: " + status + "\nData: " + data );
       $.getJSON(`${name}/data.json`,function(data){
         let like = data.like;
         //let el = $(`#countLike_${i}`).html();
         
         $(`#countLike_${i}`).html(like);
       })
    });
}
function showCommentField(name,idSection,isFromBtnReadmore, dom){
  var dir_address = name;
  //alert(dir_address)
  let placeholder_text,btn_text;
  if (userLang !== "id") {
    placeholder_text = "Insert comment";
    btn_text = "Send";
  } else {
    placeholder_text = "Masukan komentar";
    btn_text = "Kirim";
  }
  window.location.href="#";
  $("#content").append(`<div class="comment-field"><form class="form-send-comment" method="post" target=""><a href="#${idSection}"><i class="bi bi-arrow-return-left" onclick="hideCommentField()"></i></a><input name="comment" id="comment_input" type="text" placeholder="${placeholder_text} .." onkeyup="input_keyup()"><input type="hidden" name="dir" value="${dir_address}"><button class="disabled" name="sendCommentPost" type="submit" value="submit">${btn_text}</button></form><div class="comment-show"></div></div>`);
    $("#comment_input").on("input",function(){
    if(this.value===""){
      //this.value="Anonymous";
      //this.value=$(this).attr("ip-user");
      $(".form-send-comment button").addClass("disabled")
    } else {
      $(".form-send-comment button").removeClass("disabled")
      
    }
   })
   
   if (isFromBtnReadmore) {
     let desc = dom.data;
     let keterangan;
     if (userLang !== "id") {
       keterangan = "description";
     } else {
       keterangan = "deskripsi";
     }
     $(".comment-show").append(`<div class="container mx-3 my-2 clearfix"><div class="float-start comment-info"><b class="username">${authorName} (${keterangan})</b></div> <p class="float-end">${desc}</p></div><div class="division-desc"></div>`)
   }
  $.getJSON(`${dir_address}/data.json`,function(data) {
    let comments = data.comments;
    let flags = data.flags;
    let ip_ = data.ip;
    for (let i = 0; i < comments.length; i++) {
      let comment = comments[i];
      let flag = flags[i];
      let ip = ip_[i];
      $(".comment-show").append(`<div class="container container-comment mx-3 my-2 clearfix"><div class="float-start comment-info"><a href="./user/?id=${ip}"><b class="username">${ip}</b></a></div> <p class="float-end">${comment}</p></div>`)
    }
  })
  $(".footer").css("position","static");
}

function hideCommentField(){
  $(".comment-field").css("transform","translateX(-150%)");
  $(".footer").css("position","fixed");
  setTimeout(() => {
    $(".comment-field").remove();
  },1000)
}

function copy_text(self,text) {
   var copyText = document.createElement("input");
   copyText.value=text;
  document.body.appendChild(copyText);
  /* Select the text field */
  copyText.select();
  
  document.execCommand("copy");
  document.body.removeChild(copyText);
  let selfInner = self.innerHTML;
  self.innerHTML="copied ✅";
  setTimeout(function() {
    self.innerHTML=selfInner;
  }, 800);
}


function share_event(url){
  let elemToAppend = document.querySelector("#content");
  let msg = "I found interesting things on the internet,\nI can upload pictures and videos here,\ntry visiting the following link!\n\n";
  let element = `
  <div class="anu" onclick="clear_share_div(this)"></div>
  <div id="share_container" class="share-div">
  <div class="container">
  <h4 class="text-center">share to</h4>
  <ul>
  <li onclick="copy_text(this,'${url}')">copy link</li>
  <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=${encodeURI(url)}"><li>Facebook</li></a>
  <a target="_blank" href="whatsapp://send?text=${encodeURI(msg)}${encodeURI(url)}"><li>WhatsApp</li></a>
  <a target="_blank" href="http://twitter.com/share?text=${encodeURI(msg)}&url=${encodeURI(url)}&hashtags=website,Learningprogramming"><li>Twitter</li></a>
  <li onclick="more_share('${document.title}','${url}')">more...</li>
  </ul>
  </div>
  </div>
  `
  elemToAppend.insertAdjacentHTML("beforeend", element);
  setTimeout(function() {
  $("#share_container").css("transform","translateY(0)")
  }, 100);
  //alert(element)
}
function clear_share_div(self){
  $("#share_container").css("transform","translateY(150%)");
  setTimeout(function() {
  $("#share_container").remove();
  $(self).remove();
  }, 400);
}
function more_share(msg,url_){
  $("#share_container").remove();
  navigator.share({
  title: document.title,
  text: msg,
  url: url_,
});
}


