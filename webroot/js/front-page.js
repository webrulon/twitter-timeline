$(document).ready(function (){
    
    //hide error message
    $('#ajax_responce div').hide();
    
    //init carousal
    $('#user-tweet .carousel-inner:first-child').addClass('active');
    $('#user-tweet').carousel();
    
    //load the input with typehead
    $('#screen_name').typeahead({
        updater: load_tweets
    });
});

function load_tweets( screen_name ){
    
    //hide error message
    $('#ajax_responce div')
            .hide();
    
    //query using ajax
    $.ajax('/ajax_tweet.php',{
        
        cache: false,
        
        data: {
            screen_name: screen_name
        },
        
        async: false,
        
        type: 'GET',
        
        dataType: 'json',
        
        success: insert_tweet_into_carousal,
        
        beforeSend: function(){
            $('#ajax_responce div')
                    .hide()
                    .has('.alert-info')
                    .show();
        },
        
        error: function (){
            $('#ajax_responce div')
                    .hide()
                    .has('.alert-error')
                    .show();
        }
    });
    
    //return so that the input can have its value
    return screen_name;
}

function insert_tweet_into_carousal( tweets ){
    
    alert("ready to enter in carousal");
    
    $('#ajax_responce div')
            .hide();

    $t = $('#user-tweet');
    $tin = $t.children('.carousel-inner');

    //stop and remove all tweets
    $t.carousel('pause');
    $tin.empty();

    $.each(tweets, function(i, tweet){
        $tin.append('<div class="item">' + tweet + '</div>');
    });

    //start the carousal
    $t.carousel('cycle');
}