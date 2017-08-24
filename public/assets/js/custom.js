$(window).bind('scroll', function() {
    if ($(window).scrollTop() > 240) {
        $('#sidebar').addClass('navbar-default');
        $('#sidebar').addClass('navbar-fixed-top');
        $('#result').css({
            'position': 'fixed',
            'top': '73px'
        });
    } else {
        $('#sidebar').removeClass('navbar-default');
        $('#sidebar').removeClass('navbar-fixed-top');
        $('#result').css({
            'position': 'absolute',
            'top': '55px'
        });
    }
});

// $('.col-item').on('click',function(e){
//
//     e.preventDefault();
//     e.stopPropagation();
// });