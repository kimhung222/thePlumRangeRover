$('#livesearch').on('keyup', function() {
    $value = $(this).val();
    $.ajax({
        type: 'get',
        url: "/livesearch",
        data: {
            'search': $value
        },
        success: function(data) {
            if ($value === '') {
                $('#result').html('');
            } else {
                var result = '';
                for (var i = 0; i < data.length; i++) {
                    result +=
                        "<a href=\"/posts/" + data[i].id + "\" >" +
                        "<div class='result-container'>" +
                        "<img width='160px' src='" + data[i].header_image + "'>" +
                        "<div class='name'>" +
                        data[i].name +
                        "</div>" +
                        "<div class='price'>" +
                        data[i].current_price + ".000" +
                        "<span style='margin-left:30%'>" + data[i].card_price + ".000(CARD)"+
                        "</span>" +
                        "</div>" +
                        "</div>" +
                        "</a>";
                }
                $('#result').html(result);
            }
        }
    });
});