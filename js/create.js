function gen_form(n)
{
	$("#datas").html("");
	for (var i = 0; i < n; i++)
	{
		var cont = $($("#data-block").html());
        cont.find('input[type=checkbox]').val(i);
		cont.children(".data-id").text(i+1);
		$("#datas").append(cont);
	}
}

gen_form(1);

$("#datanum").on('input', function() {
	if (n = Number($(this).val().match(/\d+/))) {
		gen_form(n);
	}
});

$("#type").change(function() {
	if ($(this).val() == 3)
		$(".debug-cha").show();
	else
		$(".debug-cha").hide();
});