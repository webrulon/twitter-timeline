<?php
    /*
     * load the baseapp bootstrap
     */

    require_once 'init/bootloader.php';
    
    if( $twitter->is_unauthed() ){
        
        //he isnt verified
        $twitter->clear();
    }
    
    $profile = $twitter->connect();
    
    $theme->elem('header');
?>
<div class="page-header">
    <h2>Twitter Timeline</h2>
</div>

<div class="row-fluid">
    <div class="offset3 span6">
        <div><img src="<?php echo $profile->profile_image_url ?>">
        <div><?php echo $profile->name ?></div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6 offset3">
        <h3>Loading Latest 10 Tweets</h3>
        
        <?php $tweet = $twitter->get_tweet(10); ?>
        
        <?php foreach( $tweet as $t ): ?>
        <ol>
            <li>><?php echo $t->text ?></li>
        </ol>
        <?php endforeach; ?>
        
    </div>
</div>
<?php $theme->elem('footer'); ?>