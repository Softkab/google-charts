<?php
/*
Plugin Name: Google Charts Pie
Description: Google Charts Pie
Plugin URI: http://jorge.sh/
Author URI: http://jorge.sh/
Author: Jorge Solís
License: Public Domain
Version: 1.1
*/

?>


<?php
function cargar_js_plugin(){
echo "<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>";

}
add_action('wp_head', 'cargar_js_plugin');
function form_creation($atts, $title = null){
$a = shortcode_atts( array(
        'style' => '',
        'nombre' =>''
    ), $atts );
     $str = html_entity_decode($title, ENT_QUOTES, "UTF-8");
     $resultado = str_replace("‘", "'", $str);
     $resultado = str_replace("’", "'", $resultado);
     $resultado = str_replace("”", "''", $resultado);
     $codigo=urls_amigables(esc_attr($a['nombre']));

$script="<script type='text/javascript'> google.charts.load('current', {'packages':['corechart']}); google.charts.setOnLoadCallback(drawChart); function drawChart() { var data = google.visualization.arrayToDataTable([";
$script.=$resultado;
$script.="]); var options = { title: '";
$script.=esc_attr($a['nombre']);
$script.="',backgroundColor: { fill:'transparent' }, pieHole: 0.4, slices: { 0: { color: '#F2631D' }, 1: { color: '#F6CB1A' }, 2: { color: '#BDB7B7' }, 3: { color: '#8B8283' }, 4: { color: '#484647' }, 5: { color: '#283440' }, 6: { color: '#2D6690' }, 7: { color: '#FFFFFF' } }, }; var chart = new google.visualization.PieChart(document.getElementById('";
$script.=urls_amigables($codigo);
$script.="')); chart.draw(data, options); } </script>";
$script.="<div id='";
$script.=urls_amigables($codigo);
$script.="'style='";
$script.=esc_attr($a['style']);
$script.="'></div>";

echo $script;
}
add_shortcode('Charts', 'form_creation');
function urls_amigables($url) {
      $url = strtolower($url);
      $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
       $repl = array('a', 'e', 'i', 'o', 'u', 'n');
       $url = str_replace ($find, $repl, $url);
       $find = array(' ', '&', '\r\n', '\n', '+');
      $url = str_replace ($find, '-', $url);
       $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
       $repl = array('', '-', '');
       $url = preg_replace ($find, $repl, $url);
       return $url; 
}