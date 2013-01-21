<?php

class Theme{
    
    /*
     * var array
     * use to store the css that will be dumped at the footer
     */
    private $css_coln = array();
    
    /*
     * var array
     * use to store the js that will be dumped at the footer
     */
    private $js_coln = array();
    
    /*
     * load a js file using script tag

     * @param filename: name of the file to be loaded as javascript
     * @param dir: path of the directory( default : WEBROOT_JS )
     * @param ext extension of the file, in case using dynamically generated script( default: EXT_JS )
     * 
     * @return VOID
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
     * @param filename: name of the file to be loaded as javascript
     * @param dir: path of the directory( default: WEBRROOT_CSS )
     * @param ext: extension of the file, in case using dynamically generated script( default: EXT_CSS )
     * 
     * @return VOID
     */
    
    function css( $filename, $dir = WEBROOT_CSS, $ext =  EXT_CSS  ){
        ?>
        <link href="<?php echo $dir . DS . $filename . DOT . $ext ?>" rel="stylesheet" type="text/css" />
        <?php
    }
    
    /*
     * get the header part of the site
     * 
     * @param name: name of the element to include
     * @param dir: directory where the element is located, ( default: _ELEMENT )
     * @param ext: extension of file, default php
     * 
     * @return VOID
     */

    function elem( $name , $var = array(), $dir = _ELEMENT, $ext = EXT_PHP ){
        
        global $theme, $twitter;
        
        extract($var);
        
        return include( $dir .DS . $name . DOT . $ext );
    }
    
    /*
     * store the js link and dump it at footer
     * identical input as js()
     */
    
    function js_footer($filename, $dir = WEBROOT_JS, $ext = EXT_JS){
        $this->js_coln[] = array( $filename, $dir, $ext);
    }
    /*
     * these are used to dump css file link at footer
     * instead of middle of content
     * identical param as css()
     */
    function css_footer($filename, $dir = WEBROOT_CSS, $ext =  EXT_CSS){
        $this->css_coln[] = array( $filename, $dir, $ext);
    }
    
    /*
     * dump the css and js file tag to footer
     * 
     * @return VOID
     */
    function dump_footer(){
        
        foreach( $this->css_coln as $css ){
            call_user_func_array(array(&$this, 'css'), $css);
        }
        
        foreach( $this->js_coln as $js ){
            call_user_func_array(array(&$this, 'js'), $js);
        }
    }
}