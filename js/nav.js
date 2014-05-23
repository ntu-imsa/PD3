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
        console.log("problem.php");

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

  $('#past-problem-btn').click(function (){
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
        console.log("past_problem.php");

     $.ajax({
         url: 'past_problem.php',
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
           $('#past-problem-btn').addClass('active'); 
           $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
          }
      });
  }); 
  
  $('#past-score-btn').click(function (){
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
        console.log("past_score.php");

     $.ajax({
         url: 'past_score.php',
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
           $('#past-score-btn').addClass('active'); 
           $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
          }
      });
  }); 

  $('#submit-past-btn').click(function (){
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
        console.log("upload_past.php");

     $.ajax({
         url: 'upload_past.php',
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
           $('#submit-past-btn').addClass('active'); 
           $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
          }
      });
  }); 

 $(".hw-btn").click(function (){
    var hw_id=$(this).html();
		var id = $(this).attr("name");
    console.log("upload_ajax.php");
    console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
         $.ajax({
         url: 'upload_ajax.php',
         cache: false,
         dataType: 'html',
             type:'POST',
         data:{ hwID: id}, //可以在upload_ajax.php裡面用$_POST['hwID']接
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('.nav').children('.active').removeClass('active');
                   $("#main-content").css("display","block");
                   $('#main-content').html(response);
                   $('#load').removeClass('loading');
                   $('.hw-btn').parent().parent().addClass('active');
                   $('.hw-id').html(hw_id+"<input type='hidden' name='problem_num' value='"+id+"'>"); //name='problem_num'
				   $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
         }
     });
  });
  
  $('.lab-btn').click(function (){
    var hw_id=$(this).html();
		var id = $(this).attr("name");
		console.log("upload_ajax.php");
    console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none");
         $.ajax({
         url: 'upload_ajax.php',
         cache: false,
         dataType: 'html',
             type:'POST',
	     data:{ hwID: id}, //可以在upload_ajax.php裡面用$_POST['hwID']接
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

  $('.project-btn').click(function (){
    var fun_name = $(this).attr("name");
    $('#load').addClass('loading');

    //console.log(fun_name); 
    $("#main-content").css("display","none");
    if (fun_name == "Submit"){
      console.log("project.php");
      $.ajax({
        url: 'project.php',
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
          $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
          $('#project-btn').addClass('active');
                   
        }
      });
    }
    else if (fun_name == "Ranking"){
      console.log("ranking.php");
      $.ajax({
        url: 'ranking.php',
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
          $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
          $('#project-btn').addClass('active');
                   
        }
      });

    }
  });  

 $('#record-btn').click(function (){
        $('#load').addClass('loading');
        $("#main-content").css("display","none");
        console.log("record_ajax.php");
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
    console.log("score.php");
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

 $('#users-btn').click(function (){
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
    console.log("student.php");

    $.ajax({
     url: 'TA/student.php',
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
       $('#users-btn').addClass('active'); 
       $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
     }
   });
  }); 

 $('#problemlist-btn').click(function (){
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
    console.log("problem_list.php");

    $.ajax({
     url: 'TA/problem_list.php',
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
       $('#problemlist-btn').addClass('active'); 
       $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
     }
   });
  }); 

 $(".createproblem-btn").click(function (){
        var hw_id=$(this).html();
    var id = $(this).attr("name"); //name="<?php echo $append.($max +1); ?>
        console.log("create_problem.php")
        console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
         $.ajax({
         url: 'TA/create_problem.php',
         cache: false,
         dataType: 'html',
             type:'POST',
         data:{ hwID: id}, //可以在create_problem.php裡面用$_POST['hwID']接
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('.nav').children('.active').removeClass('active');
                   $("#main-content").css("display","block");
                   $('#main-content').html(response);
                   $('#load').removeClass('loading');
                   $('.createproblem-btn').parent().parent().addClass('active');
                   $('.hw-id').html(hw_id+"<input type='hidden' name='problem_num' value='"+id+"'>"); //可以在create.php裡面用$_POST['problem_num']接?
           $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
         }
     });
  });

  $(".editproblem-btn").click(function (){
    var hw_id=$(this).html();
    var id = $(this).attr("name"); //name = "<?php echo $append.$fetch_p[0]; ?>"
    console.log("edit_problem.php")
    console.log(id);
    $('#load').addClass('loading');
    $("#main-content").css("display","none");  
         $.ajax({
         url: 'TA/edit_problem.php',
         cache: false,
         dataType: 'html',
             type:'POST',
         data:{ hwID: id}, //可以在edit_problem.php裡面用$_POST['hwID']接
         error: function(xhr) {
           alert('Ajax request 發生錯誤');
         },
         success: function(response) {
                   $('.nav').children('.active').removeClass('active');
                   $("#main-content").css("display","block");
                   $('#main-content').html(response);
                   $('#load').removeClass('loading');
                   $('.editproblem-btn').parent().parent().addClass('active');
                   $('.hw-id').html(id+"<input type='hidden' name='problem_num' value='"+id+"'>");//可以在edit.php裡面用$_POST['problem_num']接?
           $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
         }
     });
  });
  $("#chg-pass-btn").click(function() {
    console.log("change_password.php");
    $('#load').addClass('loading');
    $("#main-content").css("display", "none");
    $.ajax({
      url: 'change_password.php',
      cache: false,
      dataType: 'html',
      error: function(xhr) {
        alert('Ajax request 發生錯誤');
      },
      success: function(response) {
        $('.nav').children('.active').removeClass('active');
        $("#main-content").css("display","block");
        $('#main-content').html(response);
        $('#load').removeClass('loading');
        $('#footer').html("<div class='container'><p class='muted credit'>© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p></div>");
        $('#send-pass-btn').click(function() {
          var data = $("#chg-pass").serialize();
          $("#chg-pass")[0].reset();
          $.post("change_password.php", data, function(res) {
            console.log(res); 
            if (res == "success")
            {
              alert('密碼修改成功!');
              window.location = 'index.php';
            }
            else
              $("#msg").text(res);
          });
        });
      }
    }); 
  });
