"use strict";

/* this variable are made so that each time jquery search is not preformed */
/* input screen_name element */
var $inpsn = null;
/* #user-tweet */
var $ut = null;
/* #user-tweet inner */
var $utin = null;
/* ajax responce children */
var $ajrpc = null;
/* download as pdf tweet btn */
var $dpdf = null;

var last_screen_name = null;

$(document).ready(function (){
    
    $inpsn = $('#screen-name');
    $ut = $('#user-tweet');
    $utin = $ut.children(".carousel-inner");
    $ajrpc = $('#ajax-responce div');
    $dpdf = $('#download-pdf');
    
    //init the screen_name input
    $inpsn.typeahead({
        source: $inpsn.data("source"),
        updater: load_tweets
    });
    
    //hide error message
    $ajrpc.hide();
    
    //init carousal
    $utin.children().first().addClass('active');
    $ut.carousel();
    
    $("body").on( 'click', '.twitter-user', function(event){
        event.preventDefault();
        event.stopPropagation();
        
        screen_name = $(this).text().substring(1);
        load_tweets( screen_name );
        
    });
});

function load_tweets( screen_name ){
    
    //query using ajax
    $.ajax('/ajax_tweet.php',{
        
        cache: false,
        data: { screen_name: screen_name },
        async: false,
        type: 'GET',       
        dataType: 'json',
        success: insert_tweet_into_carousal,
        
        beforeSend: function(){
            
            $inpsn.prop('disabled', true);
            
            $ajrpc.hide().filter('.alert-info').show();
            
            last_screen_name = screen_name;
        },
            
        complete: function(){
    
            $inpsn.prop('disabled', false);
        },
            
        error: function (){
            $ajrpc.hide().filter('.alert-error').show();
        }
    });
    
    //return so that the input can have its value
    return screen_name;
}

function insert_tweet_into_carousal( tweets ){
    
    $ajrpc.hide();
    
    if( typeof tweets.error !== 'undefined' ){
        //the server faced an error
        $ajrpc.filter('.alert-error').show();
        
        return;
    }

    //stop and remove all tweets
    $ut.carousel('pause');
    $utin.empty();

    $.each(tweets, function(i, tweet){
        $utin.append('<div class="item">' + tweet + '</div>');
    });

    $utin.children().first().addClass('active');
    //start the carousal
    $ut.carousel('cycle');
    
    //change screen_name
    $dpdf[0].search = '?screen_name=' + last_screen_name;
}