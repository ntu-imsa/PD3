$(document).ready(function () {
  $('#record_btn').click(function (){
         $.ajax({
         url: 'record_ajax.php',
         cache: false,
         dataType: 'html',
             type:'GET',
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('#main-content').html(response);
                    $('#main-content').fadeIn();
         }
     });
  });
 $('#clean').click(function(){
    $('#msg').html("");
    // document.getElementById('msg').innerHTML = "";
 });

})