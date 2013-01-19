$(document).ready(function (){
    
    //hide error message
    $('#responce_err').hide();
    
    //init carousal
    $('#user-tweet .item').first().addClass('active');
    $('#user-tweet').carousel();
    
    //load the input with typehead
    $('#_user').typeahead({
        updater: load_tweets
    });
});

function load_tweets(item){
    //query using ajax
    $.ajax('/ajax_tweet.php',{
        cache: false,
        data: {
            'username': item
        },

        type: 'GET',
        
        dataType: 'json',
        
        success: inert_tweet_into_carousal,
        error: function (){
            $('#responce_err').hide();
        }
    });

    return item;
}

function inert_tweet_into_carousal(data){
    
    alert("ready to enter in carousal");
    
    $('#responce_err').hide();

    $t = $('#user-tweet');
    $tin = $t.children('.carousel-inner');

    //stop and remove all tweets
    $t.carousel('pause');
    $tin.empty();

    $.each(data, function(i, tw){
        $tin.append('<div class="item">' + tw + '</div>');
    });

    //start the carousal
    $t.carousel('cycle');
}