/* 
 * Author: Kuldeep Singh Dhaka( kuldeepdhaka9@gmail.com )
 * Enable js Console to view output
 */

var aboutme = [
    "hello Their,",
    "Im Kuldeep Singh Dhaka",
    "@kuldeepdhaka9",
    "Programmer, Open Source, Web Developer, Entrepreneur, Animal Lover, Student, Blogger, Reverse Engineer, Embedded System.",
    "I can work with PHP + MySql, jQuery, Javascript, HTML5, CSS3, Wordpress, CakePHP, Twitter Bootstrap, C/C++",
    "I Love & Accept Bitcoins",
    "Get My GPG Public Key From http://pgp.mit.edu/ , I have signed this file, just append .sig with this script url",
    "You Can reach me by +91-8791676237 or Drop a mail At kuldeepdhaka9@gmail.com"
];

/*
 * serially print the about me, line by line
 * 
 * @param {integer} index
 * @param {string} line
 * 
 */

console.clear();

$.each(aboutme, function(index, line){
    console.info(line);
});