<?php
namespace Ng\Core\Managers;

final class LogMessageManager
{
    public static function register($file, $msg)
    {
        $time = date("Y-m-d H:i:s");
        $last_log = date("d M Y - H:i:s");
        $message = "* ".$file." => {$time} : {$msg}  \n";

        $header =
        "#*************************************************************
        AUTHOR         :    Bernard-ng                       
        PROJECT        :    NG-PICTURES
        LINK           :    <a href='http://ngpictures.pe.hu'>Bernard-ng</a>

        BUILD DATE     :    {$last_log}
**************************************************************
[NG-PICTURES MESSAGES LOGS] \n\n";

        $file = fopen(ROOT."/system-logs", "a+");

        if (empty(file_get_contents(ROOT."/system-logs")) or file_get_contents(ROOT."/system-logs")[0] !== "#") {
            fwrite($file, $header);
        }

        fwrite($file, $message);
        fclose($file);
    }

    public static function clear()
    {
        $file = fopen(ROOT."/system-logs", "w");
        fclose($file);
    }

    public static function show()
    {
        $back = $_SERVER['HTTP_REFERER'] ?? "/home";
        echo '<a href='.$back.'> << Back </a>';
        echo "<br><br>";
        echo "<pre>";
        echo file_get_contents(ROOT."/system-logs");
        echo "</pre>";
    }
}
