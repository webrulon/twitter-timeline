var slideshow;

$(document).ready(function (){
    
    $('.user-tweet div').hide().is(':first-child').show();
    
    slideshow = setInterval(function(){
        $('.user-tweet div:first-child')
                .detach()
                .appendTo('.user-tweet');
        
        $('.user-tweet div')
                .hide()
                .is(':first-child')
                .show();
    },5000);
});

