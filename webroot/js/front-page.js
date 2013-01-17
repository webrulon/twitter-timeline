$(document).ready(function (){
    
    //hide error message
    $('#responce_err').hide();
    
    //init carousal
    $('#user-tweet .item').first().addClass('active');
    $('#user-tweet').carousel();
    
    //load the input with typehead
    $('#_user').typehead({
        updater: function(item){
            
            //query using ajax
            $.ajax('/ajax_tweet.php',{
                cache: false,
                data: {
                    'username': item
                },
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    
                    $('#responce_err').hide();
                    
                    $t = $('.user-tweet');
                    $tin = $t.children('.carousel-inner');
                    
                    //stop and remove all tweets
                    $t.carousel('pause');
                    $tin.children('.carousel-inner').empty();
                    
                    $.each(data, function(i, tw){
                        $tin.append('<li class="item">' + tw + '</li>');
                    });
                    
                    //start the carousal
                    $t.carousel('cycle');
                },
                error: function (){
                    $('#responce_err').hide();
                }
            });
        }
    });
});

