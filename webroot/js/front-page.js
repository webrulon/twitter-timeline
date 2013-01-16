var slideshow;

$(document).ready(function (){
    
    $('.user-tweet li').hide().is(':first-child').show();
    
    slideshow = setInterval(function(){
        $('.user-tweet li:first-child').remove().appendTo('.user-tweet');
        $('.user-tweet li').hide().is(':first-child').show();
    },1000);
});

