<?php

require_once 'init/bootloader.php';
    
    if(  $twitter->is() ){
        header('location: ' . TWITTER_LANDPAGE);
        die();
    }
    
    $theme->elem('header');
    $theme->elem('hero-unit');
    $theme->elem('footer');
?>