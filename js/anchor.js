$('a[href^="#"]').click(function(){ // #1
let anchor = $(this).attr('href'); // #2
$('html, body').animate({ // #3
scrollTop: $(anchor).offset().top // #4
}, 600); // #5
});