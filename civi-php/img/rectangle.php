<?php
	//$piece_values = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20/*, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50*/);
	$piece_values = array(70, 15, 10, 7);
	$piece_names = array("MSIE", "Firefox", "Opera", "Safari");
	
	$height = 12; $width = 12;
	$height3d = 20;
	$no_sort = false; // Sortierung an
	
	$data = $_GET["data"];

	graph_pie_3d($height, $width, $data);
	
	
	
	
function get_color($im, $i) 
{
	$rot = array(0, 0, 0, 0, 0, 102, 102, 102, 102, 102, 102, 102, 102, 102, 204, 204, 204, 204, 204, 204, 204, 204, 204, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 102, 102, 102, 102, 102, 102, 102, 102, 102, 102, 102);
	$gruen = array(102, 102, 204, 204, 204, 0, 0, 0, 102, 102, 102, 204, 204, 204, 0, 0, 0, 102, 102, 102, 204, 204, 204, 51, 51, 51, 51, 51, 51, 102, 102, 102, 102, 102, 102, 153, 153, 153, 153, 153, 153, 204, 204, 204, 204, 204, 204, 255, 255, 255, 255, 255, 255, 0, 0, 0, 0, 0, 0, 51, 51, 51, 51, 51, 51, 102, 102, 102, 102, 102, 102, 153, 153, 153, 153, 153, 153, 204, 204, 204, 204, 204, 204, 255, 255, 255, 255, 255, 255, 0, 0, 0, 0, 0, 0, 51, 51, 51, 51, 51);
  	$blau = array(102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204);	
  	
  	$color = ImageColorAllocate($im, $rot[$i], $gruen[$i], $blau[$i]);

  	return $color;
} 
	
function graph_pie_3d($height, $width, $i) 
{
   header("Content-type: image/png");
   $im = ImageCreateTrueColor($width, $height);

   $color = get_color($im, $i);
   
   ImageFilledRectangle($im, 0, 0, $width, $height, $color);
   ImageRectangle($im, 0, 0, $width, $height, 0);
   ImagePNG ($im);
 } 
?>