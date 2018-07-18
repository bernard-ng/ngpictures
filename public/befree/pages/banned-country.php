<?php
include "header.php";
$table = $prefix . 'pages-layolt';
$query = $mysqli->query("SELECT * FROM `$table` WHERE page='Banned_Country'");
$row   = $query->fetch_assoc();
?>
        <br />
        <div class="row">
          <div class="col-lg-12">
              <div class="jumbotron">
                <center>
				<div class="alert alert-danger" style="background-color: #d9534f; color: white;">
                    <h4 class="alert-heading"><?php
echo html_entity_decode($row['text']);
?></h4>
                </div><br />
				
                    <p style="font-size: 50px;">
<span class="fa-stack fa-lg">
  <i class="fas fa-globe fa-stack-1x"></i>
  <i class="fas fa-ban fa-stack-2x text-danger"></i>
</span></p>
<?php
//Getting Real IP Address
function get_realip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'Unknown';
    return $ipaddress;
}

$ip = $_SERVER['REMOTE_ADDR'];
$useragent = $_SERVER['HTTP_USER_AGENT'];

//Getting Country
$url = 'http://extreme-ip-lookup.com/json/' . $ip;
$ch  = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_REFERER, "https://google.com");
$ip_data = curl_exec($ch);
curl_close($ch);

$ip_data = @json_decode($ipcontent);
if ($ip_data && $ip_data->{'status'} == 'success') {
    $country      = $ip_data->{'country'};
} else {
	$country      = "Unknown";
}

$table2      = $prefix . 'bans-country';
$querybanned = $mysqli->query("SELECT * FROM `$table2` WHERE country='$country'");
$banned      = mysqli_num_rows($querybanned);
$row         = mysqli_fetch_array($querybanned);
$redirect    = $row['redirect'];
$url         = $row['url'];
if ($redirect == 1) {
    echo '<br /><center>You will be redirected</center><br />
<meta http-equiv="refresh" content="4;url=' . $url . '">';
}
?>
                <h5>Please contact with the webmaster of the website if you think something is wrong.</h5>
				
				<br />
	            <a href="mailto:<?php echo $rowst['email']; ?>" class="btn btn-primary btn-block" target="_blank"><i class="fas fa-envelope"></i> Contact</a>
                
                </center>
              </div>
          </div>
        </div>

<?php
include "footer.php";
?>