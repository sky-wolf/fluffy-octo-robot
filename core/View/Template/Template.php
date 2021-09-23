<?php

namespace app\core\View\Template;
use app\core\Application;

class Template
{
	static $blocks = array();
	static $path = '/Resources/Views' . '/';
	static $cachepath = 'cache' . '/';
	static $cacheenabled = FALSE;

	protected static function CleanPath($file)
   	{
		return Application::$ROOT_DIR . self::$path . str_replace(array('.', '.php'), array('/',''), $file) .'.wolf.php';
   	}
	protected static function CachePath($file)
   	{
		return self::$cachepath . str_replace(array('.', '.php'), array('/',''), $file) .'.wolf.php';
   	}
   
   static function rendering($file, $params = array())
   {
		$cached = realpath(self::CachePath($file));
	   	if ( !self::$cacheenabled || file_exists(self::CleanPath($file)) ) 
	   	{
			$content = self::compile($file);
			file_put_contents($cached, $content);
		}
			
		extract($params, EXTR_SKIP);

		$a = 5;
		
		$users = array(
			array("id" => '1'),
			array("id" => '2'),
			array("id" => '3'),
			array("id" => '4'),
			array("id" => '5')
		);
			
	
		
		ob_start();
			include($cached);
			$contents = ob_get_contents();
		ob_end_clean();

       	return $contents;
   }

      
   static function compile($file)
   {
		$code = self::CompileLayout($file);
	   	$code = self::CompileYield($code);
	   	$code = self::CompileStartIF($code);
	   	$code = self::CompileElesif($code);
	   	$code = self::CompileEles($code);
	   	$code = self::CompileEndIF($code);
		$code = self::CompileCase($code);
		$code = self::CompileBreak($code);
		$code = self::CompileDefault($code);
		$code = self::CompileSwitch($code);
		$code = self::CompileEndSwitch($code);
		$code = self::CompileForeach($code);
		$code = self::CompileEndForeach($code);
		/* $code = self::CompileForelse($code);
		$code = self::CompileEmpty($code);
		$code = self::CompileEndForelse($code); */
		$code = self::CompileFor($code);
		$code = self::CompileEndFor($code);
		$code = self::CompileWhile($code);
		$code = self::CompileEndWhile($code);

		$code = self::compileEscapedEchos($code);
		$code = self::compileEchos($code);
		$code = self::compilePHP($code);
		
        return $code; 
   }

   /* 
 	* skappar tempäten och skappar block content
   */
   static function CompileLayout($file)
   {
		$temp = file_get_contents(self::CleanPath($file));
	
		self::CompileSection($temp);
		
		preg_match_all('/^\@extends\s?\(\'(.*?)\'\)/i', $temp, $matches);
		
		if(!empty($matches[0]))
		{
			$matches[1][0];
			$cached = file_get_contents(self::CleanPath($matches[1][0]));
			$cached = self::includeFiles($cached);
			return $cached;
		}

		return $temp;
   }
   
   /* 
 	*tittar igenom och sammaför rästen av fillerna   
   */
   static function includeFiles($code)
   {
		preg_match_all('/^\@extends\s?\(\'(.*?)\'\)/i', $code, $matches);
		/* echo '<pre>';
		var_dump ($matches);
		echo '</pre>'; */

		if(!empty($matches[0]))
		{
			foreach($matches as $value)
			{ 
				if (substr($value[0], 0, 1) === '@')
					continue;

				$replace = '@extends ( '. $value[0] .' )';
				$include = file_get_contents(self::CleanPath($value[0]));
				$code = str_replace($replace, self::includeFiles($include), $code);
				/* echo $cached; */

			}
		}
		
		//$code = preg_replace('/^\@extends\s?\(\'(.*?)\'\)/i', '', $code);
		/* echo $code; */
		return $code; 
   	}


	/* 
	*insert section into block for CompileYield
	 */
	static function CompileSection($code)
	{
		preg_match_all('/\@section\s?\(\'(.*?)\'\)(.*?)\@endsection/is', $code, $matches, PREG_SET_ORDER);
		/* echo '<pre>';
		var_dump ($matches);
		echo '</pre>'; */
		/* echo $matches[0][0]; */
		if(!empty($matches[0][0]))
		{
			foreach($matches as $value)
			{ 
				if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
				if (strpos($value[2], '@parent') === false) {
					self::$blocks[$value[1]] = $value[2];
				} else {
					self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
				}
				$code = str_replace($value[0], '', $code);
			}
		}
	
		/* echo '<pre>';
		var_dump (self::$blocks);
		echo '</pre>'; */
	}
	/* 
	*	replase @yield('content') whit block content. 
	*/
	static function CompileYield($code)
	{
		foreach(self::$blocks as $block => $value) 
		{
			$pattern =  "/\@yield\(\'$block\'\)/i";

			$code = preg_replace('/\@yield\s?\(\''.$block.'\'\)/i', $value, $code);
		}
		/* echo $code; */
		$code = preg_replace('/\@yield\s?\(\'(.*?)\'\)/i', '', $code);

		return $code;
	}

	static function CompileStartIF($code)
	{
		return preg_replace('/\@if\s?\(((?<=\().*(?=\)))\)/i', '<?php if($1): ?>', $code);
	}
	
	static function CompileElesif($code)
	{
		return preg_replace('/\@elseif\s?\(((?<=\().*(?=\)))\)/i', '<?php elseif($1): ?>', $code);
	}

	static function CompileEles($code)
	{
		return preg_replace('~@else~is', '<?php else: ?>', $code);
	} 
	
	static function CompileEndIF($code)
	{
		return preg_replace('~@endif~is', '<?php endif; ?>', $code);
	}

	/* 
	replase @switch($i) @case(1) First case... @break @default @endswitch
	*/
	static function CompileSwitch($code)
	{
		return preg_replace('/\@switch\s?\(((?<=\().*(?=\)))\)/i', '<?php switch ($1): ?>', $code);
	}

	static function CompileCase($code)
	{
		return preg_replace('/\@case\s?\(((?<=\().*(?=\)))\)/i', '<?php case $1: ?>', $code);
	} 

	static function CompileBreak($code)
	{
		return preg_replace('/\@break/i', '<?php break; ?>', $code);
	}

	static function CompileDefault($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 

	static function CompileEndSwitch($code)
	{
		return preg_replace('/\@endswitch/i', '<?php endswitch; ?>', $code);
	} 

	static function CompileFor($code)
	{
		return preg_replace('/\@for\s?\(((?<=\().*(?=\)))\)/i', '<?php for($1): ?>', $code);
	}
	
	static function CompileEndFor($code)
	{
		return preg_replace('/\@endfor/i', '<?php endfor; ?>', $code);
	}

	static function CompileForeach($code)
	{
		return preg_replace('/\@foreach\s?\(((?<=\().*(?=\)))\)/i', '<?php foreach($1): ?>', $code);
	}

	static function CompileEndForeach($code)
	{
		return preg_replace('/\@endforeach/i', '<?php endforeach; ?>', $code);
	}

	/* static function CompileForelse($code)
	{
		return preg_replace('/\@forelse\s?\(((?<=\().*(?=\)))\)/i', '<?php foreach($1): ?>', $code);
	}

	static function CompileEmpty($code)
	{
		return preg_replace('/\@empty/i', '<?php empty; ?>', $code);
	}

	static function CompileEndForelse($code)
	{
		return preg_replace('/\@endforelse/i', '<?php endforeach; ?>', $code);
	} */

	static function CompileWhile($code)
	{
		return preg_replace('/\@while\s?\(((?<=\().*(?=\)))\)/i', '<?php while($1): ?>', $code);
	}

	static function CompileEndWhile($code)
	{
		return preg_replace('/\@endwhile/i', '<?php endwhile; ?>', $code);
	} 

	/*static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
	static function CompileEscapedEchos($code)
	{
		return preg_replace('/\@default/i', '<?php default: ?>', $code);
	} 
*/
	

	static function CompileEscapedEchos($code)
	{
		return preg_replace('~/{{{%\s*(.+?)\s*%}}}~is', '*****$1 *****<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
	}

	static function CompileEchos($code)
	{
		return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
	}

	static function CompilePhp($code)
	{
		return preg_replace('~/{{{%\s*(.+?)\s*%}{}~is', '<?php $1; ?>', $code);
	}

}
