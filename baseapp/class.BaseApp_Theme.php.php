<?php

class BaseApp_Theme{
    /*
     * load a js file using script tag
     * @param filename name of the file to be loaded as javascript
     * @param dir path of the directory
     * @param ext extension of the file, in case using dynamically generated script
     */
    
    function js( $filename, $dir = WEBROOT_JS, $ext = EXT_JS ){
        ?>
        <script  language="Javascript" src="<?php echo $dir . DS . $filename . DOT . $ext  ?>"></script>
        <?php
    }
    
    /*
     * get the url of the file
     * this is used by files
     * 
     * @param filename name of the file to be loaded as javascript
     * @param dir path of the directory
     * @param ext extension of the file, in case using dynamically generated script
     */
    
    function css( $filename, $dir = WEBROOT_CSS, $ext =  EXT_CSS  ){
        ?>
        <link href="<?php echo $dir . DS . $filename . DOT . $ext ?>" rel="stylesheet" type="text/css" />
        <?php
    }
    
    /*
     * get the header part of the site
     * 
     * @param name name of the element to include
     * @param ext extension of file, default php
     * 
     * @return NOTHING
     */

    function elem( $name , $var, $dir = _ELEMENT, $ext = EXT_PHP ){
        global $theme, $twitter;
        
        extract($var);
        
        return include( $dir .DS . $name . DOT . $ext );
    }
}

$theme = new BaseApp_Theme;