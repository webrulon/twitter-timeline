<?php
    
require_once 'init/bootloader.php';

$twitter->only_authed();

$pdf->SetTitle('Tweets');

$twitter->connect();
$tweet = $twitter->get_tweet(10);

//fpdf
include _LIB . DS . 'fpdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();

$html = '<ol>';
foreach( $tweet as $t ){
    $html.= '<li>' . $t->text . '</li>' ;
}
$html .= '</ol>';

$pdf->WriteHTML($html);

$pdf->Output();