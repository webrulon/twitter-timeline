<?php

$twitter_beautify_pattern = array(
        '/\s([A-Za-z0-9]*)\:\/\/([A-Za-z0-9]*)\.([A-Za-z0-9]*)\/([A-Za-z0-9]*)\s/',  // for urls
        '/\s#([A-Za-z0-9]*)\s/',
        '/\s@([A-Za-z0-9]*)\s/'
);

$twitter_beautify_replace  = array(
        '<a target="_blank" class="twitter-link" href="$1://$2.$3/$4">$1://$2.$3/$4</a>',
        '<a target="_blank" class="twitter-hash" href="https://twitter.com/search/?q=%23$1&src=hash">#$1</a>',
        '<a target="_blank" class="twitter-user" href="https://twitter.com/$1">@$1</a>'
);

function beautify_tweets( $tweets ){
    
    global $twitter_beautify_pattern, $twitter_beautify_replace;
    
    $beautified = array();

    foreach( (array)$tweets as $tweet ){
        $beautified[] = preg_replace($twitter_beautify_pattern, $twitter_beautify_replace, $tweet);
    }
    
    return $beautified;
}