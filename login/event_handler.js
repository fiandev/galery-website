function show(elemen){
  $("nav a").removeClass("btn-nav_active");
  $(`form`).css("display","none");
 // $(`#${elemen}`).css("display","block");
  elemen.style.display="block";
 // alert("!")
}
const btnOnNav = document.querySelectorAll("nav a");
for (var i = 0; i <= btnOnNav.length; i++) {
  btnOnNav[i].addEventListener("click",function(){
    this.classList.add("btn-nav_active");
  })
 // btnOnNav[i].style.display="none"
}

function more_hastag(){
  let value = $(`#hastag_${cc}`).val();
  if(value != ""){
  cc++;
  //alert(cc)
  $("#hastag-label").attr("for",`hastag_${cc}`);
  $("#container-hastag").append(`<input class='form-control form-hastag my-1' onchange="apakah_null(this)" required name='hastag_${cc}' id='hastag_${cc}' value='#'/>`);
  $("#count-hastag").attr("value",cc);
  } else {
    alert("input null")
  }
  
}

function apakah_null(elem){
  if (elem.value == "") {
    elem.value="#";
  }
}
show("form_upload");