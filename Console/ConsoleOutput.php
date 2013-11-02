<?php
	
	class ConsoleOutput {
		
		const COLOR = 2;
		const LF = PHP_EOL;
		const PLAIN = 1;
		const RAW = 0;
		
		protected static $_backgroundColors = array(
			'black' => 40,
			'red' => 41,
			'green' => 42,
			'yellow' => 43,
			'blue' => 44,
			'magenta' => 45,
			'cyan' => 46,
			'white' => 47
		);
		protected static $_foregroundColors = array(
			'black' => 30,
			'red' => 31,
			'green' => 32,
			'yellow' => 33,
			'blue' => 34,
			'magenta' => 35,
			'cyan' => 36,
			'white' => 37
		);
		protected static $_options = array(
			'bold' => 1,
			'underline' => 4,
			'blink' => 5,
			'reverse' => 7
		);
		protected $_output;
		protected $_outputAs = self::COLOR;
		protected static $_styles = array(
			'alert' => array('text' => 'red', 'underline' => true),
			'comment' => array('text' => 'blue'),
			'critical' => array('text' => 'red', 'underline' => true),
			'debug' => array('text' => 'yellow'),
			'emergency' => array('text' => 'red', 'underline' => true),
			'error' => array('text' => 'red', 'underline' => true),
			'info' => array('text' => 'cyan'),
			'notice' => array('text' => 'cyan'),
			'success' => array('text' => 'green'),
			'question' => array('text' => 'magenta'),
			'warning' => array('text' => 'yellow')
		);
		
		public function __construct ($stream = 'php://stdout') {
			
			$this->_output = fopen($stream, 'w');
			
		} // END __construct();
		
		public function __destruct () {
			
			fclose($this->_output);
			
		} // END __destruct();
		
		public function outputAs ($type = null) {
			
			if ($type === null) {
				return $this->_outputAs;
			}
			
			$this->_outputAs = $type;
			
		} // END outputAs();
		
		protected function _replaceTags ($matches) {
			
			$style = $this->styles($matches['tag']);
			
			if (empty($style)) {
				return '<' . $matches['tag'] . '>' . $matches['text'] . '</' . $matches['tag'] . '>';
			}
			
			$styleInfo = array();
			
			if (!empty($style['text']) && isset(self::$_foregroundColors[$style['text']])) {
				$styleInfo[] = self::$_foregroundColors[$style['text']];
			}
			
			if (!empty($style['background']) && isset(self::$_backgroundColors[$style['background']])) {
				$styleInfo[] = self::$_backgroundColors[$style['background']];
			}
			
			unset($style['text'], $style['background']);
			
			foreach ($style as $option => $value) {
				if ($value) {
					$styleInfo[] = self::$_options[$option];
				}
			}
			
			return "\033[" . implode($styleInfo, ';') . 'm' . $matches['text'] . "\033[0m";
			
		} // END _replaceTags();
		
		public function styleText ($text) {
			
			if ($this->_outputAs == self::RAW) {
				return $text;
			}
			
			if ($this->_outputAs == self::PLAIN) {
				$tags = implode('|', array_keys(self::$styles));
				return preg_replace('#</?(?:' . $tags . ')>#', '', $text);
			}
			
			return preg_replace_callback(
				'/<(?P<tag>[a-z0-9-_]+)>(?P<text>.*?)<\/(\1)>/ims',
				array($this, '_replaceTags'),
				$text
			);
			
		} // END styleText();
		
		public function styles ($style = null, $definition = null) {
			
			if ($style === null && $definition === null) {
				return self::$_styles;
			}
			
			if (is_string($style) && $definition === null) {
				return isset(self::$_styles[$style]) ? self::$_styles[$style] : null;
			}
			
			if ($definition === false) {
				unset(self::$_styles[$style]);
				return true;
			}
			
			self::$_styles[$style] = $definition;
			return true;
			
		} // END styles();
		
		public function write ($message, $newLines = 1) {
			
			$message = is_array($message) ? implode(self::LF, $message) : $message;
			$message = $this->styleText($message . str_repeat(self::LF, $newLines));
			
			return $this->_write($message);
			
		} // END write();
		
		protected function _write ($message) {
			
			return fwrite($this->_output, $message);
			
		} // END _write();
		
	}
	
?>