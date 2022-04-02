//function more(){
   /* var c = 0;
    c++;
      $("#submit").before(`<input class="form-control mb-1" type="file" name="file${c}" id="file${c}" value="" />`);
    */
    
       setInterval(() => {
          let el = document.getElementById(`file${c}`);
          let a = el.value;
        if(a!=""){
          $("#moreBtn").removeClass("disabled");
          }else{
           $("#moreBtn").addClass("disabled");
          // $("#trash").append("${c}");
          }
          
        },100)