var slideshow;

$(document).ready(function (){
    
    $('.user-tweet p')
            .hide()
            .first()
            .show();
    
    slideshow = setInterval(function(){
        $('.user-tweet p:first-child')
                .detach()
                .appendTo('.user-tweet');
        
        $('.user-tweet p')
                .hide()
                .first()
                .show();
    },3000);
});

