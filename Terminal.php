<?php
	
	require_once('Console' . DIRECTORY_SEPARATOR . 'ConsoleInput.php');
	require_once('Console' . DIRECTORY_SEPARATOR . 'ConsoleOutput.php');
	
	class Terminal {
		
		const QUIET = 0;
		const NORMAL = 1;
		const VERBOSE = 2;
		
		public $stderr;
		public $stdin;
		public $stdout;
		
		public function __construct () {
			
			$this->stdin = new ConsoleInput('php://stdin');
			$this->stdout = new ConsoleOutput('php://stdout');
			$this->stderr = new ConsoleOutput('php://stderr');
			
		} // END __construct();
		
		public function hr ($newLines = 0, $width = 63) {
			
			$this->out(null, $newLines);
			$this->out(str_repeat('-', $width));
			$this->out(null, $newLines);
			
		} // END hr();
		
		public function nl ($multiplier = 1) {
			
			return str_repeat(ConsoleOutput::LF, $multiplier);
			
		} // END nl();
		
		public function out ($message = null, $newLines = 1, $level = Terminal::NORMAL) {
			
			$currentLevel = Terminal::NORMAL;
			
			if ($level <= $currentLevel) {
				return $this->stdout->write($message, $newLines);
			}
			
			return true;
			
		} // END out();
		
		public function startup () {
			
			$this->_welcome();
			
		} // END startup();
		
		protected function _welcome () {
			
			$this->out();
			$this->out('<info>Welcome to the Terminal</info>');
			$this->hr();
			
		} // END _welcome();
		
	}
	
?>