<?php

	class Terminal
	{
		# default. so you can do:  $term("this is plain text.\n");
		public function __invoke($text)
		{
			echo $text;
		}

		private function col($color, $text)
		{
			switch($color)
			{
				case "bold"     :       return ("\033[1m{$text}\033[0m"); break;
				case "red"      :       return ("\033[0;31m{$text}\033[0m"); break;
				case "yellow"   :       return ("\033[0;33m{$text}\033[0m"); break;
				case "blue"     :       return ("\033[0;34m{$text}\033[0m"); break;
				case "green"    :       return ("\033[0;32m{$text}\033[0m"); break;
				case ""         :       return $text; break;
			}
		}

		public function alert($level, $msg)
		{
			$fe = fopen('php://stderr', 'w');
			switch($level)
			{
				case "NOTICE"   :       fwrite($fe, "\n [ " . $this->col('yellow', "NOTICE") . " ] " . $this->col('bold', $msg)); break;
				case "WARNING"  :       fwrite($fe, "\n [ " . $this->col('red',   "WARNING") . " ] " . $this->col('bold', $msg)); break;
				case "ERROR"    :       fwrite($fe, "\n [ " . $this->col('red',    "ERROR") . " ]  " . $this->col('bold', $msg));break;
				case "SUCCESS"  :       echo "\n [ " . $this->col('green',  "OK") . " ]     " . $this->col('bold', $msg); break;
				case "INFO"     :       echo "\n [ " . $this->col('yellow', "+") . " ]      " . $this->col('bold', $msg); break;
				case "BEGIN"    :       echo "\n[ " . $this->col('blue',   ">>>") . " ]    " . $this->col('bold', $msg); break;
				case "END"      :       echo "\n[ " . $this->col('red',    "<<<") . " ]    " . $this->col('bold', $msg); break;
			}

		}

		public function color($color, $text)
		{
			echo $this->col($color, $text);
		}

		public function doList($color1, $color2, $delim, $delim_color, $items)
		{
			if(!empty($items))
			{
				foreach($items as $key => $value)
					printf(" %-30s %s %s\n", $this->col($color1, $key), $this->col($delim_color, $delim), $this->col($color2, $value));
			}
			else
				echo "";
		}
	}

?>