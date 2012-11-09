<?php
	//$piece_values = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20/*, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50*/);
	$height = 250; $width = 350;
	$height3d = 20;
	$no_sort = false; // Sortierung an
	
	$data = $_GET["data"];
	$piece_values = explode('*',$data);

	graph_pie_3d($piece_values, /*$piece_names,*/ $height, $width, $height3d, $no_sort);
	
	function graph_colors($im, $werteAnzahl) 
	{
		$dark = 50;
		
		$colors["background"] = ImageColorAllocate($im, 255, 255, 255);
		$colors["text"] = ImageColorAllocate($im, 0, 0, 0);
		
		$stufe = 102;		//wert um den die farbe erhöht wird
		
		$rot = 0;
		$gruen = $stufe;
		$blau = 0;
		
		
		$rot_dark = 0;
	
		if($gruen < $dark)
			$gruen_dark = 0;
		else
			$gruen_dark = $gruen - $dark;
		
		$blau_dark = 0;
		
		
		for($i=0; $i<$werteAnzahl; $i++)
		{
			$colors[$i] = ImageColorAllocate($im, $rot, $gruen, $blau);
			$colors_dark[$i] = ImageColorAllocate($im, $rot_dark, $gruen_dark, $blau_dark);
			
			$blau += $stufe;
			if($blau > 255)
			{
				$blau = 0;
				$gruen += $stufe;
			}
			if($gruen > 255)
			{
				$gruen = 0;
				$rot += $stufe;
			}
			if($rot > 255)
			{
				$stufe /= 2;
				
				if($stufe > 1)
				{
					$rot = 0;
					$gruen = $stufe;
					$blau = 0;
				}
			}
	
			if($rot < $dark)
				$rot_dark = 0;
			else
				$rot_dark = $rot - $dark;
			
			if($gruen < $dark)
				$gruen_dark = 0;
			else
				$gruen_dark = $gruen - $dark;
			
			if($blau < $dark)
				$blau_dark = 0;
			else
				$blau_dark = $blau - $dark;
	
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