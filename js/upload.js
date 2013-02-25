$(".upload-button").click(function (){
	var d = "<span class=\"spin\"></span>";

	$('#load').addClass('loading');
	$("#main-content").css("display","none");
	
	console.log("upload");
	$('#fileUploadForm').ajaxSubmit({                 
        success: function(response) {
           // $('#load').removeClass('loading');
            $("#main-content").css("display","block");
            $('#main-content').html(response);
            $('#load').removeClass('loading');
		},
        error: function(xhr) {
			alert('Ajax request 發生錯誤');
		}                           
	 });
});
	
