<?php
/**
 * @author pieces
 * 2018/01/26
 */
class test{
	
	private static $self = null;
	private $mode='';
	
	/**
	 * instance
	 * @return new_summary
	 */
	public static function instance(){
		if(self::$self==null){
			self::$self = new self();
		}
		return self::$self;
	}
	private function _init(){
		global $argv;
		$this->mode	 = isset($argv[2]) ? $argv[2] : '';
	}
	
	/**
	 * runner
	 * @param string $mode
	 * @param string $date
	 */
	public function run(){
		$this->_init();
		$this->_running();
	}
	
	/**
	 * running
	 * @throws FatalException
	 */
	private function _running(){
		switch ($this->mode){
			case '-run':
				$this->_todoSomething();
			default:
				throw new FatalException('audit Cmd Mode Error. Mode:'.$this->mode);
				break;
		}
	}
	
	/**
	 * detail code
	 */
	private function _todoSomething(){
		//write todo something...
	}
	
}
?>