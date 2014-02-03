$(".past-btn").click(function (){
    var past_id=$(this).html();
    var id = $(this).attr("name");
    console.log("problem_pdf.php");
    console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
         $.ajax({
         url: 'problem_pdf.php',
         cache: false,
         dataType: 'html',
             type:'POST',
         data:{ pastID: id}, //problem_pdf.php裡面用$_POST['pastID']接
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('.nav').children('.active').removeClass('active');
                   $("#main-content").css("display","block");
                   $('#main-content').html(response);
                   $('#load').removeClass('loading');
                   $('.past-btn').parent().parent().addClass('active');
                   //$('.past-id').html('PD'+past_id); 
           $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
         }
     });
  });

  $('.submit-past-btn').click(function (){
    var past_id=$(this).html();
    var id = $(this).attr("name");
    console.log("upload_past.php");
    console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none"); 
     $.ajax({
         url: 'upload_past.php',
         cache: false,
         dataType: 'html',
             type:'POST',
         data:{ pastID: id}, //problem_pdf.php裡面用$_POST['pastID']接
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
           $('.nav').children('.active').removeClass('active');
           $("#main-content").css("display","block");
           $('#main-content').html(response);
           $('#load').removeClass('loading');
           //$('#past-id').html('PD'+past_id); 
           $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
          }
      });
  }); 