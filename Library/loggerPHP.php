<?php
namespace Library;
class loggerPHP{
private $logFile;
private $propertyFileHandle;
private static $instance;
private $messageLog ='{DATE} {MESSAGE}';


public function getLogFile(){
	return $this->logFile;
}
public function __construct($logFile) {
$this->logFile = $logFile;
$handle = fopen($this->logFile,'a+');
$this->propertyFileHandle=$handle;
}
public function write($message){
	$now = new \DateTime;
	$format_data = $now->format("Y-m-d h:i:s");
	$logEntry = str_replace(array('{DATE}','{MESSAGE}'),array($format_data,$message),$this->messageLog).PHP_EOL;
	fwrite($this->propertyFileHandle,$logEntry);
    $array = file($this->logFile);
    if(count($array)>=20){
//        $listLog = fopen($nameFile,'w');
//        fclose($listLog);
        $indexLog = fopen('count.txt','r');
        $counter = (int) fread($indexLog,20);
        fclose($indexLog);
        $counter++;
        $numberLog = 'log/'.$counter.'_log.txt';
        $indexLog = fopen('count.txt','w');
        fwrite($indexLog,$counter);
        fclose($indexLog);
        $listLog = fopen($numberLog,'w+');
        fclose($listLog);
        //echo ($indexLog);
        copy($this->logFile,$numberLog);
        ftruncate($this->propertyFileHandle,'0');
    }
}
public static function getInstance(){
    if(!self::$instance){
        self::$instance = new loggerPHP('text.txt');
    }
        return self::$instance;
}
    public function View(){
        $array = file($this->logFile);
        $dates = array();

        foreach ($array as $nameController){
            $dates[substr($nameController,0,11)][substr($nameController,11,9)]=substr($nameController,20);
        }
//        die(var_dump($dates));
        return $dates;
    }

    public function trunk(){
        file_put_contents($this->logFile,"");
    }
public function __destruct(){
	fclose($this->propertyFileHandle);
}

}