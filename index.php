<?php
    /*
     * load the baseapp bootstrap
     */

    require_once 'init/bootloader.php';
    
    if( ! $twitter->is() ){
        
        //he isnt verified
        $twitter->clear();
    }
    
    $profile = $twitter->connect();
    
    $theme->elem('header');
?>
<div class="row-fluid">
    <div class="offset1 span4">
        <img src="<?php $profile['profile_image_url'] ?>">
        <div><?php $profile['name'] ?></div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6 offset3">
        <h3>Loading Latest 10 Tweets</h3>
        
        <?php $tweet = $twitter->get(10); ?>
        
        <?php foreach( $tweet as $t ): ?>
        <ol>
            <li>><?php echo $t ?></li>
        </ol>
        <?php endforeach; ?>
        
    </div>
</div>
<?php $theme->elem('footer'); ?>