<?php
//Proxy Protection
$table = $prefix . 'proxy-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['protection'] == 1) {
    
    //Method 1
    $url = 'http://proxy.mind-media.com/block/proxycheck.php?ip=' . $ip . '';
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
    $proxy_check = curl_exec($ch);
    curl_close($ch);
    
    if ($proxy_check == "Y") {
        
        $type = "Proxy";
        
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
        
        echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '" />';
        exit;
    }
}

//Method 2
if ($row['protection2'] == 1) {
    $proxy_headers = array(
        'HTTP_VIA',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED',
        'HTTP_FORWARDED_FOR_IP',
        'HTTP_PROXY_CONNECTION'
    );
    foreach ($proxy_headers as $x) {
        if (isset($_SERVER[$x])) {
            
            $type = "Proxy";
            
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
            
            echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '" />';
            exit;
        }
    }
}

//Method 3
if ($row['protection3'] == 1) {
    $ports = array(
        8080,
        80,
        81,
        1080,
        6588,
        8000,
        3128,
        553,
        554,
        4480
    );
    foreach ($ports as $port) {
        if (@fsockopen($_SERVER['REMOTE_ADDR'], $port, $errno, $errstr, 30)) {
            
            $type = "Proxy";
            
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
            
            echo '<meta http-equiv="refresh" content="0;url=' . $row['redirect'] . '" />';
            exit;
        }
    }
}
?>