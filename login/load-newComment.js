function show_comment(argument) {
  $.getJSON("../DB.json",function(data){
  let banyak_komen = $("#notif").html();
  let allcomment = data.comment;
  let allcomment_length = allcomment.length;
  try {
    for (var i = 0; i <= allcomment_length; i++) {
      let comment = allcomment[i];
    $("#komen-c").append(`<p>${comment}</p>`);
    }
  } catch (e) {
    $("#komen-c").append(`<p>${e}</p>`);
  }
  
})
}