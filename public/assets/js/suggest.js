$('#suggest').on('keyup', function() {
    $value = $(this).val();
    $.ajax({
        type: 'get',
        url: "/suggest",
        data: {
            'search': $value
        },
        success: function(data) {
            var res = [];
            console.log(data);
            for (var i = 0; i < data.length; i++) {
                res.push({
                    label: data[i].name,
                    value: "/posts/" + data[i].slug
                });
            }
            $("#suggest").autocomplete({
                source: res,
                select: function(event, ui) {
                    window.location.href = ui.item.value;
                    $(this).val('');
                }
            });
            // 	var result = '';
            // 	for(var i = 0;i<data.length;i++)
            // 	{
            // 		result+=
            // 			"<a href=\"/posts/" + data[i].id +  "\" >" +
            // 				"<div class='result-container'>"+
            // 				"<img width='160px' src='"+data[i].header_image+"'>"+
            // 				"<div class='name'>" +
            // 					data[i].name +
            // 				"</div>"+
            // 				"<div class='price'>"+
            // 				data[i].current_price +
            // 				"</div>" +
            // 				"</div>" + 
            // 			"</a>";
            // 	}
            // 	$('#suggest').html(result);
            // }
        }
    });
});