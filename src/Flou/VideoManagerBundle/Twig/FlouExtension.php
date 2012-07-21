<?php

namespace Flou\VideoManagerBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;

class FlouExtension extends Twig_Extension
{
	public function getFunctions()
	{
		return array(
				'darken' => new \Twig_Function_Method($this, 'darken'),
				'lighten' => new \Twig_Function_Method($this, 'lighten'),
				'gradient' => new \Twig_Function_Method($this, 'gradient'),
				'varprint' => new \Twig_Function_Method($this, 'varprint')
		);
	}
	
	public function getName()
	{
		return 'flou_extension';
	}
	
	///////////////////////////////////////////////
	///////////// TWIG FUNCTIONS //////////////////
	public function darken($color, $value = 20)
	{
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){
			return '000000';
		}
		$rgb = '';
		
		for ($x=0;$x<3;$x++){
			$c = hexdec(substr($color,(2*$x),2)) - $value;
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
		}
		
		return $rgb;
	}
	
	public function lighten($color, $value = 20)
	{
		$color = str_replace('#', '', $color);
		if (strlen($color) != 6){
			return '000000';
		}
		$rgb = '';
	
		for ($x=0;$x<3;$x++){
			$c = hexdec(substr($color,(2*$x),2)) + $value;
			$c = ($c > 255) ? dechex(255) : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
		}
	
		return $rgb;
	}
	
	public function varprint($variable)
	{
		echo '<!-- PRINT START -------------------------------->'."\n";
		print_r($variable);
		echo '<!-- PRINT END ---------------------------------->'."\n";
	}
	
	public function gradient($stops)
	{
		
		$moz = 'background: -moz-linear-gradient(top';
		$webkit_g = 'background: -webkit-gradient(linear, left top, left bottom';
		$webkit_lg = 'background: -webkit-linear-gradient(top';
		$o_lg = 'background: -o-linear-gradient(top';
		$ms = 'background: -ms-linear-gradient(top';
		$lg = 'background: linear-gradient(top';
		
		foreach($stops as $key=>$value)
		{
			$color = str_replace('#', '', $value);
			
			$moz .= ', #'.$color.' '.$key;
			$webkit_g .= ', color-stop('.$key.',#'.$color.')';
			$webkit_lg .= ', #'.$color.' '.$key;
			$o_lg .= ', #'.$color.' '.$key;
			$ms .= ', #'.$color.' '.$key;
			$lg .= ', #'.$color.' '.$key;
		}
		
		$last = str_replace('#', '', end($stops));
		$first = str_replace('#', '', array_shift($stops));
		
		return 'background: #'.$first.';'."\n".
				$moz.');'."\n".
				$webkit_g.');'."\n".
				$webkit_lg.');'."\n".
				$o_lg.');'."\n".
				$ms.');'."\n".
				$lg.');'."\n".
				'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#'.$first.'\', endColorstr=\'#'.$last.'\',GradientType=0 );';
	}
}