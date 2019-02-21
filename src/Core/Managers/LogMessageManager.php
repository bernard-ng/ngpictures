<?php
namespace Framework\Managers;

final class LogMessageManager
{

    /**
     * ajout d'un message de log
     *
     * @param string $file
     * @param string $msg
     * @return void
     */
    public static function register(string $file, $e)
    {
        $time = date("d-M H:i");
        $last_log = date("d-M-Y  H:i:s");

        if (is_object($e)) {
            $message = "* ".$e->getFile()."\t".$e->getLine()."\n\t\t=> {$time} : {$e->getMessage()}  \n\n";
        } else {
            $message = "* ".$file."\n\t\t=> {$time} : {$e}  \n\n";
        }

        $header =
        "#*************************************************************
        AUTHOR         :    Bernard-ng
        PROJECT        :    NG-PICTURES
        LINK           :    https://larytech.com
        BUILT AT       :    {$last_log}
**************************************************************
[NG-PICTURES MESSAGES LOGS] \n\n";


        $file = fopen(ROOT."/system.log", "a+");

        if (empty(file_get_contents(ROOT."/system.log")) or file_get_contents(ROOT."/system.log")[0] !== "#") {
            fwrite($file, $header);
        }

        fwrite($file, $message);
        fclose($file);
    }


    /**
     * suppression d'un fichier log
     * juste le contenu
     *
     * @return void
     */
    public static function clear()
    {
        $file = fopen(ROOT."/system.log", "w");
        fclose($file);
    }
}
