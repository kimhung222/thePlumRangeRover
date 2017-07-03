$('#index_game').on('keyup', function() {
    $index_value = $(this).val();
    $.ajax({
        type: 'get',
        url: "/livesearch_index",
        data: {
            'search_index': $index_value
        },
        success: function(data) {
            if ($index_value === '') {
                $('#index-result').html('');
            } else {
                var result_index = '';
                for (var i = 0; i < data.length; i++) {
                    result_index +=
                        "<div class='index-result-container'>" +
                        "<img width='200px' src='" + data[i].header_image + "'>" +
                        "<div class='index-result-name'>" +
                        data[i].name +
                        "</div>" +
                        "<div class='index-result-buttons'>" +
                        "<input type='hidden' id='post-id' value='" + data[i].id + "'>" +
                        "<button class='btn btn-success' post_id='" + data[i].id + "' name='popular'>Nổi bật</button>" +
                        "<button class='btn btn-success' post_id='" + data[i].id + "' name='discount'>Khuyến mãi</button>" +
                        "<button class='btn btn-success' post_id='" + data[i].id + "' name='new'>Mới</button>" +
                        "</div>" +
                        "</div>";
                }
                $('#index-result').html(result_index);
            }
        }
    });
});