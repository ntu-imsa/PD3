  $('#home-btn').click(function (){
         // $.ajax({
         // url: '',
         // cache: false,
         // dataType: 'html',
         //     type:'GET',
         // error: function(xhr) {
         //   alert('Ajax request 發生錯誤');
         // },
         // success: function(response) {
           $('.nav').children('.active').removeClass('active');
           $('#main-content').html("");
           $('#home-btn').addClass('active'); 
				   $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");				   
     //     }
     // });
  }); 

  $('#problem-btn').click(function (){
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
        console.log("problem");

		 $.ajax({
         url: 'problem.php',
         cache: false,
         dataType: 'html',
             type:'GET',
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('.nav').children('.active').removeClass('active');
                      $("#main-content").css("display","block");
                   $('#main-content').html(response);
                     $('#load').removeClass('loading');
                   $('#problem-btn').addClass('active'); 
				   $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
          }
      });
  }); 
  
 $(".hw-btn").click(function (){
        var hw_id=$(this).html();
		var id = $(this).attr("name");
        console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
         $.ajax({
         url: 'upload_ajax.php',
         cache: false,
         dataType: 'html',
             type:'POST',
         data:{ hwID: hw_id}, //可以在upload_ajax.php裡面用$_POST['hwID']接
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('.nav').children('.active').removeClass('active');
                   $("#main-content").css("display","block");
                   $('#main-content').html(response);
                   $('#load').removeClass('loading');
                   $('.hw-btn').parent().parent().addClass('active');
                   $('.hw-id').html(hw_id+"<input type='hidden' name='problem_num' value='"+id+"'>");
				   $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
         }
     });
  });
  
  $('.lab-btn').click(function (){
        var hw_id=$(this).html();
		var id = $(this).attr("name");
		console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none");
         $.ajax({
         url: 'upload_ajax.php',
         cache: false,
         dataType: 'html',
             type:'POST',
	     data:{ hwID: hw_id}, //可以在upload_ajax.php裡面用$_POST['hwID']接
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('.nav').children('.active').removeClass('active');
                   $("#main-content").css("display","block");
                   $('#main-content').html(response);
                   $('#load').removeClass('loading');
                   $('.lab-btn').parent().parent().addClass('active');
                   $('.hw-id').html(hw_id+"<input type='hidden' name='problem_num' value='"+id+"'>");
				   $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
         }
     });
  });

 $('#record-btn').click(function (){
        $('#load').addClass('loading');
        $("#main-content").css("display","none");
         $.ajax({
         url: 'record_ajax.php',
         cache: false,
         dataType: 'html',
             type:'GET',
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
           $('.nav').children('.active').removeClass('active');
				   $('#footer').html("");
           $("#main-content").css("display","block");
           $('#main-content').html(response);
           $('#load').removeClass('loading');
				   $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
           $('#record-btn').addClass('active');
                   
         }
     });
  });  
  
  $('#score-btn').click(function (){
    $('#load').addClass('loading');
    $("#main-content").css("display","none");
         $.ajax({
         url: 'score.php',
         cache: false,
         dataType: 'html',
             type:'GET',
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
            $('.nav').children('.active').removeClass('active');
				    $('#footer').html("");
            $("#main-content").css("display","block");
            $('#main-content').html(response);
            $('#load').removeClass('loading');
				    $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
            $('#score-btn').addClass('active');
                   
         }
     });
  });  