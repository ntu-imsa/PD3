$(".upload-button").click(function (){
	console.log("upload");
	$('#fileUploadForm').ajaxSubmit({                 
        success: function(response) {
            $('#main-content').html(response);
		},
        error: function(xhr) {
			alert('Ajax request 發生錯誤');
		}                           
	 });
});
	
