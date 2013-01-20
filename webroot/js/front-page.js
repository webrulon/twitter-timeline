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

$(document).ready(function (){
    
    $inpsn = $('#screen_name');
    $ut = $('#user-tweet');
    $utin = $ut.children(".carousel-inner");
    $ajrpc = $('#ajax_responce div');
    
    //hide error message
    $ajrpc.hide();
    
    //init carousal
    $utin.children().first().addClass('active');
    $ut.carousel();
    
    //load the input with typehead
    $inpsn.typeahead({
        updater: load_tweets
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
            
            console.log("loading tweets");
            
            $ajrpc.hide().has('.alert-info').show();
        },
            
        complete: function(){
    
            $inpsn.prop('disabled', false);
        },
            
        error: function (){
            $ajrpc.hide().has('.alert-error').show();
        }
    });
    
    //return so that the input can have its value
    return screen_name;
}

function insert_tweet_into_carousal( tweets ){
    
    console.log("tweets received , inserting to carousal");
    
    $ajrpc.hide();

    //stop and remove all tweets
    $ut.carousel('pause');
    $utin.empty();

    $.each(tweets, function(i, tweet){
        $utin.append('<div class="item">' + tweet + '</div>');
    });

    //start the carousal
    $ut.carousel('cycle');
}