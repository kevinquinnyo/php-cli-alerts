<?php
	
	class ConsoleInput {
		
		protected $_input;
		protected $_canReadLine;
		
		public function __construct ($handle = 'php://stdin') {
			
			$this->_canReadLine = extension_loaded('readline') && $handle == 'php://stdin' ? true : false;
			$this->_input = fopen($handle, 'r');
			
		} // END __construct();
		
		public function dataAvailable ($timeout = 0) {
			
			$readFds = array($this->_input);
			$readyFds = stream_select($readFds, $writeFds, $errorFds, $timeout);
			
			return ($readyFds > 0);
			
		} // END dataAvailable();
		
		public function read () {
			
			if ($this->_canReadLine) {
				$line = readline('');
				
				if (!empty($line)) {
					readline_add_history($line);
				}
				
				return $line;
			}
			
			return fgets($this->_input);
			
		} // END read();
		
	}
	
?>