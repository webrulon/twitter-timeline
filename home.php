<?php

require_once 'baseapp/bootloader.php';
    
    if(  ! $twitter->is() ){
        //is the user authz
        header('location: index.php' );
        exit();
    }

    $theme->elem('header');
?>
<div class="row-fluid">
    <div class="span6 offset3">
        <?php $tweet = $twitter->get(10); ?>
        <?php foreach( $tweet as $t ): ?>
        <ol>
            <li>><?php echo $t ?></li>
        </ol>
        <?php endforeach; ?>
    </div>
</div>
<?php $theme->elem('footer') ?>