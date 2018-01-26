<?php
/**
 * @author pieces
 * 2018/01/26
 */
header('Content-type:text/html;charset=utf-8;');
date_default_timezone_set('Asia/Shanghai');
define('SYSTEM_TIME',time());
define('DEBUG',true);
define('ROOT',str_replace('\\', '/', dirname(__FILE__)).'/');
define('LOGS',ROOT.'logs/');
include (ROOT.'lib/common.php');
error_reporting(E_ALL);
function cache_shutdown_error() {
	$_error = error_get_last();
	if ($_error && in_array($_error['type'], array(1, 4, 16, 64, 256, 4096, E_ALL))) {
		$content = "";
		$content .= '你的代码出错了：\n';
		$content .= '致命错误:' . $_error['message'] . '\n';
		$content .= '文件:' . $_error['file'] . '\n';
		$content .= '在第' . $_error['line'] . '行\n\n';
		//file_put_contents(LOGS.'/app_error.log', $content, FILE_APPEND);
		writeLog($content, 'app_error.log', DEBUG);
	}
}
register_shutdown_function("cache_shutdown_error");
try{
	app::instance()->run();
}catch(FatalException $e){
	writeLog('app run fatal exception, message: '.$e->getMessage() , 'app_error.log', DEBUG);
}catch(Exception $e){
	writeLog('app run exception, message: '.$e->getMessage(), 'app_error.log', DEBUG);
}
class FatalException extends Exception{}

class app{
	private static $self;
	public static function instance(){
		if(self::$self==null){
			self::$self = new self();
		}
		return self::$self;
	}
	public function run(){
		global $argv;
		if(count($argv)<2){
			throw new FatalException('app run argv error. argv: '.join(' ',$argv));
		}
		$runnerModule = $argv[1];
		if(!in_array($runnerModule, ['-test'])){
			throw new FatalException('app run module error. module: '.$runnerModule);
		}
		$className = ltrim($runnerModule,'-');
		$file = ROOT.'class/'.$className.'.class.php';
		if(!is_file($file)){
			throw new FatalException('app run file not exist. file: '.$file);
		}
		include($file);
		$className::instance()->run();
	}
}
