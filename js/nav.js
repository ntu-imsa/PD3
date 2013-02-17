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
     //     }
     // });
  }); 

  $('#problem-btn').click(function (){
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
                   $('#main-content').html(response);
                   $('#problem-btn').addClass('active');  
          }
      });
  }); 
  
 $(".hw-btn").click(function (){
        var hw_id=$(this).html();
		var id = $(this).attr("name");
        console.log(id);
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
                   $('#main-content').html(response);
                   $('.hw-btn').parent().parent().addClass('active');
                   $('.hw-id').html(hw_id+"<input type='hidden' name='problem_num' value='"+id+"'>");
         }
     });
  });
  
  $('.lab-btn').click(function (){
        var hw_id=$(this).html();
		var id = $(this).attr("name");
		console.log(id);
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
                   $('#main-content').html(response);
                   $('.lab-btn').parent().parent().addClass('active');
                   $('.hw-id').html(hw_id+"<input type='hidden' name='problem_num' value='"+id+"'>");
         }
     });
  });

 $('#record-btn').click(function (){
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
                   $('#main-content').html(response);
                   $('#record-btn').addClass('active');
                   
         }
     });
  });  