<?php

class Theme{
    /*
     * load a js file using script tag
     * @param filename name of the file to be loaded as javascript
     * @param dir path of the directory
     * @param ext extension of the file, in case using dynamically generated script
     */
    
    private $css_coll = array();
    private $js_coll = array();
    
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

    function elem( $name , $var = array(), $dir = _ELEMENT, $ext = EXT_PHP ){
        global $theme, $twitter;
        
        extract($var);
        
        return include( $dir .DS . $name . DOT . $ext );
    }
    
    function js_footer($filename, $dir = WEBROOT_JS, $ext = EXT_JS){
        $this->js_coll[] = array( compact('filename', 'dir', 'ext') );
    }
    /*
     * these are used to dump css file link at footer
     * instead of middle of content
     */
    function css_footer($filename, $dir = WEBROOT_CSS, $ext =  EXT_CSS){
        $this->css_coll[] = array( compact('filename', 'dir', 'ext') );
    }
    
    function dump_footer(){
        
        foreach( $this->css_coll as $css ){
            call_user_func_array(array(&$this, 'css'), $css);
        }
        
        foreach( $this->js_coll as $js ){
            call_user_func_array(array(&$this, 'js'), $js);
        }
    }
}

$theme = new Theme;