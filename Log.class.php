<?php 

//CONSTANTES
define("NIVEL_LOG", 0); // Define el nivel de log (0: INACTIVO, 1: ERROR, 2: DEBUG, 3: INFO)


//DEFINICION DE CLASE
class Log {


    private $logConstructor = [];

    public function setLog($message = 'debug', $type = 2)
    {
        if ($type > NIVEL_LOG) {
            return; 
        }

        $typeText = $type === 1 ? '[ERROR]' : ($type === 2 ? '[DEBUG]' : '[INFO]');

        $log = [];
        $log[] = $typeText;
        $log[] = date('(d/m/Y) - (h:i:s)');
        $log[] = $this->getCurrentUrl();
        $log[] = $message;

        $this->logConstructor[] = implode(" ", $log);
        echo implode(" ", $log) . "<br>";
        $this->printLog(end($this->logConstructor));
    }


    private function printLog($log)
    {
        $logDir = dirname(__FILE__) . "/logs/";
        if (!is_dir($logDir)) { mkdir($logDir); }

        $logDir = $logDir . date("Y") . "/";
        if (!is_dir($logDir)) { mkdir($logDir); }

        $logDir = $logDir . date("M") . "/";
        if (!is_dir($logDir)) { mkdir($logDir); }

        file_put_contents($logDir . date('YMd') . ".log", $log . PHP_EOL, FILE_APPEND);
    }


    private function getCurrentUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        return $protocol . "://" . $host . $uri;
    }


}


/** 
 * EJEMPLO DE USO
 
    *$logger = new Log();
    *$logger->setLog("Primera entrada", 1);
    *$logger->setLog("Segunda entrada", 2); 
    *$logger->setLog("Tercera entrada", 3); 

*/
