<?php
//Tor Protection
$table = $prefix . 'tor-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['protection'] == 1) {
    
    function isTorExitNode()
    {
        $serverPort = $_SERVER['SERVER_PORT'];
        @$remoteAddr = reverseIp($ip);
        @$serverAddr = reverseIp($_SERVER['SERVER_ADDR']);
        $placeholders = '%s.%s.%s.ip-port.exitlist.torproject.org';
        $name         = sprintf($placeholders, $remoteAddr, $serverPort, $serverAddr);
        return (gethostbyname($name) === '127.0.0.2');
    }
    
    function reverseIp($ip)
    {
        $ipParts = explode('.', $ip);
        return $ipParts[3] . '.' . $ipParts[2] . '.' . $ipParts[1] . '.' . $ipParts[0];
    }
    
    if (isTorExitNode()) {
        
        $type = "TOR Detected";
        
        //Logging
        if ($row['logging'] == 1) {
            psec_logging($mysqli, $prefix, $type);
        }
        
        //AutoBan
        if ($row['autoban'] == 1) {
            psec_autoban($mysqli, $prefix, $type);
        }
        
        //E-Mail Notification
        if ($srow['mail_notifications'] == 1 && $row['mail'] == 1) {
            psec_mail($mysqli, $prefix, $site_url, $projectsecurity_path, $type, $srow['email']);
        }
        
        echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '';
        exit;
    }
}
?>