function showComment(date,msg,username,comment){
  $("#super-container-comment").append(`<div class="mx-1 mb-1 c-komentar border bordered py-1 px-2"><p class="tgl">${date} ${msg}</p><h6 class="d-inline-block">${username} : </h6> <p class="d-inline komentar">${comment}</p></div>`);
  }
}