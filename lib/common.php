<?php
/**
 * @author pieces
 * 2018/01/26
 */

/**
 * 写文件日志
 * @param string $content 内容
 * @param string $file 文件
 * @param boolean $print 是否打印
 * @param string $mode 模式
 */
function writeLog($content,$file='stdout.log',$print=false,$mode='a'){
	if(empty($content)){
		return ;
	}
	if(empty($file)){
		$file = LOGS.'stdout_'.date('Y-m-d').'.log';
	}else{
		$arrs = explode('.',$file);
		//$file = LOGS.$arrs[0].'_'.date('Y-m-d').'.'.$arrs[1]; 
		$file = LOGS.$arrs[0].'.'.$arrs[1];
	}
	if($mode=='a'){
		@file_put_contents($file, $content." [".date('Y-m-d H:i:s')."]\r\n", FILE_APPEND|LOCK_EX);
	}else{
		@file_put_contents($file, $content." [".date('Y-m-d H:i:s')."]\r\n");
	}
	if($print){
		echo($content."\n");
	}
}