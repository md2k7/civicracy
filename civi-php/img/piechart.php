<?php
	$height = 250; $width = 350;
	$height3d = 20;
	$no_sort = false; // Sortierung an
	
	$data = $_GET["data"];
	$piece_values = explode('*',$data);

	graph_pie_3d($piece_values, $height, $width, $height3d, $no_sort);
	
	
	function graph_colors($im, $werteAnzahl) 
	{
		$dark = 50;
		
		$rot = array(0, 0, 0, 0, 0, 102, 102, 102, 102, 102, 102, 102, 102, 102, 204, 204, 204, 204, 204, 204, 204, 204, 204, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 102, 102, 102, 102, 102, 102, 102, 102, 102, 102, 102);
		$gruen = array(102, 102, 204, 204, 204, 0, 0, 0, 102, 102, 102, 204, 204, 204, 0, 0, 0, 102, 102, 102, 204, 204, 204, 51, 51, 51, 51, 51, 51, 102, 102, 102, 102, 102, 102, 153, 153, 153, 153, 153, 153, 204, 204, 204, 204, 204, 204, 255, 255, 255, 255, 255, 255, 0, 0, 0, 0, 0, 0, 51, 51, 51, 51, 51, 51, 102, 102, 102, 102, 102, 102, 153, 153, 153, 153, 153, 153, 204, 204, 204, 204, 204, 204, 255, 255, 255, 255, 255, 255, 0, 0, 0, 0, 0, 0, 51, 51, 51, 51, 51);
		$blau = array(102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 102, 204, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204, 255, 0, 51, 102, 153, 204);
		
		$colors["background"] = ImageColorAllocate($im, 255, 255, 255);
		//$colors["text"] = ImageColorAllocate($im, 0, 0, 0);

		for($i=0; $i<$werteAnzahl; $i++)
		{		
			if($i>count($rot)-1)
				$r = count($rot) - 1;
			else
				$r = $i;
			 
			if($i>count($gruen)-1)
				$g = count($gruen) - 1;
			else
				$g = $i;
			 
			if($i>count($blau)-1)
				$b = count($blau) - 1;
			else
				$b = $i;
			 
			//$color = ImageColorAllocate($im, $rot[$r], $gruen[$g], $blau[$b]);

			if($rot[$r] < $dark)
				$rot_dark = 0;
			else
				$rot_dark = $rot[$r] - $dark;
			
			if($gruen[$g] < $dark)
				$gruen_dark = 0;
			else
				$gruen_dark = $gruen[$g] - $dark;
			
			if($blau[$b] < $dark)
				$blau_dark = 0;
			else
				$blau_dark = $blau[$b] - $dark;
			
			$colors[$i] = ImageColorAllocate($im, $rot[$r], $gruen[$g], $blau[$b]);
			$colors_dark[$i] = ImageColorAllocate($im, $rot_dark, $gruen_dark, $blau_dark);
		}
		return array("colors" => $colors, "colors_dark" => $colors_dark);
	}
	
	function graph_pie_3d($piece = array(), /*$piece_text = array(),*/ $height, $width, $height3d = 15, $no_sort = false) 
	{
		header("Content-type: image/png");
		$im = ImageCreateTrueColor($width+20, $height+50);
	
		$werteAnzahl = count($piece);		//anzahl der übergebenen werte ermitteln
		
		$graph_colors = graph_colors($im, $werteAnzahl);
	
		$colors = $graph_colors["colors"];
		$colors_dark = $graph_colors["colors_dark"];
	
		ImageFill($im, 0, 0, $colors["background"]);
	
		$sum = array_sum($piece);
		$height_graph = $height /*- ImageFontHeight(2) * count($piece) - $height3d - 15*/;
		$width_graph = $width /*- 20*/;
		$x_graph = $width / 2;
		$y_graph = $height_graph / 2 + $height3d + 10;
	
		if (!$no_sort) arsort($piece);
	
		for ($i = 0; $i <= $height3d; $i++) {
			$l = 0;
			$j = 0;
	
			while (list($key, $val) = each($piece)) {
				$degree = $val / $sum * 360;
	
				ImageFilledArc($im, $x_graph, $y_graph - $i, $width_graph, $height_graph, $l, $l + $degree, $colors_dark[$j], IMG_ARC_PIE);
	
				$l+= $degree;
				$j++;
			}
	
			reset($piece);
		}
	
		reset($piece);
		$l = 0;
		$j = 0;
	
		$text = 0;			//ohne dem hats nicht funktioniert. weil in der funktion "ImageRectangle" "$text" undefiniert war. aber egal, welche zahl ich eingebe -> es verändert sich nix!
		
		while (list($key, $val) = each($piece)) 
		{
			$degree = $val / $sum * 360;
	
			ImageFilledArc($im, $x_graph, $y_graph - $height3d, $width_graph, $height_graph, $l, $l + $degree, $colors[$j], IMG_ARC_PIE);
			$l+= $degree;
			$j++;
		}
	
		ImagePNG ($im);
	}
?>