<?php
define('DATA_URL', 'students_112.txt');

require_once 'volunteer_lib.php';

$string = '';
$string .= html_header($title = 'Volunteer Generator', $styles = 'example_styles.css');
$string .= "<h1>Volunteer Generator</h1>\n";
$string .= show_form();
init_data();
$string .= check_submit();
$string .= show_people();
$string .= html_footer($text = 'Day 7 HW/ICE');
echo $string;
?>