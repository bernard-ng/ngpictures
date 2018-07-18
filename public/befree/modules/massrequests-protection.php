<?php
//Mass Requests Protection
$table = $prefix . 'massrequests-settings';
$query = $mysqli->query("SELECT * FROM `$table`");
$row   = $query->fetch_assoc();

if ($row['protection'] == 1) {
    
    if (!isset($_SESSION)) {
        @session_start();
    }
    
    //Many requests for less than 0.1 seconds (By Default)
    if (isset($_SESSION['last_session_request']) && $_SESSION['last_session_request'] > (time() - 0.1)) {
        
        $type = "Mass Requests";
        
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
	
    @$_SESSION['last_session_request'] = time();
}
?>